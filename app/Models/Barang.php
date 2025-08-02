<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'deskripsi',
        'unit',
        'harga_satuan',
        'minimum_stock',
        'maximum_stock',
        'lokasi_penyimpanan',
        'supplier',
        'barcode',
        'foto',
        'status',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
    ];

    /**
     * Get all stock records for this item
     */
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    /**
     * Get the current stock for this item
     */
    public function currentStock()
    {
        return $this->hasOne(Stock::class)->latest();
    }

    /**
     * Get the user who created this item
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this item
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope: Active items only
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope: Filter by category
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('kategori', $category);
    }

    /**
     * Scope: Low stock items
     */
    public function scopeLowStock($query)
    {
        return $query->whereHas('stocks', function ($q) {
            $q->whereRaw('quantity <= minimum_stock');
        });
    }

    /**
     * Scope: Out of stock items
     */
    public function scopeOutOfStock($query)
    {
        return $query->whereHas('stocks', function ($q) {
            $q->where('quantity', 0);
        });
    }

    /**
     * Accessor: Get current quantity
     */
    public function getCurrentQuantityAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    /**
     * Accessor: Format price
     */
    public function getHargaSatuanFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    /**
     * Accessor: Get status badge class
     */
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case 'aktif':
                return 'badge bg-success';
            case 'tidak_aktif':
                return 'badge bg-secondary';
            default:
                return 'badge bg-secondary';
        }
    }

    /**
     * Accessor: Get stock status
     */
    public function getStockStatusAttribute()
    {
        $currentQty = $this->current_quantity;
        
        if ($currentQty == 0) {
            return ['status' => 'out_of_stock', 'class' => 'text-danger', 'text' => 'Out of Stock'];
        } elseif ($currentQty <= $this->minimum_stock) {
            return ['status' => 'low_stock', 'class' => 'text-warning', 'text' => 'Low Stock'];
        } elseif ($this->maximum_stock > 0 && $currentQty >= $this->maximum_stock) {
            return ['status' => 'overstock', 'class' => 'text-info', 'text' => 'Overstock'];
        } else {
            return ['status' => 'normal', 'class' => 'text-success', 'text' => 'Normal'];
        }
    }

    /**
     * Check if item is low on stock
     */
    public function isLowStock()
    {
        return $this->current_quantity <= $this->minimum_stock;
    }

    /**
     * Check if item is out of stock
     */
    public function isOutOfStock()
    {
        return $this->current_quantity == 0;
    }

    /**
     * Get photo URL
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return asset('assets/images/default-item.png');
    }
}