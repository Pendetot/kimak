<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuratPeringatanRequest;
use App\Http\Requests\UpdateSuratPeringatanRequest;
use App\Models\SuratPeringatan;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class SuratPeringatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SuratPeringatan::with('karyawan');

        // Filter berdasarkan jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan karyawan
        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        $suratPeringatans = $query->latest()->paginate(10);
        $karyawans = Karyawan::all();

        return view('hrd.surat_peringatans.index', compact('suratPeringatans', 'karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        return view('hrd.surat_peringatans.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuratPeringatanRequest $request)
    {
        SuratPeringatan::create($request->validated());

        return redirect()->route('hrd.surat-peringatans.index')
            ->with('success', 'Surat peringatan berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->load('karyawan');
        
        // Get penalty months and history
        $penaltyMonths = $suratPeringatan->penalty_months ?? 1;
        $historySuratPeringatan = SuratPeringatan::where('karyawan_id', $suratPeringatan->karyawan_id)
                                                ->where('id', '!=', $suratPeringatan->id)
                                                ->orderBy('tanggal_sp', 'desc')
                                                ->get();
        
        return view('hrd.surat_peringatans.show', compact('suratPeringatan', 'penaltyMonths', 'historySuratPeringatan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPeringatan $suratPeringatan)
    {
        $karyawans = Karyawan::all();
        return view('hrd.surat_peringatans.edit', compact('suratPeringatan', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratPeringatanRequest $request, SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->update($request->validated());

        return redirect()->route('hrd.surat-peringatans.index')
            ->with('success', 'Surat peringatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->delete();

        return redirect()->route('hrd.surat-peringatans.index')
            ->with('success', 'Surat peringatan berhasil dihapus.');
    }

    /**
     * Export surat peringatan to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = SuratPeringatan::with('karyawan');

        // Apply same filters as index
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('karyawan_id')) {
            $query->where('karyawan_id', $request->karyawan_id);
        }

        $suratPeringatans = $query->get();

        // You can implement PDF generation here using libraries like TCPDF or DomPDF
        // For now, return a simple response
        return response()->json([
            'message' => 'Export PDF functionality will be implemented',
            'count' => $suratPeringatans->count()
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $suratPeringatans = SuratPeringatan::with('karyawan')->get();
        
        $statistics = [
            'total' => $suratPeringatans->count(),
            'by_jenis' => $suratPeringatans->groupBy('jenis')->map->count(),
            'by_status' => $suratPeringatans->groupBy('status')->map->count(),
            'recent' => $suratPeringatans->sortByDesc('created_at')->take(5)
        ];

        return response()->json($statistics);
    }
}