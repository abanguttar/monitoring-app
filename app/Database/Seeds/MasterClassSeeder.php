<?php

namespace App\Database\Seeds;

use App\Models\MasterClass;
use CodeIgniter\Database\Seeder;

class MasterClassSeeder extends Seeder
{
    public function run()
    {
        $db2 = \Config\Database::connect('monitor_db');
        $this->db->table('master_classes')->truncate();

        $builder = $db2->table('tb_master_pelatihan');
        $master_pelatihans = $builder->get()->getResult();
        $insert_data = [];
        $data = [];
        foreach ($master_pelatihans as $key => $mp) {
            $data['class_name'] = $mp->nama_pelatihan;
            $data['jadwal'] = $mp->jadwal;
            $data['jam'] = $mp->jam_pelatihan;
            $data['is_prakerja'] = 1;
            $data['tipe'] = $mp->tipe;
            $data['price'] = $mp->harga_kelas;
            $data['user_create'] = $mp->user_create;
            $data['user_update'] = $mp->user_update === null ? $mp->user_create : $mp->user_create;
            $data['created_at'] = $mp->created_at;
            $data['updated_at'] = $mp->update_at === null ? $mp->created_at : $mp->update_at;
            array_push($insert_data, $data);
        }
        foreach (array_chunk($insert_data, 100) as $key => $datas) {
            $this->db->table('master_classes')->insertBatch($datas);
        };
    }
}
