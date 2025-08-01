<?php

namespace App\Http\Controllers\HRD;

use App\Models\Pelamar;
use App\Http\Requests\Pelamar\StorePelamarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\RejectionEmail;
use App\Mail\ApprovalEmail;
use App\Models\User;
use App\Models\TidakHadir;
use App\Models\PatResult;
use App\Models\PsikotestResult;
use App\Models\HealthTestResult;
use App\Models\InterviewResult;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Services\Pelamar\PelamarService;
use Illuminate\Support\Facades\Notification;
use App\Notifications\InterviewAttendanceNotification;

use App\Http\Controllers\Controller;

class PelamarController extends Controller
{
    protected $pelamarService;

    public function __construct(PelamarService $pelamarService)
    {
        $this->pelamarService = $pelamarService;
    }

    public function index(Request $request)
    {
        $query = Pelamar::query();

        if ($request->has('status') && $request->input('status') != '') {
            $query->where('interview_attendance_status', $request->input('status'));
        }

        $pelamars = $query->get();
        return view('hrd.administrasi_pelamar.index', compact('pelamars'));
    }

    public function create()
    {
        return view('pelamar.create');
    }

    public function store(StorePelamarRequest $request)
    {
        $validatedData = $request->validated();

        // Handle file uploads
        $fileFields = [
            'foto_ktp',
            'foto_kartu_keluarga',
            'foto_ijazah_terakhir',
            'foto_sertifikat_keahlian1',
            'foto_sertifikat_keahlian2',
            'sertifikat_beladiri',
            'foto_full_body',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $validatedData[$field] = $request->file($field)->store('pelamar_docs', 'public');
            } else {
                $validatedData[$field] = null; // Ensure null if not provided
            }
        }

        // Handle boolean fields (checkboxes)
        $booleanFields = [
            'punya_tato',
            'perokok',
            'suka_berorganisasi',
            'bersedia_lembur',
            'bersedia_dipindahkan_bagian_lain',
            'bersedia_ikut_pembinaan_pelatihan',
            'bersedia_penuhi_peraturan_pengamanan',
            'bersedia_dipindahkan_luar_daerah',
            'pernyataan_kebenaran_dokumen',
            'pernyataan_lamaran_kerja',
            'punya_pengalaman_kerja',
        ];

        foreach ($booleanFields as $field) {
            $validatedData[$field] = $request->boolean($field);
        }

        // Handle reference_name based on referenceSwitch
        if (!$request->has('referenceSwitch')) {
            $validatedData['reference_name'] = null;
        }

        $validatedData['status_lamaran'] = 'pending'; // Default status

        Pelamar::create($validatedData);

