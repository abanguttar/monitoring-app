<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTableUserAddTipeUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'tipe' => [
                'type'           => 'INT',
                'comment' => '999 for superadmin, 1 for admin',
                'after' => 'active',
                'default' => 1
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'tipe');
    }
}
