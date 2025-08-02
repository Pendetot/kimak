<?php

namespace App\Http\Controllers\Logistik;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Stock;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    /**
     * Display a listing of items
     */
    public function index(Request $request)
    {
        $query = Barang::with(['stocks', 'creator']);

        // Apply filters
        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', "%{$request->search}%")
                  ->orWhere('kode_barang', 'like', "%{$request->search}%")
                  ->orWhere('deskripsi', 'like', "%{$request->search}%");
            });
        }

        if ($request->low_stock === 'true') {
            $query->whereHas('stocks', function ($q) {
                $q->whereRaw('quantity <= minimum_stock');
            });
        }

        $barangs = $query->latest()->paginate(15);

        // Statistics
        $stats = [
            'total_items' => Barang::count(),
            'active_items' => Barang::where('status', 'aktif')->count(),
            'low_stock_items' => Barang::whereHas('stocks', function ($q) {
                $q->whereRaw('quantity <= minimum_stock');
            })->count(),
            'out_of_stock' => Barang::whereHas('stocks', function ($q) {
                $q->where('quantity', 0);
            })->count(),
        ];

        $categories = Barang::distinct()->pluck('kategori')->filter();

        return view('logistik.barang.index', compact('barangs', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new item
     */
    public function create()
    {
        $categories = [
            'Office Supplies',
            'Electronics',
            'Furniture',
            'Stationery',
            'Computer Hardware',
            'Consumables',
            'Safety Equipment',
            'Other'
        ];

        return view('logistik.barang.create', compact('categories'));
    }

    /**
     * Store a newly created item
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
            'unit' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,tidak_aktif',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['created_by'] = Auth::id();

            // Handle file upload
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('barang-photos', 'public');
                $data['foto'] = $path;
            }

            // Generate barcode if not provided
            if (empty($data['barcode'])) {
                $data['barcode'] = 'BR' . str_pad(Barang::count() + 1, 6, '0', STR_PAD_LEFT);
            }

            $barang = Barang::create($data);

            // Create initial stock record
            Stock::create([
                'barang_id' => $barang->id,
                'quantity' => 0,
                'minimum_stock' => $request->minimum_stock,
                'maximum_stock' => $request->maximum_stock ?? 0,
                'location' => $request->lokasi_penyimpanan,
                'created_by' => Auth::id(),
            ]);

            // Create notification
            Notification::create([
                'user_id' => Auth::id(),
                'type' => 'item_created',
                'title' => 'New Item Added',
                'message' => "New item '{$barang->nama_barang}' has been added to inventory",
                'data' => json_encode([
                    'barang_id' => $barang->id,
                    'kode_barang' => $barang->kode_barang,
                    'nama_barang' => $barang->nama_barang
                ]),
                'action_url' => route('logistik.barang.show', $barang->id),
                'icon' => 'ph-package',
                'color' => 'text-success'
            ]);

            DB::commit();
            return redirect()->route('logistik.barang.index')
                ->with('success', 'Item created successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to create item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified item
     */
    public function show($id)
    {
        $barang = Barang::with(['stocks', 'creator', 'updater'])->findOrFail($id);
        
        // Get stock movements for this item
        $stockMovements = \DB::table('stock_movements')
            ->join('barangs', 'stock_movements.barang_id', '=', 'barangs.id')
            ->where('stock_movements.barang_id', $id)
            ->select('stock_movements.*', 'barangs.nama_barang')
            ->orderBy('stock_movements.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('logistik.barang.show', compact('barang', 'stockMovements'));
    }

    /**
     * Show the form for editing the specified item
     */
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        
        $categories = [
            'Office Supplies',
            'Electronics',
            'Furniture',
            'Stationery',
            'Computer Hardware',
            'Consumables',
            'Safety Equipment',
            'Other'
        ];

        return view('logistik.barang.edit', compact('barang', 'categories'));
    }

    /**
     * Update the specified item
     */
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);
        
        $request->validate([
            'kode_barang' => 'required|string|max:50|unique:barangs,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
            'unit' => 'required|string|max:20',
            'harga_satuan' => 'required|numeric|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'maximum_stock' => 'nullable|integer|min:0',
            'lokasi_penyimpanan' => 'nullable|string|max:255',
            'supplier' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:aktif,tidak_aktif',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['updated_by'] = Auth::id();

            // Handle file upload
            if ($request->hasFile('foto')) {
                // Delete old photo
                if ($barang->foto) {
                    Storage::disk('public')->delete($barang->foto);
                }
                $path = $request->file('foto')->store('barang-photos', 'public');
                $data['foto'] = $path;
            }

            $barang->update($data);

            // Update stock minimum/maximum
            $barang->stocks()->update([
                'minimum_stock' => $request->minimum_stock,
                'maximum_stock' => $request->maximum_stock ?? 0,
                'location' => $request->lokasi_penyimpanan,
                'updated_by' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('logistik.barang.index')
                ->with('success', 'Item updated successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Failed to update item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified item
     */
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        
        // Check if item has stock
        $currentStock = $barang->stocks()->sum('quantity');
        if ($currentStock > 0) {
            return back()->with('error', 'Cannot delete item with existing stock. Current stock: ' . $currentStock);
        }

        // Check if item is used in any transactions
        $hasTransactions = \DB::table('pengajuan_barangs')
            ->where('barang_requested', 'like', "%{$barang->nama_barang}%")
            ->exists();

        if ($hasTransactions) {
            return back()->with('error', 'Cannot delete item that has been used in transactions');
        }

        // Delete photo
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();
        
        return back()->with('success', 'Item deleted successfully');
    }
}