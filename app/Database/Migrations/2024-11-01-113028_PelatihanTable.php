<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PelatihanTable extends Migration
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
            'peserta_id' => [
                'type'           => 'BIGINT',
            ],
            'master_class_id' => [
                'type'           => 'BIGINT',
            ],
            'voucher' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
            ],
            'redeem_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'is_finished' => [
                'type'       => 'INT',
                'constraint' => '2',
                'default' => 0
            ],
            'is_paymented' => [
                'type'       => 'INT',
                'constraint' => '2',
                'default' => 0
            ],
            'is_claimed' => [
                'type'       => 'INT',
                'constraint' => '2',
                'default' => 0
            ],
            'payment_period' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'claim_period' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'commission' => [
                'type'       => 'INT',
                'constraint' => '10',
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
        $this->forge->createTable('pelatihans');
    }

    public function down()
    {
        $this->forge->dropTable('pelatihans');
    }
}
