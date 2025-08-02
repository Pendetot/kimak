<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';

    protected $fillable = [
        'barang_id',
        'stock_id',
        'type',
        'quantity_before',
        'quantity_after',
        'adjustment',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity_before' => 'integer',
        'quantity_after' => 'integer',
        'adjustment' => 'integer',
    ];

    /**
     * Get the barang that this movement belongs to
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Get the stock record that this movement belongs to
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Get the user who created this movement
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Filter by movement type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
    }

    /**
     * Scope: Stock increases
     */
    public function scopeIncreases($query)
    {
        return $query->where('adjustment', '>', 0);
    }

    /**
     * Scope: Stock decreases
     */
    public function scopeDecreases($query)
    {
        return $query->where('adjustment', '<', 0);
    }

    /**
     * Accessor: Get movement type badge class
     */
    public function getTypeBadgeAttribute()
    {
        switch ($this->type) {
            case 'initial_stock':
                return 'badge bg-primary';
            case 'increase':
                return 'badge bg-success';
            case 'decrease':
                return 'badge bg-danger';
            case 'adjustment':
                return 'badge bg-warning';
            case 'transfer':
                return 'badge bg-info';
            case 'return':
                return 'badge bg-secondary';
            default:
                return 'badge bg-light';
        }
    }

    /**
     * Accessor: Get movement type text
     */
    public function getTypeTextAttribute()
    {
        switch ($this->type) {
            case 'initial_stock':
                return 'Initial Stock';
            case 'increase':
                return 'Stock Increase';
            case 'decrease':
                return 'Stock Decrease';
            case 'adjustment':
                return 'Stock Adjustment';
            case 'transfer':
                return 'Stock Transfer';
            case 'return':
                return 'Stock Return';
            default:
                return ucfirst($this->type);
        }
    }

    /**
     * Accessor: Get adjustment with sign
     */
    public function getAdjustmentWithSignAttribute()
    {
        return ($this->adjustment >= 0 ? '+' : '') . $this->adjustment;
    }

    /**
     * Check if this is a positive movement
     */
    public function isPositive()
    {
        return $this->adjustment > 0;
    }

    /**
     * Check if this is a negative movement
     */
    public function isNegative()
    {
        return $this->adjustment < 0;
    }
}