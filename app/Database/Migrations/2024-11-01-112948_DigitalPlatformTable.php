<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DigitalPlatformTable extends Migration
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
            'dp_name' => [
                'type' => 'VARCHAR',
                'constraint' => '100'
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
        $this->forge->createTable('digital_platforms');
    }

    public function down()
    {
        $this->forge->dropTable('digital_platforms');
    }
}
