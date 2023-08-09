<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_user' => 'User Admin',
                'username' => 'admin',
                'password' => password_hash("123", PASSWORD_DEFAULT),
                'role_id' => 1
            ],
            [
                'nama_user' => 'User Pembantu',
                'username' => 'pembantu',
                'password' => password_hash("123", PASSWORD_DEFAULT),
                'role_id' => 2
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}