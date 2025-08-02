<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\HutangKaryawan;
use App\Models\PenaltiSP;
use App\Models\Karyawan;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PembayaranController extends Controller
{
    /**
     * Display a listing of payments
     */
    public function index(Request $request)
    {
        $query = collect();
        
        // Get hutang payments
        $hutangPayments = HutangKaryawan::with('karyawan')
            ->when($request->status, function ($q, $status) {
                return $q->where('status', $status);
            })
            ->when($request->search, function ($q, $search) {
                return $q->whereHas('karyawan', function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                          ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($request->date_from, function ($q, $date) {
                return $q->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                return $q->whereDate('created_at', '<=', $date);
            })
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'hutang',
                    'karyawan' => $item->karyawan,
                    'amount' => $item->amount,
                    'description' => $item->asal_hutang,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'original' => $item
                ];
            });

        // Get penalty payments
        $penaltiPayments = PenaltiSP::with(['karyawan', 'suratPeringatan'])
            ->when($request->status, function ($q, $status) {
                $mappedStatus = $status === 'lunas' ? 'paid' : ($status === 'belum_lunas' ? 'pending' : $status);
                return $q->where('status_pembayaran', $mappedStatus);
            })
            ->when($request->search, function ($q, $search) {
                return $q->whereHas('karyawan', function ($query) use ($search) {
                    $query->where('nama_lengkap', 'like', "%{$search}%")
                          ->orWhere('nik', 'like', "%{$search}%");
                });
            })
            ->when($request->date_from, function ($q, $date) {
                return $q->whereDate('created_at', '>=', $date);
            })
            ->when($request->date_to, function ($q, $date) {
                return $q->whereDate('created_at', '<=', $date);
            })
            ->latest()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'type' => 'penalti',
                    'karyawan' => $item->karyawan,
                    'amount' => $item->jumlah_penalti,
                    'description' => 'Penalti SP: ' . ($item->suratPeringatan->jenis_sp ?? 'Unknown'),
                    'status' => $item->status_pembayaran === 'paid' ? 'lunas' : 'belum_lunas',
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'original' => $item
                ];
            });

        // Combine and sort payments
        $payments = $hutangPayments->merge($penaltiPayments)
            ->sortByDesc('created_at')
            ->values();

        // Pagination
        $perPage = $request->get('per_page', 15);
        $currentPage = $request->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paymentsForPage = $payments->slice($offset, $perPage);
        
        $paginatedPayments = new \Illuminate\Pagination\LengthAwarePaginator(
            $paymentsForPage,
            $payments->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // Statistics
        $stats = [
            'total_payments' => $payments->count(),
            'total_amount' => $payments->sum('amount'),
            'pending_payments' => $payments->where('status', 'belum_lunas')->count(),
            'completed_payments' => $payments->where('status', 'lunas')->count(),
            'hutang_payments' => $hutangPayments->count(),
            'penalti_payments' => $penaltiPayments->count(),
        ];

        return view('keuangan.pembayaran.index', compact('paginatedPayments', 'stats'));
    }

    /**
     * Show the form for creating a new payment
     */
    public function create()
    {
        $karyawans = Karyawan::where('status_karyawan', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        return view('keuangan.pembayaran.create', compact('karyawans'));
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:hutang,advance,bonus,reimburse',
            'karyawan_id' => 'required|exists:karyawans,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,transfer,check',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            // Create hutang record for tracking
            $hutang = HutangKaryawan::create([
                'karyawan_id' => $request->karyawan_id,
                'amount' => $request->amount,
                'asal_hutang' => $request->description,
                'status' => 'lunas',
                'tanggal_pembayaran' => $request->payment_date,
                'metode_pembayaran' => $request->payment_method,
                'nomor_referensi' => $request->reference_number,
                'catatan' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Create notification
            $karyawan = Karyawan::find($request->karyawan_id);
            Notification::create([
                'user_id' => $karyawan->created_by ?? Auth::id(),
                'type' => 'payment_processed',
                'title' => 'Payment Processed',
                'message' => "Payment of Rp " . number_format($request->amount) . " has been processed for " . $karyawan->nama_lengkap,
                'data' => json_encode([
                    'payment_id' => $hutang->id,
                    'karyawan_id' => $request->karyawan_id,
                    'amount' => $request->amount,
                    'type' => $request->type
                ]),
                'action_url' => route('keuangan.pembayaran.show', $hutang->id),
                'icon' => 'ph-money',
                'color' => 'text-success'
            ]);

            DB::commit();
            return redirect()->route('keuangan.pembayaran.index')
                ->with('success', 'Payment recorded successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified payment
     */
    public function show($id)
    {
        // Try to find in hutang first
        $payment = HutangKaryawan::with('karyawan')->find($id);
        $type = 'hutang';
        
        if (!$payment) {
            // Try to find in penalti
            $payment = PenaltiSP::with(['karyawan', 'suratPeringatan'])->find($id);
            $type = 'penalti';
        }

        if (!$payment) {
            abort(404, 'Payment not found');
        }

        return view('keuangan.pembayaran.show', compact('payment', 'type'));
    }

    /**
     * Show the form for editing the specified payment
     */
    public function edit($id)
    {
        $payment = HutangKaryawan::with('karyawan')->findOrFail($id);
        $karyawans = Karyawan::where('status_karyawan', 'aktif')
            ->orderBy('nama_lengkap')
            ->get();

        return view('keuangan.pembayaran.edit', compact('payment', 'karyawans'));
    }

    /**
     * Update the specified payment
     */
    public function update(Request $request, $id)
    {
        $payment = HutangKaryawan::findOrFail($id);
        
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,transfer,check',
            'reference_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
            'status' => 'required|in:lunas,belum_lunas'
        ]);

        $payment->update([
            'amount' => $request->amount,
            'asal_hutang' => $request->description,
            'status' => $request->status,
            'tanggal_pembayaran' => $request->payment_date,
            'metode_pembayaran' => $request->payment_method,
            'nomor_referensi' => $request->reference_number,
            'catatan' => $request->notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('keuangan.pembayaran.index')
            ->with('success', 'Payment updated successfully');
    }

    /**
     * Remove the specified payment
     */
    public function destroy($id)
    {
        $payment = HutangKaryawan::findOrFail($id);
        
        // Only allow deletion of pending payments
        if ($payment->status === 'lunas') {
            return back()->with('error', 'Cannot delete completed payments');
        }

        $payment->delete();
        
        return back()->with('success', 'Payment record deleted successfully');
    }
}