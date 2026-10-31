# Persiapan Esai (Video) — 25% nilai

Jawab dengan bahasa sendiri sambil menunjukkan kode. Penguji menilai: kamu PAHAM atau tidak.

1. **Jelaskan alur data satu request (mis. simpan transaksi).**
   Browser kirim POST /transactions -> `routes/web.php` -> middleware `auth` + CSRF -> `TransactionController@store` -> `validate()` -> ambil kategori untuk menentukan `type` -> `$request->user()->transactions()->create()` (Eloquent) -> INSERT ber-parameter ke MySQL -> redirect + flash message -> View Blade menampilkan.
2. **Apa itu MVC di project ini?** Model = `app/Models`, View = `resources/views` (Blade), Controller = `app/Http/Controllers`. Routes menghubungkan URL ke controller.
3. **Jelaskan struktur database & relasinya.** 4 tabel: users, wallets, categories, transactions. 1 user punya banyak wallet/kategori/transaksi; transaksi belongs-to wallet & kategori. FK + cascadeOnDelete.
4. **Kenapa saldo dompet dihitung, bukan disimpan?** Menghindari data tidak konsisten (single source of truth = tabel transactions).
5. **Bagaimana CSRF dicegah?** `@csrf` di setiap form -> token di session; middleware `ValidateCsrfToken` menolak request tanpa token valid (419).
6. **Bagaimana XSS dicegah?** Blade `{{ }}` otomatis `htmlspecialchars`; input juga di-`strip_tags`; tidak ada `{!! !!}`.
7. **Bagaimana SQL Injection dicegah?** Eloquent/Query Builder memakai PDO prepared statements (binding parameter), tidak ada raw query dari input user.
8. **Bagaimana autentikasi & session?** `Auth::attempt`, password bcrypt (`Hash::make`), `session()->regenerate()` setelah login (anti session fixation), logout = invalidate + regenerateToken, session driver `database`.
9. **Bagaimana otorisasi/role?** Middleware `role:admin` (403 jika bukan admin). Data user dibatasi lewat query relasi `$request->user()->transactions()->findOrFail($id)` sehingga user A tidak bisa membuka data user B (404). `role` tidak ada di `$fillable` (anti mass-assignment).
10. **Penanganan error?** Validasi -> pesan error di form; `findOrFail` -> 404; role salah -> 403; hapus kategori/dompet yang masih dipakai ditolak dengan pesan; throttle login (429).
11. **Langkah deployment & konfigurasi environment?** Lihat README bagian Deployment. Variabel: APP_KEY, APP_ENV=production, APP_DEBUG=false, APP_URL, DB_*.
12. **Troubleshooting yang pernah dialami?** (ISI SENDIRI dengan masalah nyata yang kamu temui, mis. error koneksi DB, 500 karena APP_KEY, mixed content HTTPS, migrasi gagal.)
