<?php

namespace App\Http\Controllers\HRD;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    /**
     * Display a listing of all available forms.
     */
    public function index()
    {
        $forms = $this->getAvailableForms();
        return view('forms.index', compact('forms'));
    }

    /**
     * Download a specific form template.
     */
    public function download($filename)
    {
        $filePath = resource_path('forms/' . $filename);
        
        if (!file_exists($filePath)) {
            abort(404, 'Form template not found');
        }

        return Response::download($filePath);
    }

    /**
     * Get all available form templates organized by category.
     */
    private function getAvailableForms()
    {
        return [
            'interview_assessment' => [
                'title' => 'Interview & Assessment Forms',
                'forms' => [
                    'FA1 FORMULIR INTERVIEW.docx' => 'Formulir Interview',
                    'FK001.xlsx' => 'Form Kualifikasi',
                    'FO001.xlsx' => 'Form Observasi',
                    'FP001.xlsx' => 'Form Penilaian',
                    'FS001.xlsx' => 'Form Seleksi'
                ]
            ],
            'health_psychological' => [
                'title' => 'Health & Psychological Assessment',
                'forms' => [
                    'SPT AAP 2025.xlsx' => 'Surat Pernyataan Tes AAP',
                    'draft spt.docx' => 'Draft SPT'
                ]
            ],
            'pkwt_contract' => [
                'title' => 'PKWT Contract Forms',
                'forms' => [
                    'FR ADM 006 FORM PKWT.xlsx' => 'Form PKWT',
                    'FR-ADM-006 TEMPLATE PKWT.docx' => 'Template PKWT'
                ]
            ],
            'bpjs_forms' => [
                'title' => 'BPJS Forms',
                'forms' => [
                    'FR-ADM-005 FORM BPJS.xlsx' => 'Form BPJS',
                    'FR-ADM-005 TEMPLATE BPJS PENDAFTARAN ATAU PERUBAHAN DATA.pdf' => 'Template BPJS'
                ]
            ],
            'spt_forms' => [
                'title' => 'SPT Forms',
                'forms' => [
                    'FR-ADM-007 FORM SPT.xlsx' => 'Form SPT',
                    'FR-ADM-007 TEMPLATE SPT.docx' => 'Template SPT'
                ]
            ],
            'document_receipt' => [
                'title' => 'Document Receipt Forms',
                'forms' => [
                    'FR-ADM-001 FORM TANDA TERIMA.xlsx' => 'Form Tanda Terima',
                    'FR-ADM-001 TEMPLATE TANDA TERIMA.xlsx' => 'Template Tanda Terima'
                ]
            ],
            'statement_forms' => [
                'title' => 'Statement Forms',
                'forms' => [
                    'FR-ADM-002 FORM SP MENTAATI PERATURAN.xlsx' => 'Form SP Mentaati Peraturan',
                    'FR-ADM-002 TEMPLATE SP MENTAATI PERATURAN.docx' => 'Template SP Mentaati Peraturan',
                    'FR-ADM-003 FORM SURAT PERNYATAAN PEMBAYARAN.xlsx' => 'Form Surat Pernyataan Pembayaran',
                    'FR-ADM-003 TEMPLATE SURAT PERNYATAAN GP.docx' => 'Template Surat Pernyataan GP'
                ]
            ],
            'permission_banking' => [
                'title' => 'Permission & Banking Forms',
                'forms' => [
                    'FR-ADM-004 FORM SURAT IJIN.xlsx' => 'Form Surat Ijin',
                    'FR-ADM-004 TEMPLATE SURAT IJIN.doc' => 'Template Surat Ijin',
                    '6. FORM BRI.pdf' => 'Form BRI'
                ]
            ],
            'additional_templates' => [
                'title' => 'Additional Forms & Templates',
                'forms' => [
                    'FR-ADM-006 SURAT pernyataan penyerahan ijazah.doc' => 'Surat Pernyataan Penyerahan Ijazah',
                    'TEMPLATE ADDENDUM.docx' => 'Template Addendum',
                    'TEMPLATE PKHL.docx' => 'Template PKHL',
                    'TEMPLATE UNDANGAN 2.xlsx' => 'Template Undangan',
                    'PROSES PELAMAR SAMPAI ADMINISTRASI.xlsx' => 'Proses Pelamar'
                ]
            ]
        ];
    }
}