<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Barang;
use App\Models\StockMovement;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Display a listing of stock records
     */
    public function index(Request $request)
    {
        $query = Stock::with(['barang', 'creator']);

        // Apply filters
        if ($request->barang_id) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->location) {
            $query->where('location', 'like', "%{$request->location}%");
        }

        if ($request->status) {
            switch ($request->status) {
                case 'low_stock':
                    $query->whereRaw('quantity <= minimum_stock');
                    break;
                case 'out_of_stock':
                    $query->where('quantity', 0);
                    break;
                case 'overstock':
                    $query->whereRaw('quantity >= maximum_stock AND maximum_stock > 0');
                    break;
                case 'normal':
                    $query->whereRaw('quantity > minimum_stock')
                          ->whereRaw('(quantity < maximum_stock OR maximum_stock = 0)');
                    break;
            }
        }

        if ($request->search) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', "%{$request->search}%")
                  ->orWhere('kode_barang', 'like', "%{$request->search}%");
            });
        }

        $stocks = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total_items' => Stock::sum('quantity'),
            'low_stock_items' => Stock::whereRaw('quantity <= minimum_stock')->count(),
            'out_of_stock_items' => Stock::where('quantity', 0)->count(),
            'total_value' => Stock::join('barangs', 'stocks.barang_id', '=', 'barangs.id')
                                 ->sum(DB::raw('stocks.quantity * barangs.harga_satuan')),
        ];

        $barangs = Barang::where('status', 'aktif')->orderBy('nama_barang')->get();
        $locations = Stock::distinct()->pluck('location')->filter();

        return view('logistik.stock.index', compact('stocks', 'stats', 'barangs', 'locations'));
    }

    /**
     * Show the form for creating a new stock record
     */
    public function create()
    {
        $barangs = Barang::where('status', 'aktif')->orderBy('nama_barang')->get();
        return view('logistik.stock.create', compact('barangs'));
    }

    /**
     * Store a newly created stock record
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'location' => 'required|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:500'
        ]);

        // Check if stock for this item and location already exists
        $existing = Stock::where('barang_id', $request->barang_id)
                        ->where('location', $request->location)
                        ->when($request->batch_number, function ($q, $batch) {
                            return $q->where('batch_number', $batch);
                        })
                        ->first();

        if ($existing) {
            return back()->withInput()
                ->with('error', 'Stock record for this item and location already exists');
        }

        DB::beginTransaction();
        try {
            $stock = Stock::create([
                'barang_id' => $request->barang_id,
                'quantity' => $request->quantity,
                'minimum_stock' => $request->minimum_stock,
                'maximum_stock' => $request->maximum_stock ?? 0,
                'location' => $request->location,
                'batch_number' => $request->batch_number,
                'expiry_date' => $request->expiry_date,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Create initial stock movement record
            StockMovement::create([
                'barang_id' => $request->barang_id,
                'stock_id' => $stock->id,
                'type' => 'initial_stock',
                'quantity_before' => 0,
                'quantity_after' => $request->quantity,
                'adjustment' => $request->quantity,
                'notes' => 'Initial stock entry',
                'created_by' => Auth::id(),
            ]);

            // Create notification if low stock
            if ($request->quantity <= $request->minimum_stock) {
                Notification::create([
                    'user_id' => Auth::id(),
                    'type' => 'low_stock_alert',
                    'title' => 'Low Stock Alert',
                    'message' => "Stock for {$stock->barang->nama_barang} is below minimum threshold",
                    'data' => json_encode([
                        'stock_id' => $stock->id,
                        'barang_id' => $request->barang_id,
                        'current_quantity' => $request->quantity,
                        'minimum_stock' => $request->minimum_stock
                    ]),
                    'action_url' => route('logistik.stock.show', $stock->id),
                    'icon' => 'ph-warning-circle',
                    'color' => 'text-warning'
                ]);
            }

            DB::commit();
            return redirect()->route('logistik.stock.index')
                ->with('success', 'Stock record created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create stock record: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified stock record
     */
    public function show($id)
    {
        $stock = Stock::with(['barang', 'creator', 'updater'])->findOrFail($id);
        
        // Get recent movements
        $movements = StockMovement::where('stock_id', $id)
                                 ->with('creator')
                                 ->latest()
                                 ->take(10)
                                 ->get();

        return view('logistik.stock.show', compact('stock', 'movements'));
    }

    /**
     * Show the form for editing the specified stock record
     */
    public function edit($id)
    {
        $stock = Stock::with('barang')->findOrFail($id);
        $barangs = Barang::where('status', 'aktif')->orderBy('nama_barang')->get();
        
        return view('logistik.stock.edit', compact('stock', 'barangs'));
    }

    /**
     * Update the specified stock record
     */
    public function update(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        
        $request->validate([
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'location' => 'required|string|max:255',
            'batch_number' => 'nullable|string|max:100',
            'expiry_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $stock->update([
            'minimum_stock' => $request->minimum_stock,
            'maximum_stock' => $request->maximum_stock ?? 0,
            'location' => $request->location,
            'batch_number' => $request->batch_number,
            'expiry_date' => $request->expiry_date,
            'notes' => $request->notes,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('logistik.stock.index')
            ->with('success', 'Stock record updated successfully');
    }

    /**
     * Remove the specified stock record
     */
    public function destroy($id)
    {
        $stock = Stock::findOrFail($id);
        
        if ($stock->quantity > 0) {
            return back()->with('error', 'Cannot delete stock record with existing quantity');
        }

        $stock->delete();
        
        return back()->with('success', 'Stock record deleted successfully');
    }

    /**
     * Adjust stock quantity
     */
    public function adjust(Request $request, $id)
    {
        $stock = Stock::findOrFail($id);
        
        $request->validate([
            'adjustment_type' => 'required|in:increase,decrease',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string|max:500'
        ]);

        $adjustment = $request->adjustment_type === 'increase' ? $request->quantity : -$request->quantity;
        $newQuantity = $stock->quantity + $adjustment;

        if ($newQuantity < 0) {
            return back()->with('error', 'Adjustment would result in negative stock');
        }

        DB::beginTransaction();
        try {
            $oldQuantity = $stock->quantity;
            $stock->update(['quantity' => $newQuantity]);

            // Create movement record
            StockMovement::create([
                'barang_id' => $stock->barang_id,
                'stock_id' => $stock->id,
                'type' => $request->adjustment_type,
                'quantity_before' => $oldQuantity,
                'quantity_after' => $newQuantity,
                'adjustment' => $adjustment,
                'notes' => $request->reason . ($request->notes ? ' - ' . $request->notes : ''),
                'created_by' => Auth::id(),
            ]);

            // Create notification for low stock
            if ($newQuantity <= $stock->minimum_stock && $oldQuantity > $stock->minimum_stock) {
                Notification::create([
                    'user_id' => Auth::id(),
                    'type' => 'low_stock_alert',
                    'title' => 'Low Stock Alert',
                    'message' => "Stock for {$stock->barang->nama_barang} is now below minimum threshold",
                    'data' => json_encode([
                        'stock_id' => $stock->id,
                        'barang_id' => $stock->barang_id,
                        'current_quantity' => $newQuantity,
                        'minimum_stock' => $stock->minimum_stock
                    ]),
                    'action_url' => route('logistik.stock.show', $stock->id),
                    'icon' => 'ph-warning-circle',
                    'color' => 'text-warning'
                ]);
            }

            DB::commit();
            return back()->with('success', 'Stock adjusted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to adjust stock: ' . $e->getMessage());
        }
    }

    /**
     * Display stock movements
     */
    public function movements(Request $request)
    {
        $query = StockMovement::with(['barang', 'stock', 'creator']);

        if ($request->barang_id) {
            $query->where('barang_id', $request->barang_id);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->latest()->paginate(20);

        $barangs = Barang::where('status', 'aktif')->orderBy('nama_barang')->get();
        $types = StockMovement::distinct()->pluck('type');

        return view('logistik.stock.movements', compact('movements', 'barangs', 'types'));
    }
}