# 🏢 Human Resources Management System (HRMS)

Sistem Manajemen Sumber Daya Manusia yang komprehensif dan modern, dibangun menggunakan Laravel dengan arsitektur role-based access control yang robust.

## 📋 Daftar Isi

- [Overview](#-overview)
- [Fitur Utama](#-fitur-utama)
- [Arsitektur Sistem](#-arsitektur-sistem)
- [Role & Permission](#-role--permission)
- [Teknologi Stack](#-teknologi-stack)
- [Struktur Direktori](#-struktur-direktori)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Database Schema](#-database-schema)
- [API Endpoints](#-api-endpoints)
- [Development Guidelines](#-development-guidelines)
- [Testing](#-testing)
- [Deployment](#-deployment)
- [Contributing](#-contributing)

## 🎯 Overview

HRMS ini adalah sistem manajemen sumber daya manusia yang dirancang untuk mengelola seluruh siklus hidup karyawan dalam perusahaan, mulai dari rekrutmen hingga keluar dari perusahaan. Sistem ini mendukung multi-role dengan akses terbatas sesuai dengan tingkat jabatan dan tanggung jawab.

### 🌟 Keunggulan Sistem

- **Multi-Role Management**: 6 level akses yang berbeda
- **Real-time Notifications**: System notifikasi terintegrasi
- **Document Management**: Upload dan manajemen dokumen karyawan
- **Financial Integration**: Modul keuangan terintegrasi
- **Approval Workflow**: System approval berlapis
- **Security First**: Implementasi Laravel Sanctum untuk API security

## 🚀 Fitur Utama

### 👤 Manajemen Pelamar (Recruitment)
- **Pendaftaran Online**: Form pendaftaran pelamar dengan validasi lengkap
- **Document Upload**: Upload CV, foto, dan dokumen pendukung
- **Interview Scheduling**: Penjadwalan wawancara dan tracking status
- **Test Results**: Manajemen hasil psikotes, kesehatan, dan PAT
- **Approval Process**: Workflow persetujuan dari HRD hingga direktur

### 👥 Manajemen Karyawan
- **Employee Database**: Database karyawan lengkap dengan profil detail
- **Attendance Management**: Sistem absensi dengan tracking ketidakhadiran
- **Performance Management**: KPI tracking dan penilaian performa
- **Training Records**: Catatan pembinaan dan pelatihan karyawan
- **Document Management**: Penyimpanan dokumen karyawan

### 📝 Manajemen HRD
- **Leave Management**: Sistem cuti dengan approval workflow
- **Mutation Management**: Pengelolaan mutasi jabatan/departemen
- **Warning Letters**: Sistem surat peringatan dan penalty
- **Resignation Process**: Proses pengunduran diri karyawan
- **Procurement Requests**: Pengajuan barang untuk kebutuhan HRD

### 💰 Manajemen Keuangan
- **Employee Banking**: Manajemen rekening karyawan
- **Debt Management**: Tracking hutang karyawan dengan kategorisasi
- **Payroll Integration**: Integrasi dengan sistem penggajian
- **Financial Reports**: Laporan keuangan terkait karyawan

### 📦 Manajemen Logistik
- **Item Procurement**: Sistem pengajuan barang dengan approval
- **Inventory Tracking**: Tracking barang yang telah disetujui
- **Delivery Confirmation**: Tanda terima barang
- **Vendor Management**: Manajemen supplier/vendor

### 🔧 Super Admin
- **User Management**: Manajemen user dan role assignment
- **System Settings**: Konfigurasi sistem global
- **Purchase Management**: Approval pembelian barang
- **System Monitoring**: Monitoring aktivitas sistem

## 🏗️ Arsitektur Sistem

### 🔐 Role & Permission

Sistem menggunakan enum-based role management dengan 6 level akses:

```php
enum RoleEnum: string
{
    case SuperAdmin = 'superadmin';  // Full system access
    case HRD = 'hrd';               // HR operations
    case Keuangan = 'keuangan';     // Financial operations
    case Karyawan = 'karyawan';     // Employee self-service
    case Logistik = 'logistik';     // Logistics operations
    case Pelamar = 'pelamar';       // Applicant portal
}
```

### 📊 Database Design

**Core Entities:**
- **Users**: Authentication dan role management
- **Pelamar**: Candidate management dengan lifecycle lengkap
- **Karyawan**: Employee master data
- **Absensi**: Attendance tracking
- **Pengajuan Barang**: Multi-level approval procurement
- **Keuangan**: Financial records dan debt management

### 🔄 Workflow Pattern

Sistem menggunakan state-based workflow untuk approval process:

1. **Request Initiation**: User mengajukan request
2. **Department Review**: Review oleh departemen terkait
3. **Management Approval**: Approval tingkat manajemen
4. **Finance Validation**: Validasi keuangan (jika diperlukan)
5. **Final Execution**: Eksekusi final request

## 💻 Teknologi Stack

### Backend
- **Framework**: Laravel 10+ (PHP 8.1+)
- **Authentication**: Laravel Sanctum
- **Database**: MySQL/PostgreSQL
- **File Storage**: Laravel Storage (Local/S3)
- **Queue System**: Redis/Database queue
- **Mail**: SMTP/SES integration

### Frontend
- **Template Engine**: Blade Templates
- **CSS Framework**: Bootstrap/Tailwind CSS
- **JavaScript**: Vanilla JS/Alpine.js
- **Icons**: Font Awesome/Heroicons

### Development Tools
- **Testing**: PHPUnit
- **Code Quality**: PHP CS Fixer, PHPStan
- **API Documentation**: Laravel API Documentation
- **Version Control**: Git

## 📁 Struktur Direktori

```
project-root/
├── app/
│   ├── Console/                # Artisan commands
│   ├── Enums/                  # System enumerations
│   │   └── RoleEnum.php        # User roles definition
│   ├── Exceptions/             # Custom exceptions
│   ├── Http/
│   │   └── Controllers/        # Controllers by domain
│   │       ├── Auth/           # Authentication logic
│   │       ├── General/        # General purpose controllers
│   │       ├── HRD/            # HR management
│   │       ├── Karyawan/       # Employee operations
│   │       ├── Keuangan/       # Financial operations
│   │       ├── Logistik/       # Logistics management
│   │       └── SuperAdmin/     # System administration
│   ├── Mail/                   # Email templates
│   ├── Models/                 # Eloquent models
│   ├── Notifications/          # Notification classes
│   ├── Providers/              # Service providers
│   ├── Services/               # Business logic services
│   └── Traits/                 # Reusable traits
├── database/
│   ├── factories/              # Model factories
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   └── views/                  # Blade templates
│       ├── auth/               # Authentication views
│       ├── hrd/                # HR department views
│       ├── karyawan/           # Employee portal views
│       ├── keuangan/           # Finance views
│       ├── logistik/           # Logistics views
│       └── superadmin/         # Admin panel views
└── routes/
    ├── api.php                 # API routes
    └── web.php                 # Web routes
```

## 🛠️ Installation

### Prerequisites

- PHP >= 8.1
- Composer
- MySQL/PostgreSQL
- Node.js & NPM (untuk frontend assets)
- Redis (optional, untuk queue dan cache)

### Step 1: Clone Repository

```bash
git clone <repository-url>
cd hrms-project
```

### Step 2: Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (jika ada)
npm install
```

### Step 3: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Database Configuration

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hrms_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls

# Queue Configuration (Optional)
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Step 5: Database Migration & Seeding

```bash
# Run migrations
php artisan migrate

# Run seeders (optional)
php artisan db:seed

# Create storage link
php artisan storage:link
```

### Step 6: Build Frontend Assets

```bash
# Compile assets
npm run build

# Or for development
npm run dev
```

### Step 7: Start Development Server

```bash
# Start Laravel development server
php artisan serve

# Start queue worker (di terminal terpisah)
php artisan queue:work
```

## ⚙️ Configuration

### 🔧 System Settings

Sistem menggunakan model `Setting` untuk konfigurasi dinamis:

```php
// Key settings yang tersedia:
- 'is_form_enabled': Enable/disable registration form
- 'website_footer_description': Footer description
- 'website_logo': Company logo
- 'website_made_by_text': Made by text
```

### 🔐 Role-Based Access Control

Implementasi middleware untuk proteksi routes:

```php
// Route protection example
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/hrd/dashboard', [HRDController::class, 'dashboard']);
});
```

### 📧 Email Configuration

Setup email templates untuk notifikasi:

```php
// Notification classes tersedia di app/Notifications/
- NewApplicationNotification
- ApprovalNotification  
- ReminderNotification
```

## 🗄️ Database Schema

### 📋 Core Tables

#### Users Table
```sql
- id: Primary key
- name: Full name
- email: Email address (unique)
- password: Hashed password
- role: RoleEnum value
- created_at, updated_at: Timestamps
```

#### Pelamar Table
```sql
- id: Primary key
- nama_lengkap: Full name
- email: Email address
- no_telp: Phone number
- alamat: Address
- posisi_yang_dilamar: Applied position
- status: Application status
- interview_date: Interview schedule
- interview_status: Interview result
- cv_path: CV file path
- foto_path: Photo file path
- created_at, updated_at: Timestamps
```

#### Pengajuan Barang Table
```sql
- id: Primary key
- requester_id: User ID who requested
- nama_barang: Item name
- spesifikasi: Item specification
- jumlah: Quantity
- harga_estimasi: Estimated price
- keperluan: Purpose/reason
- status: Approval status
- catatan: Notes/comments
- approved_by_logistic: Logistic approval
- approved_by_director: Director approval
- created_at, updated_at: Timestamps
```

### 🔗 Relationships

- **User** hasMany **PengajuanBarang** (as requester)
- **Pelamar** hasMany **PelamarDocument**
- **Karyawan** hasMany **Absensi**, **Cuti**, **KPI**
- **HutangKaryawan** belongsTo **Karyawan**

## 🌐 API Endpoints

### 🔐 Authentication Endpoints

```http
POST /api/superadmin/auth/login
POST /api/hrd/auth/login  
POST /api/keuangan/auth/login
POST /api/karyawan/auth/login
POST /api/logistik/auth/login
POST /api/logout
```

### 👤 User Management

```http
GET /api/user                    # Get authenticated user
PUT /api/user/profile           # Update profile
POST /api/user/change-password  # Change password
```

### 📋 Pelamar Management

```http
GET /api/pelamar                # List all applicants
POST /api/pelamar               # Create new application
GET /api/pelamar/{id}           # Get applicant details
PUT /api/pelamar/{id}           # Update applicant
DELETE /api/pelamar/{id}        # Delete applicant
POST /api/pelamar/{id}/documents # Upload documents
```

### 📦 Procurement Management

```http
GET /api/pengajuan-barang       # List procurement requests
POST /api/pengajuan-barang      # Create new request
PUT /api/pengajuan-barang/{id}/approve # Approve request
PUT /api/pengajuan-barang/{id}/reject  # Reject request
```

## 👨‍💻 Development Guidelines

### 🎯 Coding Standards

1. **PSR-12**: Follow PSR-12 coding standard
2. **Naming Convention**: 
   - Controllers: `PascalCase` + `Controller` suffix
   - Models: `PascalCase` singular
   - Methods: `camelCase`
   - Variables: `snake_case` atau `camelCase`

3. **Documentation**: Semua method harus memiliki PHPDoc
4. **Validation**: Gunakan Form Request untuk validasi complex
5. **Services**: Business logic harus di dalam Service classes

### 🏗️ Architecture Patterns

#### Service Pattern
```php
// app/Services/PelamarService.php
class PelamarService
{
    public function createApplication(array $data): Pelamar
    {
        // Business logic untuk create pelamar
    }
    
    public function approveApplication(Pelamar $pelamar): bool
    {
        // Business logic untuk approval
    }
}
```

#### Repository Pattern (Optional)
```php
// app/Repositories/PelamarRepository.php
interface PelamarRepositoryInterface
{
    public function findByStatus(string $status): Collection;
    public function findWithDocuments(int $id): Pelamar;
}
```

#### Trait Usage
```php
// app/Traits/HasApprovalWorkflow.php
trait HasApprovalWorkflow
{
    public function approve(): bool
    {
        $this->status = 'approved';
        return $this->save();
    }
}
```

### 🔒 Security Best Practices

1. **Input Validation**: Selalu validasi input user
2. **SQL Injection**: Gunakan Eloquent ORM atau prepared statements
3. **XSS Protection**: Escape output menggunakan Blade `{{ }}` 
4. **CSRF Protection**: Aktif untuk semua forms
5. **File Upload**: Validasi type dan size file upload
6. **Rate Limiting**: Implementasi rate limiting untuk API

### 📝 Database Best Practices

1. **Migrations**: Gunakan migration untuk semua schema changes
2. **Indexing**: Index kolom yang sering di-query
3. **Foreign Keys**: Selalu define foreign key constraints
4. **Soft Deletes**: Gunakan untuk data yang sensitive
5. **Timestamps**: Aktifkan timestamps untuk audit trail

## 🧪 Testing

### Unit Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter=PelamarTest

# Run with coverage
php artisan test --coverage
```

### Feature Testing

```php
// tests/Feature/PelamarTest.php
class PelamarTest extends TestCase
{
    public function test_can_create_pelamar()
    {
        $response = $this->post('/api/pelamar', [
            'nama_lengkap' => 'John Doe',
            'email' => 'john@example.com',
            // ... other data
        ]);
        
        $response->assertStatus(201);
    }
}
```

### Database Testing

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class PelamarTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_pelamar_creation()
    {
        $pelamar = Pelamar::factory()->create();
        $this->assertDatabaseHas('pelamars', [
            'id' => $pelamar->id
        ]);
    }
}
```

## 🚀 Deployment

### Production Environment

#### Server Requirements
- PHP 8.1+ dengan extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
- MySQL 8.0+ atau PostgreSQL 12+
- Nginx/Apache web server
- Redis (untuk cache dan queue)
- SSL Certificate

#### Deployment Steps

1. **Server Setup**
```bash
# Install dependencies
sudo apt update
sudo apt install php8.1-fpm nginx mysql-server redis-server

# Install PHP extensions
sudo apt install php8.1-{bcmath,ctype,fileinfo,json,mbstring,openssl,pdo,tokenizer,xml,mysql,redis}
```

2. **Code Deployment**
```bash
# Clone dan setup
git clone <repository-url> /var/www/hrms
cd /var/www/hrms
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Set permissions
sudo chown -R www-data:www-data /var/www/hrms
sudo chmod -R 755 /var/www/hrms
sudo chmod -R 775 /var/www/hrms/storage
sudo chmod -R 775 /var/www/hrms/bootstrap/cache
```

3. **Environment Configuration**
```bash
# Copy production environment
cp .env.production .env

# Generate key dan cache config
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

4. **Database Setup**
```bash
# Run migrations
php artisan migrate --force

# Create storage link
php artisan storage:link
```

5. **Process Management**
```bash
# Setup supervisor untuk queue worker
sudo apt install supervisor

# Create supervisor config
sudo nano /etc/supervisor/conf.d/hrms-worker.conf
```

Supervisor configuration:
```ini
[program:hrms-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/hrms/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/hrms/storage/logs/worker.log
stopwaitsecs=3600
```

#### Performance Optimization

1. **Caching Strategy**
```bash
# Enable all caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Setup Redis untuk session dan cache
# Edit .env:
SESSION_DRIVER=redis
CACHE_DRIVER=redis
```

2. **Database Optimization**
```sql
-- Index untuk performa query
CREATE INDEX idx_pelamar_status ON pelamars(status);
CREATE INDEX idx_pengajuan_status ON pengajuan_barangs(status);
CREATE INDEX idx_user_role ON users(role);
```

3. **File Storage Optimization**
```bash
# Setup S3 untuk file storage (optional)
# Edit .env:
FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your_key
AWS_SECRET_ACCESS_KEY=your_secret
AWS_DEFAULT_REGION=your_region
AWS_BUCKET=your_bucket
```

### Monitoring & Logging

#### Application Monitoring
```bash
# Setup log rotation
sudo nano /etc/logrotate.d/hrms

# Log rotation config:
/var/www/hrms/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 644 www-data www-data
}
```

#### Performance Monitoring
```php
// Monitor key metrics
- Response time per endpoint
- Database query performance  
- Queue job processing time
- File upload success rate
- Email delivery rate
```

## 🤝 Contributing

### Development Workflow

1. **Fork Repository**
2. **Create Feature Branch**
   ```bash
   git checkout -b feature/new-feature
   ```

3. **Development**
   - Write code following standards
   - Add tests untuk new features
   - Update documentation

4. **Testing**
   ```bash
   php artisan test
   ```

5. **Code Quality Check**
   ```bash
   # Format code
   ./vendor/bin/php-cs-fixer fix
   
   # Static analysis
   ./vendor/bin/phpstan analyse
   ```

6. **Submit Pull Request**

### Contribution Guidelines

- Follow PSR-12 coding standards
- Write meaningful commit messages
- Include tests untuk new functionality
- Update documentation
- Ensure backward compatibility

### Bug Reports

Untuk melaporkan bug, sertakan:
- Laravel version
- PHP version
- Step to reproduce
- Expected vs actual behavior
- Error logs (jika ada)

## 📞 Support & Documentation

### 📚 Dokumentasi Tambahan

- **API Documentation**: `/docs` endpoint (Laravel API Documentation)
- **Database Schema**: ERD diagram di `/docs/database`
- **Deployment Guide**: `/docs/deployment`
- **Troubleshooting**: `/docs/troubleshooting`

### 🆘 Getting Help

- **Issues**: GitHub Issues untuk bug reports
- **Discussions**: GitHub Discussions untuk questions
- **Email**: support@company.com
- **Slack**: #hrms-support channel

### 📈 Roadmap

#### Version 2.0 (Planned)
- [ ] Mobile Application (React Native/Flutter)
- [ ] Advanced Analytics Dashboard
- [ ] Integration dengan external payroll systems
- [ ] Multi-language support
- [ ] Advanced reporting dengan chart/graph
- [ ] WhatsApp notification integration
- [ ] Document e-signature integration

#### Version 1.5 (Next Release)
- [ ] Real-time notifications
- [ ] Advanced search dan filtering
- [ ] Bulk operations untuk data management
- [ ] Export data ke Excel/PDF
- [ ] API rate limiting
- [ ] Enhanced security features

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## ⭐ Acknowledgments

- Laravel Framework untuk foundation yang solid
- Bootstrap/Tailwind untuk UI components
- Laravel Sanctum untuk API authentication
- Community contributors

---

**Built with ❤️ for modern HR management**