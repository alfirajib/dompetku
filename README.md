# DompetKu — Aplikasi Pencatatan Keuangan Pribadi

Aplikasi web full-stack (Laravel + MySQL, arsitektur MVC) untuk mencatat pemasukan & pengeluaran serta melihat ringkasan keuangan lewat dashboard.
UAS Web Application Development — Universitas Cakrawala.

## Fitur
- Registrasi, login, logout (session) + throttle login
- Dashboard: total saldo, pemasukan/pengeluaran bulan ini, grafik tren 6 bulan, grafik pengeluaran per kategori
- CRUD Dompet, Kategori, Transaksi (filter jenis & bulan, pagination)
- Role-based access: `admin` (kelola pengguna) dan `user` (data pribadi)
- Keamanan: CSRF, XSS (escape Blade + strip_tags), prepared statements (Eloquent), validasi server-side, bcrypt

## Kebutuhan
PHP >= 8.2, Composer, MySQL 8 / MariaDB, Git

## Instalasi Lokal
```bash
git clone <URL-REPO> dompetku && cd dompetku
composer install
cp .env.example .env
php artisan key:generate
```
Edit `.env`:
```
APP_NAME=DompetKu
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dompetku
DB_USERNAME=root
DB_PASSWORD=
SESSION_DRIVER=database
```
Buat database `dompetku` di MySQL, lalu:
```bash
php artisan migrate --seed
php artisan serve
```
Buka http://localhost:8000

Alternatif tanpa migrasi: import `database/dompetku.sql` ke database `dompetku`.

## Akun Demo
| Role  | Email               | Password   |
|-------|---------------------|------------|
| Admin | admin@dompetku.test | Admin12345 |
| User  | budi@dompetku.test  | User12345  |

## Struktur MVC
```
app/Models/            User, Wallet, Category, Transaction
app/Http/Controllers/  AuthController, DashboardController, WalletController,
                       CategoryController, TransactionController, Admin/UserController
app/Http/Middleware/   RoleMiddleware
database/migrations/   skema tabel
database/seeders/      data dummy
resources/views/       layouts, auth, dashboard, wallets, categories, transactions, admin
routes/web.php         seluruh routing
```

## Deployment (Railway)
1. Push project ke GitHub.
2. Railway -> New Project -> Deploy from GitHub repo.
3. Add Service -> Database -> MySQL.
4. Pada service aplikasi -> Variables:
   - `APP_ENV=production`, `APP_DEBUG=false`, `APP_KEY=<hasil php artisan key:generate --show>`
   - `APP_URL=https://<domain-railway-anda>`
   - `DB_CONNECTION=mysql`
   - `DB_HOST=${{MySQL.MYSQLHOST}}`, `DB_PORT=${{MySQL.MYSQLPORT}}`, `DB_DATABASE=${{MySQL.MYSQLDATABASE}}`, `DB_USERNAME=${{MySQL.MYSQLUSER}}`, `DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}`
   - `SESSION_DRIVER=database`, `LOG_CHANNEL=stderr`
5. Settings -> Pre-deploy Command: `php artisan migrate --force --seed`
6. Settings -> Networking -> Generate Domain.
