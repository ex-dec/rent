<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jenis;
use App\Models\Ruang;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'operator']);
        Role::create(['name' => 'pegawai']);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@rent.com',
            'password' => bcrypt('admin'),
        ]);
        $admin->assignRole('admin');
        $operator = User::create([
            'name' => 'Operator',
            'email' => 'operator@rent.com',
            'password' => bcrypt('operator'),
        ]);
        $operator->assignRole('operator');
        $operator = User::create([
            'name' => 'Pegawai',
            'email' => 'pegawai@rent.com',
            'password' => bcrypt('pegawai'),
        ]);
        $operator->assignRole('pegawai');
        // User::factory(10)->create();
        Jenis::create([
            'nama' => 'Laptop',
            'kode' => 'LT',
            'keterangan' => 'Barang elektronik yang berbentuk seperti buku.'
        ]);
        Jenis::create([
            'nama' => 'Proyektor',
            'kode' => 'PR',
            'keterangan' => 'Alat yang digunakan untuk menampilkan gambar.'
        ]);

        // ruang seeder
        Ruang::create([
            'nama' => 'Ruang A',
            'kode' => 'RA',
            'keterangan' => 'Ruang yang berada di lantai 1.'
        ]);
    }
}
