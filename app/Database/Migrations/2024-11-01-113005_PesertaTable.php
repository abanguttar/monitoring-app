<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PesertaTable extends Migration
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
            'mitra_id' => [
                'type'       => 'BIGINT',
            ],
            'digital_platform_id' => [
                'type'       => 'BIGINT',
            ],
            'peserta_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',

            ],
            'phone' => [
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
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('pesertas');
    }

    public function down()
    {
        $this->forge->dropTable('pesertas');
    }
}
