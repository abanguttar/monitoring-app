<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        $permissions['list_master_class'] = ['view', 'create', 'update'];
        $permissions['list_digital_platform'] = ['view', 'create', 'update'];
        $permissions['list_mitra'] = ['view', 'create', 'update'];
        $permissions['list_peserta'] = [
            'view',
            'create',
            'edit peserta',
            'add pelatihan',
            'edit pelatihan',
            'add progress',
            'update pembayaran',
            'update mitra',
            'import data pembelian',
            'import data redemption',
            'import data completion',
            'import data reconcile'
        ];

        $datas = [];
        foreach ($permissions as $key => $value) {

            foreach ($permissions[$key] as  $val) {

                $datas[] =  $array = [
                    'groups' => $key,
                    'name' => $val,
                ];
            }
        }
        $db->table('permissions')->truncate();
        $db->table('permissions')->insertBatch($datas);
    }
}
