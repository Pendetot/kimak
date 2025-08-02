<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Enums\StatusKaryawanEnum;
use App\Enums\JenisKelaminEnum;
use App\Enums\StatusPernikahanEnum;
use App\Enums\JenisKontrakEnum;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The table associated with the model.
     */
    protected $table = 'karyawans';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        // Authentication
        'email',
        'password',
        
        // Employee identification
        'nik',
        'nip',
        
        // Personal information
        'nama_lengkap',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'status_pernikahan',
        'alamat_domisili',
        'alamat_ktp',
        'no_telepon',
        'no_hp',
        'email_pribadi',
        
        // Identity documents
        'no_ktp',
        'no_npwp',
        'no_bpjs_kesehatan',
        'no_bpjs_ketenagakerjaan',
        
        // Employment information
        'jabatan',
        'departemen',
        'divisi',
        'unit_kerja',
        'lokasi_kerja',
        'tanggal_masuk',
        'tanggal_kontrak_mulai',
        'tanggal_kontrak_selesai',
        'jenis_kontrak',
        'status_karyawan',
        
        // Employment details
        'level_jabatan',
        'grade',
        'gaji_pokok',
        'tunjangan',
        'shift_kerja',
        'jam_kerja_per_hari',
        'hari_kerja_per_minggu',
        
        // Emergency contact
        'kontak_darurat_nama',
        'kontak_darurat_hubungan',
        'kontak_darurat_telepon',
        
        // Education & Experience
        'pendidikan_terakhir',
        'institusi_pendidikan',
        'jurusan',
        'tahun_lulus',
        'pengalaman_kerja',
        'keahlian',
        'sertifikasi',
        
        // File uploads
        'foto_profil',
        'file_cv',
        'file_ktp',
        'file_ijazah',
        'file_kontrak',
        
        // System fields
        'created_by',
        'updated_by',
        'last_login_at',
        'last_login_ip',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tanggal_lahir' => 'date',
        'tanggal_masuk' => 'date',
        'tanggal_kontrak_mulai' => 'date',
        'tanggal_kontrak_selesai' => 'date',
        'tahun_lulus' => 'integer',
        'gaji_pokok' => 'decimal:2',
        'tunjangan' => 'array',
        'jam_kerja_per_hari' => 'integer',
        'hari_kerja_per_minggu' => 'integer',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'status_karyawan' => StatusKaryawanEnum::class,
        'jenis_kelamin' => JenisKelaminEnum::class,
        'status_pernikahan' => StatusPernikahanEnum::class,
        'jenis_kontrak' => JenisKontrakEnum::class,
    ];

    /**
     * The attributes that should be mutated to dates.
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($karyawan) {
            if (auth()->check()) {
                $karyawan->created_by = auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'System';
            }
        });

        static::updating(function ($karyawan) {
            if (auth()->check()) {
                $karyawan->updated_by = auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'System';
            }
        });
    }

    /**
     * Get the name that should be displayed for the karyawan.
     */
    protected function displayName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama_panggilan ?? $this->nama_lengkap,
        );
    }

    /**
     * Get the full name attribute.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama_lengkap,
        );
    }

    /**
     * Get the age attribute.
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tanggal_lahir ? $this->tanggal_lahir->diffInYears(now()) : null,
        );
    }

    /**
     * Get the work duration attribute.
     */
    protected function workDuration(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tanggal_masuk ? $this->tanggal_masuk->diffForHumans(now(), true) : null,
        );
    }

    /**
     * Get the contract status attribute.
     */
    protected function contractStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->tanggal_kontrak_selesai) {
                    return 'permanent';
                }
                
                $now = now();
                $endDate = $this->tanggal_kontrak_selesai;
                
                if ($endDate < $now) {
                    return 'expired';
                } elseif ($endDate->diffInDays($now) <= 30) {
                    return 'expiring_soon';
                } else {
                    return 'active';
                }
            }
        );
    }

    // Relationships

    /**
     * Get the absensi for the karyawan.
     */
    public function absensi()
    {
        return $this->hasMany(Absensi::class, 'karyawan_id');
    }

    /**
     * Get the cuti for the karyawan.
     */
    public function cuti()
    {
        return $this->hasMany(Cuti::class, 'karyawan_id');
    }

    /**
     * Get the KPI for the karyawan.
     */
    public function kpi()
    {
        return $this->hasMany(KPI::class, 'karyawan_id');
    }

    /**
     * Get the pembinaan for the karyawan.
     */
    public function pembinaan()
    {
        return $this->hasMany(Pembinaan::class, 'karyawan_id');
    }

    /**
     * Get the hutang for the karyawan.
     */
    public function hutangKaryawan()
    {
        return $this->hasMany(HutangKaryawan::class, 'karyawan_id');
    }

    /**
     * Get the surat peringatan for the karyawan.
     */
    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class, 'karyawan_id');
    }

    /**
     * Get the penalti SP for the karyawan.
     */
    public function penaltiSP()
    {
        return $this->hasMany(PenaltiSP::class, 'karyawan_id');
    }

    /**
     * Get the mutasi for the karyawan.
     */
    public function mutasi()
    {
        return $this->hasMany(Mutasi::class, 'karyawan_id');
    }

    /**
     * Get the resign record for the karyawan.
     */
    public function resign()
    {
        return $this->hasOne(Resign::class, 'karyawan_id');
    }

    /**
     * Get the rekening for the karyawan.
     */
    public function rekeningKaryawan()
    {
        return $this->hasMany(RekeningKaryawan::class, 'karyawan_id');
    }

    /**
     * Get the lap dokumen for the karyawan.
     */
    public function lapDokumen()
    {
        return $this->hasMany(LapDokumen::class, 'karyawan_id');
    }

    /**
     * Get the pengajuan barang for the karyawan.
     */
    public function pengajuanBarang()
    {
        return $this->hasMany(PengajuanBarang::class, 'karyawan_id');
    }

    // Scopes

    /**
     * Scope a query to only include active karyawan.
     */
    public function scopeActive($query)
    {
        return $query->where('status_karyawan', StatusKaryawanEnum::Aktif)
                    ->where('is_active', true);
    }

    /**
     * Scope a query to only include inactive karyawan.
     */
    public function scopeInactive($query)
    {
        return $query->where('status_karyawan', '!=', StatusKaryawanEnum::Aktif)
                    ->orWhere('is_active', false);
    }

    /**
     * Scope a query by department.
     */
    public function scopeByDepartment($query, $department)
    {
        return $query->where('departemen', $department);
    }

    /**
     * Scope a query by division.
     */
    public function scopeByDivision($query, $division)
    {
        return $query->where('divisi', $division);
    }

    /**
     * Scope a query for contracts expiring soon.
     */
    public function scopeContractExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('tanggal_kontrak_selesai')
                    ->whereBetween('tanggal_kontrak_selesai', [now(), now()->addDays($days)]);
    }

    // Helper Methods

    /**
     * Check if karyawan is active.
     */
    public function isActive(): bool
    {
        return $this->status_karyawan === StatusKaryawanEnum::Aktif && $this->is_active;
    }

    /**
     * Check if karyawan contract is expired.
     */
    public function isContractExpired(): bool
    {
        return $this->tanggal_kontrak_selesai && $this->tanggal_kontrak_selesai < now();
    }

    /**
     * Check if karyawan contract is expiring soon.
     */
    public function isContractExpiringSoon($days = 30): bool
    {
        return $this->tanggal_kontrak_selesai && 
               $this->tanggal_kontrak_selesai->between(now(), now()->addDays($days));
    }

    /**
     * Get total hutang amount.
     */
    public function getTotalHutang(): float
    {
        return $this->hutangKaryawan()->sum('jumlah');
    }

    /**
     * Get total cuti taken this year.
     */
    public function getCutiThisYear(): int
    {
        return $this->cuti()
                   ->whereYear('created_at', now()->year)
                   ->where('status', 'approved')
                   ->sum('jumlah_hari');
    }

    /**
     * Get latest KPI score.
     */
    public function getLatestKPIScore(): ?float
    {
        return $this->kpi()->latest()->value('nilai');
    }

    /**
     * Update last login information.
     */
    public function updateLastLogin($ip = null): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip ?? request()->ip(),
        ]);
    }

    /**
     * Get photo URL.
     */
    public function getPhotoUrl(): string
    {
        if ($this->foto_profil && \Storage::exists($this->foto_profil)) {
            return \Storage::url($this->foto_profil);
        }

        // Default avatar based on gender
        $defaultAvatar = $this->jenis_kelamin === JenisKelaminEnum::Laki ? 'default-male.png' : 'default-female.png';
        return asset('images/avatars/' . $defaultAvatar);
    }

    /**
     * Get file URL.
     */
    public function getFileUrl($field): ?string
    {
        if ($this->$field && \Storage::exists($this->$field)) {
            return \Storage::url($this->$field);
        }
        return null;
    }
}
