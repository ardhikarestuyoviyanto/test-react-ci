<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_pegawai' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ]
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}