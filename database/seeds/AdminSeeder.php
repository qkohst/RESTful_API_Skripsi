<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Menambahkan seeder data user admin
        DB::table('users')->insert([
            'nama' => 'Admin',
            'username' => '1490000001',
            'password' => bcrypt('1490000001'),
            'role' => 'Admin',
            'api_token' => bcrypt('1490000001' . 'Admin'),
        ]);

        //Menambahkan data seeder identitas admin
        DB::table('admin')->insert([
            'user_id_user' => '1',
            'nik_admin' => '3523063003820001',
            'nidn_admin' => '1490000001',
            'nama_admin' => 'Admin',
            'tempat_lahir_admin' => 'Tuban',
            'tanggal_lahir_admin' => '1982-03-30',
            'jenis_kelamin_admin' => 'L',
            'email_admin' => 'admin@mail.com',
            'no_hp_admin' => '085656876876'
        ]);
    }
}
