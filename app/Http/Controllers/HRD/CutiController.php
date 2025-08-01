<?php

namespace App\Http\Controllers\HRD;

use App\Http\Controllers\Controller;
use App\Http\Requests\HRD\Cuti\StoreCutiRequest;
use App\Http\Requests\HRD\Cuti\UpdateCutiRequest;
use App\Models\Cuti;
use Illuminate\Http\Request;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cuti = Cuti::with('karyawan')->get();
        return view('hrd.cutis.index', compact('cuti'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hrd.cutis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCutiRequest $request)
    {
        $cuti = Cuti::create($request->validated());
        
        // Generate leave document from template if needed
        if ($request->has('generate_document')) {
            $this->generateLeaveDocument($cuti);
        }
        
        return redirect()->route('hrd.pengajuan-cuti')->with('success', 'Cuti berhasil ditambahkan!');
    }

    /**
     * Generate leave document from template
     */
    private function generateLeaveDocument(Cuti $cuti)
    {
        // Path to leave form template
        $templatePath = resource_path('forms/FR-ADM-004 TEMPLATE SURAT IJIN.doc');
        
        if (file_exists($templatePath)) {
            // Logic to populate template with leave data
            // This would typically involve a document processing library
            // For now, we'll store the reference
            $cuti->update([
                'document_template_used' => 'FR-ADM-004 TEMPLATE SURAT IJIN.doc',
                'document_generated_at' => now()
            ]);
        }
    }

    /**
     * Download leave form template
     */
    public function downloadTemplate()
    {
        $templatePath = resource_path('forms/FR-ADM-004 FORM SURAT IJIN.xlsx');
        
        if (file_exists($templatePath)) {
            return response()->download($templatePath, 'Form_Surat_Ijin.xlsx');
        }
        
        abort(404, 'Template not found');
    }

    /**
     * Generate official leave document
     */
    public function generateDocument(Cuti $cuti)
    {
        $templatePath = resource_path('forms/FR-ADM-004 TEMPLATE SURAT IJIN.doc');
        
        if (file_exists($templatePath)) {
            // In a real implementation, you would use a library like PHPWord
            // to populate the template with actual data
            return response()->download($templatePath, 'Surat_Ijin_' . $cuti->karyawan->nama . '.doc');
        }
        
        abort(404, 'Template not found');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cuti $cuti)
    {
        return view('hrd.cutis.show', compact('cuti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cuti $cuti)
    {
        return view('hrd.cutis.edit', compact('cuti'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCutiRequest $request, Cuti $cuti)
    {
        $cuti->update($request->validated());
        return redirect()->route('hrd.pengajuan-cuti')->with('success', 'Cuti berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cuti $cuti)
    {
        $cuti->delete();
        return redirect()->route('hrd.pengajuan-cuti')->with('success', 'Cuti berhasil dihapus!');
    }

    public function approve(Cuti $cuti)
    {
        $cuti->update(['status' => 'disetujui']);
        return redirect()->route('hrd.pengajuan-cuti')->with('success', 'Cuti berhasil disetujui!');
    }

    public function reject(Cuti $cuti)
    {
        $cuti->update(['status' => 'ditolak']);
        return redirect()->route('hrd.pengajuan-cuti')->with('success', 'Cuti berhasil ditolak!');
    }
}
