<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DPSeeder extends Seeder
{
    public function run()
    {
        $db2 = \Config\Database::connect('monitor_db');
        $this->db->table('digital_platforms')->truncate();

        $builder = $db2->table('tb_digitalplatform');
        $digital_platforms = $builder->get()->getResult();
        $insert_data = [];
        $data = [];
        foreach ($digital_platforms as $key => $digital_platform) {
            $data['dp_name'] = $digital_platform->nama_dp;
            $data['user_create'] = $digital_platform->user_create;
            $data['user_update'] = $digital_platform->user_update === null ? $digital_platform->user_create : $digital_platform->user_create;
            $data['created_at'] = $digital_platform->created_at;
            $data['updated_at'] = $digital_platform->update_at === null ? $digital_platform->created_at : $digital_platform->update_at;
            array_push($insert_data, $data);
        }
        foreach (array_chunk($insert_data, 100) as $key => $datas) {
            $this->db->table('digital_platforms')->insertBatch($datas);
        };
    }
}
