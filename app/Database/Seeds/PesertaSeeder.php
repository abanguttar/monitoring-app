<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PesertaSeeder extends Seeder
{
    public function run()
    {
        $db2 = \Config\Database::connect('monitor_db');
        $this->db->table('pesertas')->truncate();

        $builder = $db2->table('tb_peserta');
        $pesertas = $builder->get()->getResult();
        $insert_data = [];
        $data = [];
        foreach ($pesertas as $key => $peserta) {

            $data['id'] = $peserta->id_peserta;
            $data['mitra_id'] = $peserta->id_mitra;
            $data['digital_platform_id'] = $peserta->id_dp;
            $data['peserta_name'] = $peserta->nama_peserta;
            $data['email'] = md5($peserta->email) . "@gmail.com";
            $data['phone'] = $peserta->no_hp;
            $data['user_create'] = $peserta->user_create;
            $data['user_update'] = $peserta->user_update === null ? $peserta->user_create : $peserta->user_create;
            $data['created_at'] = $peserta->created_at;
            $data['updated_at'] = $peserta->update_at === null ? $peserta->created_at : $peserta->update_at;
            array_push($insert_data, $data);
        }
        foreach (array_chunk($insert_data, 100) as $key => $datas) {
            $this->db->table('pesertas')->insertBatch($datas);
        };
    }
}