        return redirect()->back()->with('success', 'Lamaran Anda berhasil dikirim!');
    }

    public function show(Pelamar $pelamar)
    {
        return view('pelamar.show', compact('pelamar'));
    }

    public function edit(Pelamar $pelamar)
    {
        return view('pelamar.edit', compact('pelamar'));
    }

    public function update(Request $request, Pelamar $pelamar)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pelamars,email,' . $pelamar->id,
            'telepon' => 'required|string|max:20',
            'alamat' => 'required|string',
            'pendidikan_terakhir' => 'required|string|max:255',
            'pengalaman_kerja' => 'nullable|string',
            'posisi_dilamar' => 'required|string|max:255',
            'status' => 'required|string|in:pending,diterima,ditolak',
        ]);

        $pelamar->update($validatedData);

        return redirect()->route('hrd.administrasi-pelamar')->with('success', 'Data pelamar berhasil diperbarui.');
    }

    public function destroy(Pelamar $pelamar)
    {
        $pelamar->delete();
        return redirect()->route('hrd.administrasi-pelamar')->with('success', 'Data pelamar berhasil dihapus.');
    }

    public function approve(Pelamar $pelamar)
    {
        $pelamar->status = 'diterima';
        $pelamar->save();

        // Create a new user
        $password = Str::random(8);
        $user = User::create([
            'name' => $pelamar->nama_lengkap,
            'email' => $pelamar->email,
            'password' => Hash::make($password),
            'role' => 'pelamar',
        ]);

        $pelamar->user_id = $user->id;
        $pelamar->save();

        // Determine time of day for greeting
        $hour = now()->hour;
        $greeting = '';
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'PAGI';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'SIANG';
        } else {
            $greeting = 'MALAM';
        }

        // Send job offer email
        $jobOfferData = [
            'nama_pelamar' => $pelamar->nama_lengkap,
            'email' => $pelamar->email,
            'greeting' => $greeting,
            'posisi_ditawarkan' => $pelamar->posisi_dilamar, // Assuming this field exists
            'tanggal_bergabung' => now()->addDays(7)->translatedFormat('d F Y'), // Example: 7 days from now
        ];

        if ($pelamar->email) {
            try {
                $this->pelamarService->sendJobOfferEmail($jobOfferData);
                return redirect()->back()->with('success', 'Pelamar berhasil diterima dan email penawaran kerja telah dikirim.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Pelamar berhasil diterima, tetapi gagal mengirim email penawaran kerja: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Pelamar berhasil diterima.');
    }

    public function reject(Pelamar $pelamar)
    {
        $pelamar->status = 'ditolak';
        $pelamar->save();

        // Determine time of day for greeting
        $hour = now()->hour;
        $greeting = '';
        if ($hour >= 5 && $hour < 12) {
            $greeting = 'PAGI';
        } elseif ($hour >= 12 && $hour < 18) {
            $greeting = 'SIANG';
        } else {
            $greeting = 'MALAM';
        }

        $data = [
            'nama_pelamar' => $pelamar->nama_lengkap,
            'greeting' => $greeting,
        ];

        if ($pelamar->email) {
            try {
                $this->pelamarService->sendRejectionEmail($data);
                return redirect()->back()->with('success', 'Pelamar berhasil ditolak dan pesan penolakan dikirim via email.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Pelamar berhasil ditolak, tetapi gagal mengirim pesan penolakan via email: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Pelamar berhasil ditolak.');
    }

    public function filter(Request $request)
    {
        $query = Pelamar::query();

        // Filter by tinggi badan
        if ($request->has('tinggi_badan_min')) {
            $query->where('tinggi_badan', '>=', $request->input('tinggi_badan_min'));
        }

        // Filter by berat badan
        if ($request->has('berat_badan_ideal')) {
            $toleransi = $request->input('toleransi_berat_badan', 15);
            $berat_badan_max = $request->input('berat_badan_ideal') + $toleransi;
            $query->where('berat_badan', '<=', $berat_badan_max);
        }

        // Filter by usia
        if ($request->has('usia_min')) {
            $query->whereDate('tanggal_lahir', '<=', now()->subYears($request->input('usia_min')));
        }
        if ($request->has('usia_max')) {
            $query->whereDate('tanggal_lahir', '>=', now()->subYears($request->input('usia_max')));
        }

        // Filter by pendidikan terakhir
        if ($request->has('pendidikan_terakhir')) {
            $query->where('pendidikan_terakhir', $request->input('pendidikan_terakhir'));
        }

        // Filter by sertifikasi
        if ($request->has('sertifikasi')) {
            $sertifikasi = $request->input('sertifikasi');
            $query->where(function ($q) use ($sertifikasi) {
                $q->where('sertifikasi', 'like', '%' . $sertifikasi . '%')
                  ->orWhere('sertifikasi_pelamar', 'like', '%' . $sertifikasi . '%');
            });
        }

        $pelamars = $query->get();

        return response()->json($pelamars);
    }

    public function performValidation(Request $request, Pelamar $pelamar)
    {
        $isValid = true;

        $minHeight = Setting::where('key', 'min_height')->first()->value ?? 0;
        $maxWeightTolerance = Setting::where('key', 'max_weight_tolerance')->first()->value ?? 0;
        $minAge = Setting::where('key', 'min_age')->first()->value ?? 0;
        $maxAge = Setting::where('key', 'max_age')->first()->value ?? 0;
        $requiredEducation = Setting::where('key', 'required_education')->first()->value ?? '';
        $requiredCertifications = explode(',', Setting::where('key', 'required_certifications')->first()->value ?? '');

        // Validation logic here (using the same criteria as the filter)
        if ($pelamar->tinggi_badan < $minHeight) {
            $isValid = false;
        }

        if ($pelamar->berat_badan > ($pelamar->tinggi_badan - 100) + $maxWeightTolerance) {
            $isValid = false;
        }

        $usia = $pelamar->tanggal_lahir->age;
        if ($usia < $minAge || $usia > $maxAge) {
            $isValid = false;
        }

        if ($pelamar->pendidikan_terakhir !== $requiredEducation) {
            $isValid = false;
        }

        // You might need more sophisticated certificate checking
        $hasRequiredCertifications = false;
        foreach ($requiredCertifications as $sertifikat) {
            if (str_contains($pelamar->sertifikasi, $sertifikat) || str_contains($pelamar->sertifikasi_pelamar, $sertifikat)) {
                $hasRequiredCertifications = true;
                break;
            }
        }
        if (!$hasRequiredCertifications) {
            $isValid = false;
        }

        $pelamar->status_validasi = $isValid ? 'valid' : 'tidak_valid';
        $pelamar->save();

        return response()->json(['status_validasi' => $pelamar->status_validasi]);
    }

    public function generateInterviewInvitation(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'tanggal_interview' => 'required|date',
            'waktu_interview' => 'required|string',
            'via_interview' => 'required|string',
            'batas_konfirmasi_tanggal' => 'required|date',
            'batas_konfirmasi_waktu' => 'required|string',
        ]);

        $data = [
            'nama_kandidat' => $pelamar->nama_lengkap,
            'posisi_dilamar' => $pelamar->jenis_jabatan_pekerjaan,
            'tanggal_interview' => Carbon::parse($request->input('tanggal_interview'))->translatedFormat('l, d F Y'),
            'waktu_interview' => $request->input('waktu_interview'),
            'via_interview' => $request->input('via_interview'),
            'batas_konfirmasi_tanggal' => Carbon::parse($request->input('batas_konfirmasi_tanggal'))->translatedFormat('d F Y'),
            'batas_konfirmasi_waktu' => Carbon::parse($request->input('batas_konfirmasi_waktu'))->translatedFormat('H:i'),
        ];

        $pdf = Pdf::loadView('emails.interview_invitation_pdf', $data);
        $pdfContent = $pdf->output();
        $pdfBase64 = base64_encode($pdfContent);

        // Send WhatsApp message with PDF
        $whatsappApiUrl = Setting::where('key', 'whatsapp_api_url')->first();
        $whatsappApiKey = Setting::where('key', 'whatsapp_api_key')->first();

        if ($whatsappApiUrl && $whatsappApiKey && $pelamar->no_whatsapp) {
            try {
                $response = Http::post($whatsappApiUrl->value . '/send-document', [
                    'jid' => $pelamar->no_whatsapp . '@s.whatsapp.net',
                    'filename' => 'Undangan_Interview_' . str_replace(' ', '_', $pelamar->nama_lengkap) . '.pdf',
                    'base64_data' => $pdfBase64,
                    'api_key' => $whatsappApiKey->value, // Assuming your bot service uses an API key
                ]);

                if ($response->successful()) {
                    return response()->json(['message' => 'Undangan wawancara berhasil dibuat dan dikirim via WhatsApp.']);
                } else {
                    return response()->json(['message' => 'Undangan wawancara berhasil dibuat, tetapi gagal dikirim via WhatsApp: ' . $response->body(), 'error_code' => $response->status()], 500);
                }
            } catch (\Exception $e) {
                return response()->json(['message' => 'Undangan wawancara berhasil dibuat, tetapi gagal dikirim via WhatsApp: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'Undangan wawancara berhasil dibuat, tetapi tidak dikirim via WhatsApp (pengaturan tidak lengkap atau nomor WhatsApp tidak ada).']);
    }

    public function showConfirmationForm(Pelamar $pelamar)
    {
        return view('pelamar.confirm_interview', compact('pelamar'));
    }

    public function confirmInterview(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'attendance' => 'required|in:can_attend,cannot_attend',
        ]);

        $pelamar->interview_attendance_status = $request->input('attendance');
        $pelamar->save();

        // Notify HRD
        $hrdUsers = User::where('role', 'hrd')->get();
        foreach ($hrdUsers as $hrdUser) {
            $hrdUser->notify(new InterviewAttendanceNotification($pelamar));
        }

        return redirect()->route('pelamar.dashboard')->with('success', 'Konfirmasi kehadiran Anda telah disimpan.');
    }

    public function showPatForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.pat_result', compact('pelamar'));
    }

    public function storePatResult(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'score' => 'required|integer',
            'notes' => 'nullable|string',
        ]);

        $pelamar->patResult()->updateOrCreate(
            ['pelamar_id' => $pelamar->id],
            [
                'score' => $request->input('score'),
                'notes' => $request->input('notes'),
            ]
        );

        return redirect()->back()->with('success', 'Hasil PAT berhasil disimpan.');
    }

    public function showPsikotestForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.psikotest_result', compact('pelamar'));
    }

    public function storePsikotestResult(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'scan_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'conclusion' => 'required|string',
        ]);

        $scanPath = $pelamar->psikotestResult->scan_path ?? null;
        if ($request->hasFile('scan_file')) {
            if ($scanPath) {
                Storage::disk('public')->delete($scanPath);
            }
            $scanPath = $request->file('scan_file')->store('psikotest_scans', 'public');
        }

        $pelamar->psikotestResult()->updateOrCreate(
            ['pelamar_id' => $pelamar->id],
            [
                'scan_path' => $scanPath,
                'conclusion' => $request->input('conclusion'),
            ]
        );

        return redirect()->back()->with('success', 'Hasil Psikotest berhasil disimpan.');
    }

    public function showHealthTestForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.health_test_result', compact('pelamar'));
    }

    public function storeHealthTestResult(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'result' => 'required|in:fit,unfit,pending',
            'notes' => 'nullable|string',
        ]);

        $pelamar->healthTestResult()->updateOrCreate(
            ['pelamar_id' => $pelamar->id],
            [
                'result' => $request->input('result'),
                'notes' => $request->input('notes'),
            ]
        );

        return redirect()->back()->with('success', 'Hasil Tes Kesehatan berhasil disimpan.');
    }

    public function showInterviewForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.interview_result', compact('pelamar'));
    }

    public function storeInterviewResult(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'hrd_notes' => 'nullable|string',
            'ops_notes' => 'nullable|string',
            'decision' => 'required|in:recommended,not_recommended,pending',
            'q_about_yourself' => 'nullable|string',
            'q_reason_for_resigning' => 'nullable|string',
            'q_hobbies_organizations' => 'nullable|string',
            'q_why_interested' => 'nullable|string',
            'q_motivation' => 'nullable|string',
            'q_experience' => 'nullable|string',
            'q_skills_for_job' => 'nullable|string',
            'q_what_you_like_about_job' => 'nullable|string',
            'q_desired_salary' => 'nullable|string',
            'q_knowledge_of_position' => 'nullable|string',
            'doc_cv' => 'boolean',
            'doc_ktp' => 'boolean',
            'doc_kk' => 'boolean',
            'doc_ijazah' => 'boolean',
            'doc_paklaring' => 'boolean',
            'doc_skck' => 'boolean',
            'doc_sim' => 'boolean',
            'doc_surat_dokter' => 'boolean',
            'doc_sertifikat_beladiri' => 'boolean',
            'doc_ijazah_gp' => 'boolean',
            'doc_ijazah_gm' => 'boolean',
            'doc_kta' => 'boolean',
            'uniform_size' => 'nullable|string',
            'shoe_size' => 'nullable|string',
            'height' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'score_formal_education' => 'nullable|integer|min:1|max:5',
            'score_technical_knowledge' => 'nullable|integer|min:1|max:5',
            'score_communication' => 'nullable|integer|min:1|max:5',
            'score_teamwork' => 'nullable|integer|min:1|max:5',
            'score_motivation' => 'nullable|integer|min:1|max:5',
            'score_stress_resistance' => 'nullable|integer|min:1|max:5',
            'score_independence' => 'nullable|integer|min:1|max:5',
            'score_leadership' => 'nullable|integer|min:1|max:5',
            'score_ethics' => 'nullable|integer|min:1|max:5',
            'score_appearance' => 'nullable|integer|min:1|max:5',
            'final_notes' => 'nullable|string',
            'interview_date' => 'nullable|date',
            'ops_signature' => 'nullable|string',
            'hrd_signature' => 'nullable|string',
        ]);

        $pelamar->interviewResult()->updateOrCreate(
            ['pelamar_id' => $pelamar->id],
            [
                'hrd_notes' => $request->input('hrd_notes'),
                'ops_notes' => $request->input('ops_notes'),
                'decision' => $request->input('decision'),
                'q_about_yourself' => $request->input('q_about_yourself'),
                'q_reason_for_resigning' => $request->input('q_reason_for_resigning'),
                'q_hobbies_organizations' => $request->input('q_hobbies_organizations'),
                'q_why_interested' => $request->input('q_why_interested'),
                'q_motivation' => $request->input('q_motivation'),
                'q_experience' => $request->input('q_experience'),
                'q_skills_for_job' => $request->input('q_skills_for_job'),
                'q_what_you_like_about_job' => $request->input('q_what_you_like_about_job'),
                'q_desired_salary' => $request->input('q_desired_salary'),
                'q_knowledge_of_position' => $request->input('q_knowledge_of_position'),
                'doc_cv' => $request->boolean('doc_cv'),
                'doc_ktp' => $request->boolean('doc_ktp'),
                'doc_kk' => $request->boolean('doc_kk'),
                'doc_ijazah' => $request->boolean('doc_ijazah'),
                'doc_paklaring' => $request->boolean('doc_paklaring'),
                'doc_skck' => $request->boolean('doc_skck'),
                'doc_sim' => $request->boolean('doc_sim'),
                'doc_surat_dokter' => $request->boolean('doc_surat_dokter'),
                'doc_sertifikat_beladiri' => $request->boolean('doc_sertifikat_beladiri'),
                'doc_ijazah_gp' => $request->boolean('doc_ijazah_gp'),
                'doc_ijazah_gm' => $request->boolean('doc_ijazah_gm'),
                'doc_kta' => $request->boolean('doc_kta'),
                'uniform_size' => $request->input('uniform_size'),
                'shoe_size' => $request->input('shoe_size'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'score_formal_education' => $request->input('score_formal_education'),
                'score_technical_knowledge' => $request->input('score_technical_knowledge'),
                'score_communication' => $request->input('score_communication'),
                'score_teamwork' => $request->input('score_teamwork'),
                'score_motivation' => $request->input('score_motivation'),
                'score_stress_resistance' => $request->input('score_stress_resistance'),
                'score_independence' => $request->input('score_independence'),
                'score_leadership' => $request->input('score_leadership'),
                'score_ethics' => $request->input('score_ethics'),
                'score_appearance' => $request->input('score_appearance'),
                'final_notes' => $request->input('final_notes'),
                'interview_date' => $request->input('interview_date'),
                'ops_signature' => $request->input('ops_signature'),
                'hrd_signature' => $request->input('hrd_signature'),
            ]
        );

        return redirect()->back()->with('success', 'Hasil Interview berhasil disimpan.');
    }

    public function showFinalDecisionForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.final_decision', compact('pelamar'));
    }

    public function storeFinalDecision(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'final_decision' => 'required|in:MS,TMS',
            'final_notes' => 'nullable|string',
        ]);

        $pelamar->final_decision = $request->input('final_decision');
        $pelamar->final_notes = $request->input('final_notes');
        $pelamar->save();

        return redirect()->back()->with('success', 'Keputusan akhir pelamar berhasil disimpan.');
    }

    public function sendAdministrationInvitation(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'tanggal_administrasi' => 'required|date',
            'waktu_administrasi' => 'required|string',
            'lokasi_administrasi' => 'required|string',
            'batas_konfirmasi_tanggal' => 'required|date',
            'batas_konfirmasi_waktu' => 'required|string',
        ]);

        $data = [
            'nama_pelamar' => $pelamar->nama_lengkap,
            'tanggal_administrasi' => Carbon::parse($request->input('tanggal_administrasi'))->translatedFormat('l, d F Y'),
            'waktu_administrasi' => $request->input('waktu_administrasi'),
            'lokasi_administrasi' => $request->input('lokasi_administrasi'),
            'batas_konfirmasi_tanggal' => Carbon::parse($request->input('batas_konfirmasi_tanggal'))->translatedFormat('d F Y'),
            'batas_konfirmasi_waktu' => Carbon::parse($request->input('batas_konfirmasi_waktu'))->translatedFormat('H:i'),
        ];

        try {
            $this->pelamarService->sendAdministrationInvitationEmail($data, $pelamar->email);
            return response()->json(['message' => 'Undangan administrasi berhasil dikirim.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengirim undangan administrasi: ' . $e->getMessage()], 500);
        }
    }

    public function showAdministrationConfirmationForm(Pelamar $pelamar)
    {
        return view('pelamar.confirm_administration', compact('pelamar'));
    }

    public function confirmAdministration(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'attendance_status' => 'required|in:hadir,tidak_hadir',
            'reason' => 'nullable|required_if:attendance_status,tidak_hadir|string',
        ]);

        if ($request->input('attendance_status') === 'hadir') {
            $pelamar->status = 'administration_confirmed';
            $pelamar->save();
            return redirect()->route('pelamar.dashboard')->with('success', 'Konfirmasi kehadiran Anda telah disimpan.');
        } else {
            TidakHadir::create([
                'pelamar_id' => $pelamar->id,
                'reason' => $request->input('reason'),
                'type' => 'administration',
            ]);
            $pelamar->status = 'administration_not_confirmed';
            $pelamar->save();
            return redirect()->route('pelamar.dashboard')->with('success', 'Ketidakhadiran Anda telah dicatat.');
        }
    }

    public function showDocumentUploadForm(Pelamar $pelamar)
    {
        return view('pelamar.upload_documents', compact('pelamar'));
    }

    public function uploadDocument(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->file('document_file')->store('pelamar_documents', 'public');

        PelamarDocument::create([
            'pelamar_id' => $pelamar->id,
            'document_type' => $request->input('document_type'),
            'file_path' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Dokumen berhasil diunggah.');
    }

    // ============= PKWT CONTRACT FORMS =============
    public function showPkwtForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.pkwt_form', compact('pelamar'));
    }

    public function storePkwtData(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'kontrak_mulai' => 'required|date',
            'kontrak_selesai' => 'required|date|after:kontrak_mulai',
            'jabatan_kontrak' => 'required|string|max:255',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'nullable|numeric|min:0',
            'lokasi_kerja' => 'required|string|max:255',
            'jam_kerja' => 'required|string|max:100',
            'pkwt_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $pkwtData = [
            'kontrak_mulai' => $request->input('kontrak_mulai'),
            'kontrak_selesai' => $request->input('kontrak_selesai'),
            'jabatan_kontrak' => $request->input('jabatan_kontrak'),
            'gaji_pokok' => $request->input('gaji_pokok'),
            'tunjangan' => $request->input('tunjangan'),
            'lokasi_kerja' => $request->input('lokasi_kerja'),
            'jam_kerja' => $request->input('jam_kerja'),
        ];

        if ($request->hasFile('pkwt_file')) {
            $pkwtData['pkwt_file_path'] = $request->file('pkwt_file')->store('pkwt_documents', 'public');
        }

        $pelamar->pkwt_data = json_encode($pkwtData);
        $pelamar->pkwt_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Data PKWT berhasil disimpan.');
    }

    // ============= BPJS FORMS =============
    public function showBpjsForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.bpjs_form', compact('pelamar'));
    }

    public function storeBpjsData(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'bpjs_kesehatan_number' => 'nullable|string|max:50',
            'bpjs_ketenagakerjaan_number' => 'nullable|string|max:50',
            'nama_ibu_kandung' => 'required|string|max:255',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai_hidup,cerai_mati',
            'jumlah_tanggungan' => 'required|integer|min:0',
            'alamat_domisili' => 'required|string',
            'no_rekening' => 'required|string|max:50',
            'nama_bank' => 'required|string|max:100',
            'bpjs_form_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $bpjsData = [
            'bpjs_kesehatan_number' => $request->input('bpjs_kesehatan_number'),
            'bpjs_ketenagakerjaan_number' => $request->input('bpjs_ketenagakerjaan_number'),
            'nama_ibu_kandung' => $request->input('nama_ibu_kandung'),
            'status_perkawinan' => $request->input('status_perkawinan'),
            'jumlah_tanggungan' => $request->input('jumlah_tanggungan'),
            'alamat_domisili' => $request->input('alamat_domisili'),
            'no_rekening' => $request->input('no_rekening'),
            'nama_bank' => $request->input('nama_bank'),
        ];

        if ($request->hasFile('bpjs_form_file')) {
            $bpjsData['bpjs_form_file_path'] = $request->file('bpjs_form_file')->store('bpjs_documents', 'public');
        }

        $pelamar->bpjs_data = json_encode($bpjsData);
        $pelamar->bpjs_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Data BPJS berhasil disimpan.');
    }

    // ============= SPT FORMS =============
    public function showSptForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.spt_form', compact('pelamar'));
    }

    public function storeSptData(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'npwp' => 'nullable|string|max:50',
            'penghasilan_tahun_sebelumnya' => 'nullable|numeric|min:0',
            'pph_terutang' => 'nullable|numeric|min:0',
            'status_pajak' => 'required|in:sudah_punya_npwp,belum_punya_npwp,proses_pembuatan',
            'tanggungan_pajak' => 'required|integer|min:0',
            'alamat_npwp' => 'nullable|string',
            'spt_file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        $sptData = [
            'npwp' => $request->input('npwp'),
            'penghasilan_tahun_sebelumnya' => $request->input('penghasilan_tahun_sebelumnya'),
            'pph_terutang' => $request->input('pph_terutang'),
            'status_pajak' => $request->input('status_pajak'),
            'tanggungan_pajak' => $request->input('tanggungan_pajak'),
            'alamat_npwp' => $request->input('alamat_npwp'),
        ];

        if ($request->hasFile('spt_file')) {
            $sptData['spt_file_path'] = $request->file('spt_file')->store('spt_documents', 'public');
        }

        $pelamar->spt_data = json_encode($sptData);
        $pelamar->spt_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Data SPT berhasil disimpan.');
    }

    // ============= DOCUMENT RECEIPT FORMS =============
    public function showDocumentReceiptForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.document_receipt_form', compact('pelamar'));
    }

    public function storeDocumentReceipt(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'documents_received' => 'required|array',
            'documents_received.*' => 'string',
            'receipt_date' => 'required|date',
            'received_by' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'receipt_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $receiptData = [
            'documents_received' => $request->input('documents_received'),
            'receipt_date' => $request->input('receipt_date'),
            'received_by' => $request->input('received_by'),
            'notes' => $request->input('notes'),
        ];

        if ($request->hasFile('receipt_file')) {
            $receiptData['receipt_file_path'] = $request->file('receipt_file')->store('receipt_documents', 'public');
        }

        $pelamar->document_receipt_data = json_encode($receiptData);
        $pelamar->document_receipt_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Tanda terima dokumen berhasil disimpan.');
    }

    // ============= STATEMENT FORMS =============
    public function showStatementForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.statement_form', compact('pelamar'));
    }

    public function storeStatementData(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'statement_type' => 'required|in:peraturan,pembayaran,ijin',
            'statement_content' => 'required|string',
            'agreed' => 'required|boolean',
            'signature_date' => 'required|date',
            'witness_name' => 'nullable|string|max:255',
            'statement_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $statementData = [
            'statement_type' => $request->input('statement_type'),
            'statement_content' => $request->input('statement_content'),
            'agreed' => $request->boolean('agreed'),
            'signature_date' => $request->input('signature_date'),
            'witness_name' => $request->input('witness_name'),
        ];

        if ($request->hasFile('statement_file')) {
            $statementData['statement_file_path'] = $request->file('statement_file')->store('statement_documents', 'public');
        }

        $pelamar->statement_data = json_encode($statementData);
        $pelamar->statement_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Surat pernyataan berhasil disimpan.');
    }

    // ============= BANKING FORMS =============
    public function showBankingForm(Pelamar $pelamar)
    {
        return view('hrd.administrasi_pelamar.banking_form', compact('pelamar'));
    }

    public function storeBankingData(Request $request, Pelamar $pelamar)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_holder_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'account_type' => 'required|in:tabungan,giro',
            'buku_tabungan_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $bankingData = [
            'bank_name' => $request->input('bank_name'),
            'account_number' => $request->input('account_number'),
            'account_holder_name' => $request->input('account_holder_name'),
            'branch_name' => $request->input('branch_name'),
            'account_type' => $request->input('account_type'),
        ];

        if ($request->hasFile('buku_tabungan_file')) {
            $bankingData['buku_tabungan_file_path'] = $request->file('buku_tabungan_file')->store('banking_documents', 'public');
        }

        $pelamar->banking_data = json_encode($bankingData);
        $pelamar->banking_status = 'completed';
        $pelamar->save();

        return redirect()->back()->with('success', 'Data perbankan berhasil disimpan.');
    }
}
