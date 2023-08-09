<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissonSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'hak_akses' => 'create.pegawai',
            ],
            [
                'hak_akses' => 'read.pegawai',
            ],
            [
                'hak_akses' => 'update.pegawai',
            ],
            [
                'hak_akses' => 'delete.pegawai',
            ],
        ];
        $this->db->table('permission')->insertBatch($data);
    }
}