<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolePermission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'permission_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('role_id', 'role', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permission', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('role_permission');
    }

    public function down()
    {
        $this->forge->dropTable('role_permission');
    }
}