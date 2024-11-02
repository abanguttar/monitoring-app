<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MitraTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'mitra_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'address' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true
            ],
            'responsible' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'user_create' => [
                'type' => 'BIGINT',
            ],
            'user_update' => [
                'type' => 'BIGINT',
                'null' => true
            ],
            'created_at' => [
                'type' => 'TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true
            ],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mitras');
    }

    public function down()
    {
        $this->forge->dropTable('mitras');
    }
}
