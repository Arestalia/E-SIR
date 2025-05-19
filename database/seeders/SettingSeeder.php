<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('setting')->insert([
            'nama_perusahaan'     => 'E-SIR',
            'alamat'              => 'Jl. HOS Cokroaminoto No. 102, Kelurahan Enggal, Kecamatan Enggal, Bandar Lampung',
            'telepon'             => '0343244324',
            'tipe_nota'           => '1',
            'diskon'              => '0',
            'path_logo'           => '/img/logo-20250420073527.png',
            'path_kartu_member'   => '/img/member.png'
        ]);
    }
}
