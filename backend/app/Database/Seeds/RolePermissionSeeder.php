<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Admin
            [
                'role_id' => 1,
                'permission_id' => 1,
            ],
            [
                'role_id' => 1,
                'permission_id' => 2,
            ],
            [
                'role_id' => 1,
                'permission_id' => 3,
            ],
            [
                'role_id' => 1,
                'permission_id' => 4,
            ],
            // Pembantu
            [
                'role_id' => 2,
                'permission_id' => 2,
            ],
        ];

        $this->db->table('role_permission')->insertBatch($data);
    }
}