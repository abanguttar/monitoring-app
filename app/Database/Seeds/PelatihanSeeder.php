<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PelatihanSeeder extends Seeder
{
    public function run()
    {
        $db2 = \Config\Database::connect('monitor_db');
        $this->db->table('pelatihans')->truncate();

        $builder = $db2->table('tb_pelatihan as pl')
            ->join('tb_progres_pelatihan as pgr', 'pgr.id_pelatihan = pl.id_pelatihan', 'left')
            ->select('pl.*, pgr.redemption, pgr.review, pgr.pembayaran, pgr.periode, pgr.persentase_komisi');
        $pelatihans = $builder->get()->getResult();
        $insert_data = [];
        $data = [];
        foreach ($pelatihans as $key => $pelatihan) {
            $data['peserta_id'] = (int) $pelatihan->id_peserta;
            $data['master_class_id'] = $pelatihan->id_master_pelatihan;
            $data['voucher'] = $pelatihan->voucher_pelatihan;
            $data['invoice'] = $pelatihan->invoice;
            $data['redeem_code'] = $pelatihan->redemption;
            $data['is_finished'] = $pelatihan->review;
            $data['is_paymented'] = $pelatihan->pembayaran === null ? 0 : 1;
            $data['payment_period'] = $pelatihan->periode;
            $data['commission'] = $pelatihan->persentase_komisi;
            $data['user_create'] = $pelatihan->user_create;
            $data['user_update'] = $pelatihan->user_update === null ? $pelatihan->user_create : $pelatihan->user_create;
            $data['created_at'] = $pelatihan->created_at;
            $data['updated_at'] = $pelatihan->update_at === null ? $pelatihan->created_at : $pelatihan->update_at;
            array_push($insert_data, $data);
        }
        foreach (array_chunk($insert_data, 100) as $key => $datas) {
            $this->db->table('pelatihans')->insertBatch($datas);
        };
    }
}
