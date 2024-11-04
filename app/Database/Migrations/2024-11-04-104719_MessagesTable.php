<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ErrorMessagesTable extends Migration
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
            'master_class_id' => [
                'type'       => 'BIGINT',
                'constraint' => '10',
                'null' => true
            ],
            'mitra_id' => [
                'type'       => 'BIGINT',
                'constraint' => '10',
                'null' => true
            ],
            'peserta_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',

                'null' => true
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'voucher' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'invoice' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'redeem_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'is_finished' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'is_paymented' => [
                'type'       => 'INT',
                'constraint' => '10',
                'null' => true
            ],
            'payment_period' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'is_claimed' => [
                'type'       => 'INT',
                'constraint' => '2',
                'null' => true
            ],
            'claim_period' => [
                'type'       => 'VARCHAR',
                'constraint' => '200',
                'null' => true
            ],
            'message' => [
                'type'      => 'TEXT',
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
        $this->forge->createTable('messages');
    }

    public function down()
    {
        $this->forge->dropTable('messages');
    }
}
