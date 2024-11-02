<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterClassTable extends Migration
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
            'class_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jam' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'is_prakerja' => [
                'type'       => 'INT',
                'constraint' => '2',
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'price' => [
                'type'       => 'BIGINT',
                'constraint' => '100',
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
        $this->forge->createTable('master_classes');
    }

    public function down()
    {
        $this->forge->dropTable('master_classes');
    }
}
