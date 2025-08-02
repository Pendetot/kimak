<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LapDokumen extends Model
{
    use HasFactory;

    protected $fillable = [
        'karyawan_id',
        'nama_dokumen',
        'jenis_dokumen',
        'deskripsi',
        'tanggal_upload',
        'file_path',
        'file_size',
        'mime_type',
        'status_dokumen',
        'diupload_oleh',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_upload' => 'datetime',
        'file_size' => 'integer',
    ];

    /**
     * Get the karyawan that owns the document.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    /**
     * Get the user who uploaded the document.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'diupload_oleh');
    }

    /**
     * Scope for document type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('jenis_dokumen', $type);
    }

    /**
     * Scope for recent uploads.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('tanggal_upload', '>=', now()->subDays($days));
    }

    /**
     * Get file URL.
     */
    public function getFileUrl(): ?string
    {
        if ($this->file_path && \Storage::exists($this->file_path)) {
            return \Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedFileSize(): string
    {
        if (!$this->file_size) return 'Unknown';
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if document is image.
     */
    public function isImage(): bool
    {
        return str_starts_with($this->mime_type ?? '', 'image/');
    }

    /**
     * Check if document is PDF.
     */
    public function isPdf(): bool
    {
        return $this->mime_type === 'application/pdf';
    }
}
