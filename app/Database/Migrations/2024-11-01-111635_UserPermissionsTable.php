<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UserPermissionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'           => 'BIGINT',
            ],
            'permission_id' => [
                'type'           => 'BIGINT',
            ],

        ]);
        $this->forge->createTable('user_permissions');
    }

    public function down()
    {
        $this->forge->dropTable('user_permissions');
    }
}
