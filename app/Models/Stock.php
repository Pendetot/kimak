<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'stocks';

    protected $fillable = [
        'barang_id',
        'quantity',
        'minimum_stock',
        'maximum_stock',
        'location',
        'batch_number',
        'expiry_date',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'maximum_stock' => 'integer',
        'expiry_date' => 'date',
    ];

    /**
     * Get the barang that owns this stock
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Get the user who created this stock record
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated this stock record
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get stock movements for this stock
     */
    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }

    /**
     * Scope: Low stock items
     */
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock');
    }

    /**
     * Scope: Out of stock items
     */
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', 0);
    }

    /**
     * Scope: Overstock items
     */
    public function scopeOverstock($query)
    {
        return $query->whereRaw('quantity >= maximum_stock AND maximum_stock > 0');
    }

    /**
     * Scope: Filter by location
     */
    public function scopeLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    /**
     * Accessor: Get stock status
     */
    public function getStockStatusAttribute()
    {
        if ($this->quantity == 0) {
            return ['status' => 'out_of_stock', 'class' => 'text-danger', 'text' => 'Out of Stock'];
        } elseif ($this->quantity <= $this->minimum_stock) {
            return ['status' => 'low_stock', 'class' => 'text-warning', 'text' => 'Low Stock'];
        } elseif ($this->maximum_stock > 0 && $this->quantity >= $this->maximum_stock) {
            return ['status' => 'overstock', 'class' => 'text-info', 'text' => 'Overstock'];
        } else {
            return ['status' => 'normal', 'class' => 'text-success', 'text' => 'Normal'];
        }
    }

    /**
     * Accessor: Get stock percentage
     */
    public function getStockPercentageAttribute()
    {
        if ($this->maximum_stock == 0) return 0;
        return round(($this->quantity / $this->maximum_stock) * 100, 1);
    }

    /**
     * Check if stock is low
     */
    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock;
    }

    /**
     * Check if stock is out
     */
    public function isOutOfStock()
    {
        return $this->quantity == 0;
    }

    /**
     * Check if stock is expired or expiring soon
     */
    public function isExpiringSoon($days = 30)
    {
        if (!$this->expiry_date) return false;
        return $this->expiry_date->diffInDays(now()) <= $days;
    }

    /**
     * Adjust stock quantity
     */
    public function adjustQuantity($adjustment, $type = 'adjustment', $notes = null, $userId = null)
    {
        $oldQuantity = $this->quantity;
        $newQuantity = $oldQuantity + $adjustment;
        
        if ($newQuantity < 0) {
            throw new \Exception('Stock cannot be negative');
        }

        $this->update(['quantity' => $newQuantity]);

        // Create stock movement record
        StockMovement::create([
            'barang_id' => $this->barang_id,
            'stock_id' => $this->id,
            'type' => $type,
            'quantity_before' => $oldQuantity,
            'quantity_after' => $newQuantity,
            'adjustment' => $adjustment,
            'notes' => $notes,
            'created_by' => $userId ?? auth()->id(),
        ]);

        return $this;
    }
}