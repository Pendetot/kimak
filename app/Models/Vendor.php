<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vendors';

    protected $fillable = [
        'nama_vendor',
        'kategori',
        'alamat',
        'kota',
        'provinsi',
        'kode_pos',
        'telepon',
        'email',
        'website',
        'contact_person',
        'jabatan_contact_person',
        'telepon_contact_person',
        'email_contact_person',
        'bank',
        'nomor_rekening',
        'nama_rekening',
        'npwp',
        'rating',
        'status',
        'catatan',
        'created_by'
    ];

    protected $casts = [
        'rating' => 'decimal:1'
    ];

    /**
     * Relationship with Pembelian
     */
    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }

    /**
     * Relationship with User who created the vendor
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope for active vendors
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope for inactive vendors
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'non_aktif');
    }

    /**
     * Scope by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColorAttribute()
    {
        switch ($this->status) {
            case 'aktif':
                return 'bg-success';
            case 'non_aktif':
                return 'bg-danger';
            case 'suspended':
                return 'bg-warning';
            default:
                return 'bg-secondary';
        }
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'aktif':
                return 'Aktif';
            case 'non_aktif':
                return 'Non Aktif';
            case 'suspended':
                return 'Suspended';
            default:
                return ucfirst($this->status);
        }
    }

    /**
     * Get rating stars
     */
    public function getRatingStarsAttribute()
    {
        $rating = $this->rating ?: 0;
        $stars = '';
        
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $stars .= '<i class="ph-duotone ph-star f-16 text-warning"></i>';
            } else {
                $stars .= '<i class="ph-duotone ph-star f-16 text-muted"></i>';
            }
        }
        
        return $stars;
    }

    /**
     * Get formatted address
     */
    public function getFormattedAddressAttribute()
    {
        $address = $this->alamat;
        if ($this->kota) {
            $address .= ', ' . $this->kota;
        }
        if ($this->provinsi) {
            $address .= ', ' . $this->provinsi;
        }
        if ($this->kode_pos) {
            $address .= ' ' . $this->kode_pos;
        }
        
        return $address;
    }

    /**
     * Get total transactions
     */
    public function getTotalTransactionsAttribute()
    {
        return $this->pembelians()->count();
    }

    /**
     * Get total transaction value
     */
    public function getTotalValueAttribute()
    {
        return $this->pembelians()->sum('total_harga');
    }

    /**
     * Get formatted total value
     */
    public function getFormattedTotalValueAttribute()
    {
        return 'Rp ' . number_format($this->total_value, 0, ',', '.');
    }

    /**
     * Check if vendor is active
     */
    public function isActive()
    {
        return $this->status === 'aktif';
    }

    /**
     * Check if vendor can be used for purchases
     */
    public function canBeUsedForPurchase()
    {
        return in_array($this->status, ['aktif']);
    }
}