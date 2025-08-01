@extends('layouts.app')

@section('title', 'Input Hasil Interview')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Formulir Interview untuk {{ $pelamar->nama }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('hrd.administrasi-pelamar.store-interview-result', $pelamar->id) }}">
                        @csrf

                        <h5 class="mb-3">Informasi Pelamar</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Nama:</strong> {{ $pelamar->nama }}</p>
                                <p><strong>Alamat/Domisili:</strong> {{ $pelamar->alamat_domisili }}</p>
                                <p><strong>Usia:</strong> {{ \Carbon\Carbon::parse($pelamar->tanggal_lahir)->age }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Tinggi Badan:</strong> {{ $pelamar->tinggi_badan }} cm</p>
                                <p><strong>Berat Badan:</strong> {{ $pelamar->berat_badan }} kg</p>
                                <p><strong>Ukuran Seragam:</strong> {{ $pelamar->ukuran_seragam }}</p>
                                <p><strong>Ukuran Sepatu:</strong> {{ $pelamar->ukuran_sepatu }}</p>
                            </div>
                        </div>

                        <h5 class="mb-3">Pertanyaan Interview</h5>
                        <div class="form-group mb-3">
                            <label for="q_about_yourself">Jelaskan sedikit tentang diri Anda:</label>
                            <textarea class="form-control" id="q_about_yourself" name="q_about_yourself" rows="3">{{ old('q_about_yourself', $pelamar->interviewResult->q_about_yourself ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_reason_for_resigning">Alasan Resign (jika ada):</label>
                            <textarea class="form-control" id="q_reason_for_resigning" name="q_reason_for_resigning" rows="3">{{ old('q_reason_for_resigning', $pelamar->interviewResult->q_reason_for_resigning ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_hobbies_organizations">Hobi dan Organisasi:</label>
                            <textarea class="form-control" id="q_hobbies_organizations" name="q_hobbies_organizations" rows="3">{{ old('q_hobbies_organizations', $pelamar->interviewResult->q_hobbies_organizations ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_why_interested">Mengapa Anda tertarik dengan pekerjaan ini?</label>
                            <textarea class="form-control" id="q_why_interested" name="q_why_interested" rows="3">{{ old('q_why_interested', $pelamar->interviewResult->q_why_interested ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_motivation">Motivasi:</label>
                            <textarea class="form-control" id="q_motivation" name="q_motivation" rows="3">{{ old('q_motivation', $pelamar->interviewResult->q_motivation ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_experience">Pengalaman Anda:</label>
                            <textarea class="form-control" id="q_experience" name="q_experience" rows="3">{{ old('q_experience', $pelamar->interviewResult->q_experience ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_skills_for_job">Keterampilan untuk pekerjaan ini:</label>
                            <textarea class="form-control" id="q_skills_for_job" name="q_skills_for_job" rows="3">{{ old('q_skills_for_job', $pelamar->interviewResult->q_skills_for_job ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_what_you_like_about_job">Hal apa yang Anda sukai di pekerjaan ini?</label>
                            <textarea class="form-control" id="q_what_you_like_about_job" name="q_what_you_like_about_job" rows="3">{{ old('q_what_you_like_about_job', $pelamar->interviewResult->q_what_you_like_about_job ?? '') }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_desired_salary">Gaji yang diinginkan:</label>
                            <input type="text" class="form-control" id="q_desired_salary" name="q_desired_salary" value="{{ old('q_desired_salary', $pelamar->interviewResult->q_desired_salary ?? '') }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="q_knowledge_of_position">Apa yang Anda ketahui dari posisi ini?</label>
                            <textarea class="form-control" id="q_knowledge_of_position" name="q_knowledge_of_position" rows="3">{{ old('q_knowledge_of_position', $pelamar->interviewResult->q_knowledge_of_position ?? '') }}</textarea>
                        </div>

                        <h5 class="mb-3">Kelengkapan Dokumen</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>Ada</th>
                                        <th>Tidak Ada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $documents = [
                                            'doc_cv' => 'DAFTAR RIWAYAT HIDUP (CV)',
                                            'doc_ktp' => 'KTP',
                                            'doc_kk' => 'KK',
                                            'doc_ijazah' => 'IJAZAH PENDIDIKAN TERAKHIR',
                                            'doc_paklaring' => 'SURAT KETERANGAN KERJA (PAKLARING)',
                                            'doc_skck' => 'SKCK',
                                            'doc_sim' => 'SIM C/SIM A/SIM B1',
                                            'doc_surat_dokter' => 'SURAT DOKTER',
                                            'doc_sertifikat_beladiri' => 'SERTIFIKAT/IJAZAH BELADIRI',
                                            'doc_ijazah_gp' => 'IJAZAH GADA PRATAMA (GP)',
                                            'doc_ijazah_gm' => 'IJAZAH GADA MADYA (GM)',
                                            'doc_kta' => 'KTA',
                                        ];
                                    @endphp
                                    @foreach($documents as $key => $name)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $name }}</td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{ $key }}" id="{{ $key }}_ada" value="1" {{ (old($key, $pelamar->interviewResult->$key ?? false) == true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $key }}_ada">Ada</label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{ $key }}" id="{{ $key }}_tidak_ada" value="0" {{ (old($key, $pelamar->interviewResult->$key ?? false) == false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $key }}_tidak_ada">Tidak Ada</label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5 class="mb-3">Form Penilaian</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mb-3">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Dimensi Penilaian</th>
                                        <th>Uraian</th>
                                        <th colspan="5">Angka Penilaian (1-5)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $assessments = [
                                            'score_formal_education' => 'Pendidikan Formal',
                                            'score_technical_knowledge' => 'Pengetahuan Teknis',
                                            'score_communication' => 'Kemampuan Komunikasi',
                                            'score_teamwork' => 'Kerjasama',
                                            'score_motivation' => 'Motivasi',
                                            'score_stress_resistance' => 'Ketahanan terhadap stress / tekanan',
                                            'score_independence' => 'Kemandirian',
                                            'score_leadership' => 'Kepemimpinan',
                                            'score_ethics' => 'Etika/Sopan Santun',
                                            'score_appearance' => 'Penampilan diri',
                                        ];
                                    @endphp
                                    @foreach($assessments as $key => $name)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $name }}</td>
                                        <td></td> {{-- Uraian column, leave empty for now --}}
                                        @for($i = 1; $i <= 5; $i++)
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="{{ $key }}" id="{{ $key }}_{{ $i }}" value="{{ $i }}" {{ (old($key, $pelamar->interviewResult->$key ?? '') == $i) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="{{ $key }}_{{ $i }}">{{ $i }}</label>
                                            </div>
                                        </td>
                                        @endfor
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5 class="mb-3">Keputusan Interview</h5>
                        <div class="form-group mb-3">
                            <label for="decision">Rekomendasi:</label>
                            <select class="form-control" id="decision" name="decision" required>
                                <option value="">Pilih Keputusan</option>
                                <option value="recommended" {{ (old('decision', $pelamar->interviewResult->decision ?? '') == 'recommended') ? 'selected' : '' }}>Dapat diterima</option>
                                <option value="not_recommended" {{ (old('decision', $pelamar->interviewResult->decision ?? '') == 'not_recommended') ? 'selected' : '' }}>Tidak disarankan</option>
                                <option value="pending" {{ (old('decision', $pelamar->interviewResult->decision ?? '') == 'pending') ? 'selected' : '' }}>Dipertimbangkan</option>
                            </select>
                            @error('decision')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="final_notes">Catatan Akhir:</label>
                            <textarea class="form-control" id="final_notes" name="final_notes" rows="3">{{ old('final_notes', $pelamar->interviewResult->final_notes ?? '') }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="interview_date">Tanggal Interview:</label>
                            <input type="date" class="form-control" id="interview_date" name="interview_date" value="{{ old('interview_date', $pelamar->interviewResult->interview_date ?? date('Y-m-d')) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="ops_signature">Tanda Tangan Operasional (Nama/ID):</label>
                            <input type="text" class="form-control" id="ops_signature" name="ops_signature" value="{{ old('ops_signature', $pelamar->interviewResult->ops_signature ?? (Auth::user()->hasRole(\App\Enums\RoleEnum::Logistik) ? Auth::user()->name : '')) }}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="hrd_signature">Tanda Tangan HRD (Nama/ID):</label>
                            <input type="text" class="form-control" id="hrd_signature" name="hrd_signature" value="{{ old('hrd_signature', $pelamar->interviewResult->hrd_signature ?? (Auth::user()->hasRole(\App\Enums\RoleEnum::HRD) ? Auth::user()->name : '')) }}">
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Hasil Interview</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection