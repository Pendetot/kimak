<?php

namespace App\Http\Controllers\HRD;

use App\Models\SuratPeringatan;
use App\Http\Requests\StoreSuratPeringatanRequest;
use App\Http\Requests\UpdateSuratPeringatanRequest;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\PenaltiSP;
use App\Models\HutangKaryawan;

use Illuminate\Support\Facades\DB;

class SuratPeringatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil ID surat peringatan terbaru untuk setiap karyawan
        $latestSuratPeringatanIds = SuratPeringatan::selectRaw('MAX(id) as id')
            ->groupBy('karyawan_id')
            ->pluck('id');

        // Ambil surat peringatan terbaru yang sesuai dengan filter jabatan
        $suratPeringatans = SuratPeringatan::with('user')
                                            ->whereIn('id', $latestSuratPeringatanIds) // Hanya sertakan SP terbaru
                                            ->get();
        return view('hrd.surat_peringatans.index', compact('suratPeringatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = $request->query('user_id');
        $karyawans = \App\Models\Karyawan::all();
        return view('hrd.surat_peringatans.create', compact('karyawans', 'userId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSuratPeringatanRequest $request)
    {
        $validatedData = $request->validated();

        $penaltyAmount = 0;
        if ($validatedData['jenis_sp'] === 'SP1') {
            $penaltyAmount = 100000;
        } elseif ($validatedData['jenis_sp'] === 'SP2') {
            $penaltyAmount = 200000;
        } elseif ($validatedData['jenis_sp'] === 'SP3') {
            $penaltyAmount = 300000;
        }

        $validatedData['penalty_amount'] = $penaltyAmount;

        DB::transaction(function () use ($validatedData, $penaltyAmount) {
            $suratPeringatan = SuratPeringatan::create($validatedData);
            $user = \App\Models\User::find($validatedData['karyawan_id']);
            $penaltyAmount = $validatedData['penalty_amount'] ?? 0;

            if ($penaltyAmount > 0 && $user && $user->hasRole(\App\Enums\RoleEnum::Karyawan)) {
                PenaltiSP::create([
                    'surat_peringatan_id' => $suratPeringatan->id,
                    'karyawan_id' => $validatedData['karyawan_id'],
                    'jumlah_penalti' => $penaltyAmount,
                    'tanggal_pencatatan' => now(),
                ]);

                HutangKaryawan::create([
                    'karyawan_id' => $validatedData['karyawan_id'],
                    'amount' => $penaltyAmount,
                    'keterangan' => 'Penalti ' . $validatedData['jenis_sp'],
                    'status' => 'belum_lunas',
                    'asal_hutang' => \App\Enums\AsalHutangEnum::SP->value,
                    'surat_peringatan_id' => $suratPeringatan->id,
                ]);
            }
        });

        return redirect()->route('hrd.surat-peringatan')->with('success', 'Surat Peringatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratPeringatan $suratPeringatan)
    {
        $historySuratPeringatan = SuratPeringatan::where('karyawan_id', $suratPeringatan->karyawan_id)
                                                ->orderBy('tanggal_sp', 'asc')
                                                ->get();

        $penaltyMonths = 0;
        if ($suratPeringatan->jenis_sp->value === 'SP1') {
            $penaltyMonths = 3;
        } elseif ($suratPeringatan->jenis_sp->value === 'SP2') {
            $penaltyMonths = 6;
        }

        return view('hrd.surat_peringatans.show', compact('suratPeringatan', 'historySuratPeringatan', 'penaltyMonths'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratPeringatan $suratPeringatan)
    {
        $karyawans = \App\Models\Karyawan::all();
        return view('hrd.surat_peringatans.edit', compact('suratPeringatan', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuratPeringatanRequest $request, SuratPeringatan $suratPeringatan)
    {
        $validatedData = $request->validated();

        $penaltyAmount = 0;
        if ($validatedData['jenis_sp'] === 'SP1') {
            $penaltyAmount = 100000;
        } elseif ($validatedData['jenis_sp'] === 'SP2') {
            $penaltyAmount = 200000;
        }

        $validatedData['penalty_amount'] = $penaltyAmount;

        $suratPeringatan->update($validatedData);

        $installments = 0;
        if ($validatedData['jenis_sp'] === 'SP1') {
            $installments = 3;
        } elseif ($validatedData['jenis_sp'] === 'SP2') {
            $installments = 6;
        }

        // Delete existing HutangKaryawan entries for this SuratPeringatan
        \App\Models\HutangKaryawan::where('karyawan_id', $validatedData['karyawan_id'])
                                ->where('asal_hutang', \App\Enums\AsalHutangEnum::SP->value)
                                ->delete();

        if ($penaltyAmount > 0) {
            for ($i = 0; $i < $installments; $i++) {
                \App\Models\HutangKaryawan::create([
                    'karyawan_id' => $validatedData['karyawan_id'],
                    'amount' => $penaltyAmount / $installments,
                    'keterangan' => 'Penalti SP ' . $validatedData['jenis_sp'] . ' - Angsuran ' . ($i + 1),
                    'status' => 'belum_lunas',
                    'asal_hutang' => \App\Enums\AsalHutangEnum::SP->value,
                    'surat_peringatan_id' => $suratPeringatan->id,
                ]);
            }
        }

        return redirect()->route('hrd.surat-peringatan')->with('success', 'Surat Peringatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratPeringatan $suratPeringatan)
    {
        $suratPeringatan->delete();
        return redirect()->route('hrd.surat-peringatan')->with('success', 'Surat Peringatan berhasil dihapus.');
    }

    public function penaltiSpIndex()
    {
        $suratPeringatans = SuratPeringatan::with('user')->get();
        return view('keuangan.penalti_sp.index', compact('suratPeringatans'));
    }
}