<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MitraSeeder extends Seeder
{
    public function run()
    {
        $db2 = \Config\Database::connect('monitor_db');
        $this->db->table('mitras')->truncate();

        $builder = $db2->table('tb_mitra');
        $mitras = $builder->get()->getResult();
        $insert_data = [];
        $data = [];
        foreach ($mitras as $key => $mitra) {
            $data['mitra_name'] = md5($mitra->nama_mitra);
            $data['address'] = $mitra->lokasi;
            $data['responsible'] = $mitra->penanggung_jawab;
            $data['user_create'] = $mitra->user_create;
            $data['user_update'] = $mitra->user_update === null ? $mitra->user_create : $mitra->user_create;
            $data['created_at'] = $mitra->created_at;
            $data['updated_at'] = $mitra->update_at === null ? $mitra->created_at : $mitra->update_at;
            array_push($insert_data, $data);
        }
        foreach (array_chunk($insert_data, 100) as $key => $datas) {
            $this->db->table('mitras')->insertBatch($datas);
        };
    }
}
