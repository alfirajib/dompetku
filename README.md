# DompetKu — Aplikasi Pencatatan Keuangan Pribadi

Aplikasi web full-stack (Laravel 12 + MySQL, arsitektur MVC) untuk mencatat pemasukan dan pengeluaran serta melihat ringkasan keuangan lewat dashboard.
UAS Web Application Development — Universitas Cakrawala.

- **Aplikasi live:** https://dompetku.infinityfreeapp.com
- **Repository:** https://github.com/alfirajib/dompetku

## Akun Demo
| Role  | Email               | Password   |
|-------|---------------------|------------|
| Admin | admin@dompetku.test | Admin12345 |
| User  | budi@dompetku.test  | User12345  |

## Fitur
- Registrasi, login, logout (session) dengan pembatasan percobaan login (throttle)
- Dashboard: total saldo, pemasukan dan pengeluaran bulan ini, grafik tren 6 bulan, grafik pengeluaran per kategori
- CRUD Dompet, Kategori, dan Transaksi (filter jenis dan bulan, pagination)
- Role-based access: `admin` (kelola pengguna) dan `user` (data pribadi)
- Keamanan: CSRF, XSS (escape Blade + strip_tags), prepared statements (Eloquent), validasi server-side, bcrypt, anti mass-assignment

## Teknologi
PHP 8.2+, Laravel 12, MySQL, Blade, Bootstrap 5, Chart.js

## Struktur MVC
```
app/Models/            User, Wallet, Category, Transaction
app/Http/Controllers/  AuthController, DashboardController, WalletController,
                       CategoryController, TransactionController, Admin/UserController
app/Http/Middleware/   RoleMiddleware
database/migrations/   skema tabel
database/seeders/      data dummy
database/dompetku.sql  dump database lengkap (struktur + data demo)
resources/views/       layouts, auth, dashboard, wallets, categories, transactions, admin
routes/web.php         seluruh routing
docs/                  ERD dan diagram alur (Mermaid)
```

## Instalasi di Komputer Lokal
Kebutuhan: PHP >= 8.2, Composer, MySQL 8 atau MariaDB, Git.

1. `git clone https://github.com/alfirajib/dompetku.git`
2. `cd dompetku`
3. `composer install`
4. `cp .env.example .env` (Windows: `copy .env.example .env`)
5. `php artisan key:generate`
6. Buat database kosong bernama `dompetku`, lalu sesuaikan `DB_USERNAME` dan `DB_PASSWORD` di `.env`.
7. Pilih salah satu:
   - `php artisan migrate --seed`, atau
   - import file `database/dompetku.sql` ke database `dompetku`.
8. `php artisan serve`, lalu buka http://127.0.0.1:8000

## Deployment (InfinityFree)
1. Buat akun hosting gratis di InfinityFree dengan subdomain `dompetku.infinityfreeapp.com`.
2. Di Control Panel → MySQL Databases, buat database `dompetku` (nama lengkap berawalan `if0_...`). Catat hostname, username, dan password.
3. Buka phpMyAdmin, pilih database tersebut, tab Import, lalu import `database/dompetku.sql`.
4. Di komputer lokal, siapkan salinan bersih: clone repo, jalankan `composer install --no-dev` (tanpa `--optimize-autoloader` karena file PHP di hosting dibatasi 1 MB), dan hapus isi `bootstrap/cache`.
5. Buat `.env` produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY` dari `php artisan key:generate --show`, `APP_URL=https://dompetku.infinityfreeapp.com`, `SESSION_DRIVER=database`, `CACHE_STORE=database`, `QUEUE_CONNECTION=sync`, serta `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` sesuai panel hosting.
6. Buat file `.htaccess` di folder paling luar berisi:
   ```
   RewriteEngine On
   RewriteRule (.*) /public/$1 [L]
   ```
   Ini karena web root InfinityFree selalu `htdocs`, sehingga request harus diarahkan ke folder `public`.
7. Upload seluruh isi project (`app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, `vendor`, `.env`, `.htaccess`, `artisan`, `composer.json`, `composer.lock`) ke folder `htdocs` memakai FileZilla (FTP).
8. Buka URL aplikasi dan login memakai akun demo. Pastikan `/.env` tidak dapat diakses (404).

### Troubleshooting yang dialami
- Composer memblokir Laravel 11 karena security advisory, sehingga memakai Laravel 12.
- Layanan hosting awal (Railway) tidak tersedia karena trial habis, sehingga dipindah ke InfinityFree.
- Dump SQL awal hanya berisi data tanpa struktur tabel, sehingga dibuat ulang lengkap dengan `CREATE TABLE`.
- Koneksi FTP sering terputus; diatasi dengan menurunkan jumlah transfer paralel dan memproses ulang antrian.