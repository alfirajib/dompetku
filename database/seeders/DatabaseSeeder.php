<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Idempotent: aman dijalankan berulang kali (mis. saat deploy)
        if (User::where('email', 'admin@dompetku.test')->exists()) {
            return;
        }

        // forceCreate dipakai karena 'role' tidak ada di $fillable
        User::forceCreate([
            'name' => 'Administrator',
            'email' => 'admin@dompetku.test',
            'password' => Hash::make('Admin12345'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user = User::forceCreate([
            'name' => 'Budi Santoso',
            'email' => 'budi@dompetku.test',
            'password' => Hash::make('User12345'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);

        // Kategori
        $cats = [];
        foreach (['Gaji', 'Freelance', 'Bonus'] as $n) {
            $cats[$n] = $user->categories()->create(['name' => $n, 'type' => 'income']);
        }
        foreach (['Makanan', 'Transportasi', 'Tagihan', 'Hiburan', 'Belanja'] as $n) {
            $cats[$n] = $user->categories()->create(['name' => $n, 'type' => 'expense']);
        }

        // Dompet
        $wallets = [
            'Dompet Tunai' => $user->wallets()->create(['name' => 'Dompet Tunai', 'initial_balance' => 500000]),
            'Rekening BCA' => $user->wallets()->create(['name' => 'Rekening BCA', 'initial_balance' => 2000000]),
            'E-Wallet' => $user->wallets()->create(['name' => 'E-Wallet', 'initial_balance' => 250000]),
        ];

        // Transaksi 3 bulan terakhir: [kategori, dompet, nominal, deskripsi, tanggal(hari)]
        $rows = [
            ['Gaji', 'Rekening BCA', 5000000, 'Gaji bulanan', 1],
            ['Freelance', 'Rekening BCA', 1200000, 'Proyek website klien', 15],
            ['Makanan', 'Dompet Tunai', 350000, 'Makan mingguan', 3],
            ['Makanan', 'E-Wallet', 275000, 'Pesan makanan online', 12],
            ['Makanan', 'Dompet Tunai', 420000, 'Makan akhir bulan', 24],
            ['Transportasi', 'E-Wallet', 180000, 'Ojek online', 5],
            ['Transportasi', 'Dompet Tunai', 150000, 'Bensin', 18],
            ['Tagihan', 'Rekening BCA', 750000, 'Listrik & internet', 8],
            ['Hiburan', 'E-Wallet', 120000, 'Langganan streaming & game', 10],
            ['Belanja', 'Rekening BCA', 640000, 'Kebutuhan bulanan', 20],
        ];

        foreach ([0, 1, 2] as $i) {
            $base = now()->startOfMonth()->subMonths($i);
            foreach ($rows as [$cat, $wallet, $amount, $desc, $day]) {
                $user->transactions()->create([
                    'wallet_id' => $wallets[$wallet]->id,
                    'category_id' => $cats[$cat]->id,
                    'type' => $cats[$cat]->type,
                    'amount' => $amount,
                    'description' => $desc,
                    'transaction_date' => $base->copy()->day($day)->toDateString(),
                ]);
            }
        }
        // Bonus hanya bulan ini
        $user->transactions()->create([
            'wallet_id' => $wallets['E-Wallet']->id,
            'category_id' => $cats['Bonus']->id,
            'type' => 'income',
            'amount' => 800000,
            'description' => 'Bonus proyek',
            'transaction_date' => now()->startOfMonth()->day(22)->toDateString(),
        ]);
    }
}
