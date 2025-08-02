<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\Vendor;
use App\Models\PengajuanBarangHRD;
use App\Models\Pembelian;
use App\Models\Notification;
use App\Enums\RoleEnum;

class ProcurementSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test users if they don't exist
        $this->createTestUsers();
        
        // Create test pelamars
        $this->createTestPelamars();
        
        // Create test vendors
        $this->createTestVendors();
        
        // Create test HRD procurement requests
        $this->createTestProcurementRequests();
        
        // Create test notifications
        $this->createTestNotifications();
    }

    private function createTestUsers()
    {
        // Create HRD user if doesn't exist
        $hrdUser = User::where('email', 'hrd@test.com')->first();
        if (!$hrdUser) {
            $hrdUser = User::create([
                'name' => 'HRD Test User',
                'email' => 'hrd@test.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $hrdUser->assignRole(RoleEnum::HRD);
        }

        // Create Logistik user if doesn't exist
        $logistikUser = User::where('email', 'logistik@test.com')->first();
        if (!$logistikUser) {
            $logistikUser = User::create([
                'name' => 'Logistik Test User',
                'email' => 'logistik@test.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $logistikUser->assignRole(RoleEnum::Logistik);
        }

        // Create SuperAdmin user if doesn't exist
        $superAdminUser = User::where('email', 'superadmin@test.com')->first();
        if (!$superAdminUser) {
            $superAdminUser = User::create([
                'name' => 'SuperAdmin Test User',
                'email' => 'superadmin@test.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $superAdminUser->assignRole(RoleEnum::SuperAdmin);
        }
    }

    private function createTestPelamars()
    {
        $pelamars = [
            [
                'nama' => 'John Doe',
                'email' => 'john.doe@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Test No. 1, Jakarta',
                'posisi_dilamar' => 'Software Developer',
                'status' => 'diterima',
                'tanggal_diterima' => now()->subDays(5),
                'catatan' => 'Pelamar dengan skill programming yang baik',
            ],
            [
                'nama' => 'Jane Smith',
                'email' => 'jane.smith@example.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Test No. 2, Jakarta',
                'posisi_dilamar' => 'UI/UX Designer',
                'status' => 'diterima',
                'tanggal_diterima' => now()->subDays(3),
                'catatan' => 'Pelamar dengan portfolio design yang menarik',
            ],
            [
                'nama' => 'Bob Wilson',
                'email' => 'bob.wilson@example.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Test No. 3, Jakarta',
                'posisi_dilamar' => 'Marketing Specialist',
                'status' => 'diterima',
                'tanggal_diterima' => now()->subDays(1),
                'catatan' => 'Pelamar dengan pengalaman marketing digital',
            ]
        ];

        foreach ($pelamars as $pelamarData) {
            if (!Pelamar::where('email', $pelamarData['email'])->exists()) {
                Pelamar::create($pelamarData);
            }
        }
    }

    private function createTestVendors()
    {
        $vendors = [
            [
                'nama_vendor' => 'PT. Teknologi Maju',
                'kategori' => 'Electronics',
                'alamat' => 'Jl. Vendor No. 1, Jakarta Selatan',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '12345',
                'telepon' => '021-1234567',
                'email' => 'sales@teknologimaju.com',
                'website' => 'https://www.teknologimaju.com',
                'contact_person' => 'Ahmad Vendor',
                'jabatan_contact_person' => 'Sales Manager',
                'telepon_contact_person' => '081234567890',
                'email_contact_person' => 'ahmad@teknologimaju.com',
                'bank' => 'BCA',
                'nomor_rekening' => '1234567890',
                'nama_rekening' => 'PT. Teknologi Maju',
                'npwp' => '12.345.678.9-012.345',
                'rating' => 4.5,
                'status' => 'aktif',
                'catatan' => 'Vendor laptop dan komputer terpercaya',
                'created_by' => User::role(RoleEnum::Logistik)->first()->id,
            ],
            [
                'nama_vendor' => 'CV. Office Supplies',
                'kategori' => 'Office Supplies',
                'alamat' => 'Jl. Vendor No. 2, Jakarta Pusat',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '10110',
                'telepon' => '021-2345678',
                'email' => 'info@officesupplies.com',
                'contact_person' => 'Siti Vendor',
                'jabatan_contact_person' => 'Account Manager',
                'telepon_contact_person' => '081234567891',
                'email_contact_person' => 'siti@officesupplies.com',
                'bank' => 'Mandiri',
                'nomor_rekening' => '0987654321',
                'nama_rekening' => 'CV. Office Supplies',
                'rating' => 4.0,
                'status' => 'aktif',
                'catatan' => 'Vendor alat tulis kantor dan furniture',
                'created_by' => User::role(RoleEnum::Logistik)->first()->id,
            ],
            [
                'nama_vendor' => 'PT. Furniture Jaya',
                'kategori' => 'Furniture',
                'alamat' => 'Jl. Vendor No. 3, Jakarta Timur',
                'kota' => 'Jakarta',
                'provinsi' => 'DKI Jakarta',
                'kode_pos' => '13220',
                'telepon' => '021-3456789',
                'email' => 'sales@furniturejaya.com',
                'contact_person' => 'Budi Vendor',
                'jabatan_contact_person' => 'Sales Executive',
                'telepon_contact_person' => '081234567892',
                'email_contact_person' => 'budi@furniturejaya.com',
                'bank' => 'BRI',
                'nomor_rekening' => '5432167890',
                'nama_rekening' => 'PT. Furniture Jaya',
                'rating' => 3.8,
                'status' => 'aktif',
                'catatan' => 'Vendor meja, kursi, dan lemari kantor',
                'created_by' => User::role(RoleEnum::Logistik)->first()->id,
            ]
        ];

        foreach ($vendors as $vendorData) {
            if (!Vendor::where('email', $vendorData['email'])->exists()) {
                Vendor::create($vendorData);
            }
        }
    }

    private function createTestProcurementRequests()
    {
        $hrdUser = User::role(RoleEnum::HRD)->first();
        $logistikUser = User::role(RoleEnum::Logistik)->first();
        $superAdminUser = User::role(RoleEnum::SuperAdmin)->first();
        $pelamars = Pelamar::where('status', 'diterima')->get();

        $procurementRequests = [
            [
                'pelamar_id' => $pelamars[0]->id,
                'pelamar_name' => $pelamars[0]->nama,
                'posisi_diterima' => $pelamars[0]->posisi_dilamar,
                'tanggal_masuk' => now()->addDays(7),
                'departemen' => 'IT Development',
                'items' => [
                    [
                        'nama_barang' => 'Laptop Dell Inspiron 15',
                        'spesifikasi' => 'Intel Core i5, 8GB RAM, 512GB SSD',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 12000000,
                        'keperluan' => 'Laptop kerja untuk developer'
                    ],
                    [
                        'nama_barang' => 'Mouse Wireless',
                        'spesifikasi' => 'Logitech MX Master 3',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 1500000,
                        'keperluan' => 'Perangkat input'
                    ],
                    [
                        'nama_barang' => 'Monitor LED 24 inch',
                        'spesifikasi' => 'Full HD, IPS Panel',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 3000000,
                        'keperluan' => 'Monitor tambahan untuk development'
                    ]
                ],
                'total_estimasi' => 16500000,
                'keperluan' => 'Peralatan kerja untuk software developer baru',
                'prioritas' => 'tinggi',
                'tanggal_dibutuhkan' => now()->addDays(5),
                'catatan_hrd' => 'Pelamar akan mulai bekerja minggu depan, mohon diprioritaskan',
                'status' => 'pending',
                'created_by' => $hrdUser->id,
            ],
            [
                'pelamar_id' => $pelamars[1]->id,
                'pelamar_name' => $pelamars[1]->nama,
                'posisi_diterima' => $pelamars[1]->posisi_dilamar,
                'tanggal_masuk' => now()->addDays(10),
                'departemen' => 'Creative Design',
                'items' => [
                    [
                        'nama_barang' => 'MacBook Pro 14 inch',
                        'spesifikasi' => 'Apple M2 Pro, 16GB RAM, 512GB SSD',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 35000000,
                        'keperluan' => 'Laptop untuk design grafis'
                    ],
                    [
                        'nama_barang' => 'Tablet Wacom',
                        'spesifikasi' => 'Wacom Intuos Pro Medium',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 5000000,
                        'keperluan' => 'Drawing tablet untuk design'
                    ]
                ],
                'total_estimasi' => 40000000,
                'keperluan' => 'Peralatan design untuk UI/UX designer baru',
                'prioritas' => 'sedang',
                'tanggal_dibutuhkan' => now()->addDays(8),
                'catatan_hrd' => 'Designer membutuhkan spesifikasi tinggi untuk software design',
                'status' => 'logistik_approved',
                'created_by' => $hrdUser->id,
                'logistik_approved_by' => $logistikUser->id,
                'logistik_approved_at' => now()->subHours(2),
                'logistik_notes' => 'Disetujui, spesifikasi sesuai kebutuhan design',
            ],
            [
                'pelamar_id' => $pelamars[2]->id,
                'pelamar_name' => $pelamars[2]->nama,
                'posisi_diterima' => $pelamars[2]->posisi_dilamar,
                'tanggal_masuk' => now()->addDays(14),
                'departemen' => 'Marketing',
                'items' => [
                    [
                        'nama_barang' => 'Laptop Asus Vivobook',
                        'spesifikasi' => 'Intel Core i5, 8GB RAM, 512GB SSD',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 10000000,
                        'keperluan' => 'Laptop untuk kegiatan marketing'
                    ],
                    [
                        'nama_barang' => 'Kamera DSLR',
                        'spesifikasi' => 'Canon EOS 700D + Lens Kit',
                        'jumlah' => 1,
                        'satuan' => 'unit',
                        'estimasi_harga' => 8000000,
                        'keperluan' => 'Dokumentasi kegiatan marketing'
                    ]
                ],
                'total_estimasi' => 18000000,
                'keperluan' => 'Peralatan kerja untuk marketing specialist baru',
                'prioritas' => 'rendah',
                'tanggal_dibutuhkan' => now()->addDays(12),
                'catatan_hrd' => 'Marketing specialist untuk tim digital marketing',
                'status' => 'approved',
                'created_by' => $hrdUser->id,
                'logistik_approved_by' => $logistikUser->id,
                'logistik_approved_at' => now()->subDays(1),
                'logistik_notes' => 'Disetujui dengan sedikit penyesuaian budget',
                'superadmin_approved_by' => $superAdminUser->id,
                'superadmin_approved_at' => now()->subHours(6),
                'superadmin_notes' => 'Disetujui final, sesuai budget departemen',
            ]
        ];

        foreach ($procurementRequests as $requestData) {
            PengajuanBarangHRD::create($requestData);
        }
    }

    private function createTestNotifications()
    {
        $hrdUser = User::role(RoleEnum::HRD)->first();
        $logistikUser = User::role(RoleEnum::Logistik)->first();
        $superAdminUser = User::role(RoleEnum::SuperAdmin)->first();
        $pengajuanBarangs = PengajuanBarangHRD::all();

        $notifications = [
            // Notification for Logistik about new request
            [
                'user_id' => $logistikUser->id,
                'type' => 'procurement_request',
                'title' => 'Pengajuan Barang Baru',
                'message' => 'Pengajuan barang untuk pelamar ' . $pengajuanBarangs[0]->pelamar_name . ' memerlukan persetujuan',
                'data' => [
                    'pengajuan_barang_id' => $pengajuanBarangs[0]->id,
                    'pelamar_name' => $pengajuanBarangs[0]->pelamar_name,
                    'total_items' => count($pengajuanBarangs[0]->items)
                ],
                'action_url' => route('logistik.pengajuan-barang-hrd.show', $pengajuanBarangs[0]->id),
                'icon' => 'ph-shopping-cart',
                'color' => 'text-primary',
                'is_read' => false,
                'created_at' => now()->subMinutes(30),
            ],
            // Notification for SuperAdmin about logistik approval
            [
                'user_id' => $superAdminUser->id,
                'type' => 'procurement_approved_logistik',
                'title' => 'Pengajuan Disetujui Logistik',
                'message' => 'Pengajuan barang untuk ' . $pengajuanBarangs[1]->pelamar_name . ' telah disetujui logistik, menunggu approval final',
                'data' => [
                    'pengajuan_barang_id' => $pengajuanBarangs[1]->id,
                    'pelamar_name' => $pengajuanBarangs[1]->pelamar_name,
                    'total_estimasi' => $pengajuanBarangs[1]->total_estimasi
                ],
                'action_url' => route('superadmin.pengajuan-barang-hrd.show', $pengajuanBarangs[1]->id),
                'icon' => 'ph-check-circle',
                'color' => 'text-success',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            // Notification for HRD about final approval
            [
                'user_id' => $hrdUser->id,
                'type' => 'procurement_final_approved',
                'title' => 'Pengajuan Disetujui Final',
                'message' => 'Pengajuan barang untuk ' . $pengajuanBarangs[2]->pelamar_name . ' telah disetujui SuperAdmin',
                'data' => [
                    'pengajuan_barang_id' => $pengajuanBarangs[2]->id,
                    'pelamar_name' => $pengajuanBarangs[2]->pelamar_name,
                    'total_estimasi' => $pengajuanBarangs[2]->total_estimasi
                ],
                'action_url' => route('hrd.pengajuan-barang.show', $pengajuanBarangs[2]->id),
                'icon' => 'ph-check-square',
                'color' => 'text-success',
                'is_read' => true,
                'read_at' => now()->subHours(1),
                'created_at' => now()->subHours(6),
            ],
            // General system notification
            [
                'user_id' => $hrdUser->id,
                'type' => 'system_update',
                'title' => 'Sistem Pengajuan Barang',
                'message' => 'Sistem pengajuan barang HRD telah diperbarui dengan fitur notifikasi real-time',
                'data' => [
                    'update_version' => '2.0.0',
                    'features' => ['Real-time notifications', 'Multi-level approval', 'Vendor management']
                ],
                'action_url' => route('hrd.pengajuan-barang.index'),
                'icon' => 'ph-bell',
                'color' => 'text-info',
                'is_read' => false,
                'created_at' => now()->subDays(1),
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }
    }
}