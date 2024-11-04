<?php

namespace App\Controllers;

use App\Models\Pelatihan;
use App\Models\MasterClass;
use App\Controllers\BaseController;
use App\Models\Payment;
use App\Models\Peserta;
use App\Models\Progress;
use CodeIgniter\HTTP\ResponseInterface;
use DateTime;

class PelatihanController extends BaseController
{

    protected $peserta;
    protected $progress;
    protected $pelatihan;
    protected $payment;
    protected $masterClass;
    protected $db;


    public function __construct()
    {
        parent::__construct();
        $this->peserta = new Peserta();
        $this->pelatihan = new Pelatihan();
        $this->progress = new Progress();
        $this->masterClass = new MasterClass();
        $this->payment = new Payment();
        $this->db =  \Config\Database::connect();
    }

    private function getPelatihan($id, $mc_id)
    {
        $builder = $this->db->table('pelatihans as pl');
        $builder->join('pesertas as p', 'p.id = pl.peserta_id', 'left')
            ->where('pl.peserta_id', $id)->where('pl.master_class_id', $mc_id);
        return $builder->get()->getResult()[0];
    }
    private function getProgress($id)
    {
        $builder = $this->db->table('pelatihans as pl');
        $builder->join('pesertas as p', 'p.id = pl.peserta_id', 'left')
            ->join('master_classes as mp', 'mp.id = pl.master_class_id', 'left')
            ->where('pl.id', $id);
        return $builder->get()->getResult()[0];
    }

    public function new(int $id)
    {
        helper('form');
        $title = 'Add New Pelatihan';
        $peserta = $this->peserta->find($id);
        $master_classes = $this->masterClass->findAll();
        return view('pelatihan/create', compact('title', 'peserta', 'master_classes'));
    }


    public function create(int $peserta_id)
    {
        helper('form');
        $pelatihan = $this->request->getPost(['invoice', 'voucher', 'master_class_id']);
        $pelatihan['peserta_id'] = $peserta_id;
        $data_pelatihan = array_merge($pelatihan, $this->user_create_update);
        $is_mc_exist = $this->pelatihan->where('peserta_id', $peserta_id)->first();
        $validateInvoiceVoucher = $this->validateInvoiceVoucher($pelatihan['invoice'], $pelatihan['voucher']);

        /**
         * Check is peserta have existed master class?
         */
        $errors = [];

        if ($is_mc_exist['master_class_id'] === $pelatihan['master_class_id']) {
            array_push($errors, 'Pelatihan already exists!');
        }

        if ($validateInvoiceVoucher['voucher'] !== null) {
            array_push($errors, 'Voucher already exists!');
        }
        if ($validateInvoiceVoucher['invoice'] !== null) {
            array_push($errors, 'Invoice already exists!');
        }

        if (count($errors)  !== 0) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }


        if (!$this->pelatihan->save($data_pelatihan)) {
            // Handle pelatihan insertion failure
            return redirect()->back()->withInput()->with('errors', $this->pelatihan->errors());
        }

        $this->successInsert();
        return redirect()->to("/peserta/$peserta_id/add-pelatihan");
    }


    public function edit(int $peserta_id, int $master_class_id)
    {
        helper('form');
        $title = 'Edit Pelatihan';

        $peserta = $this->getPelatihan($peserta_id, $master_class_id);

        $master_classes = $this->masterClass->findAll();
        return view('pelatihan/edit', compact('title', 'peserta', 'master_classes'));
    }



    public function update(int $peserta_id, int $master_class_id)
    {
        helper('form');

        $pelatihan = $this->request->getPost(['invoice', 'voucher', 'master_class_id']);
        $data_pelatihan = array_merge($pelatihan, $this->user_update);
        $is_mc_exist = $this->pelatihan->where('peserta_id', $peserta_id)->whereNotIn('master_class_id', [$master_class_id])->get()->getResult();
        $is_invoice_exist = $this->pelatihan->where('invoice', $pelatihan['invoice'])->whereNotIn('peserta_id', [$peserta_id])->first();
        $is_voucher_exist = $this->pelatihan->where('voucher', $pelatihan['voucher'])->whereNotIn('peserta_id', [$peserta_id])->first();

        /**
         * Check is peserta have existed master class?
         */
        $errors = [];

        if ($master_class_id !== $pelatihan['master_class_id']) {

            $array_master_class_id = array_map(function ($x) {
                return (int) $x->master_class_id;
            }, $is_mc_exist);

            if (in_array($pelatihan['master_class_id'], $array_master_class_id)) {
                array_push($errors, 'Pelatihan already exists!');
            }
        }

        if ($is_invoice_exist !== null) {
            array_push($errors, 'Voucher already exists!');
        }
        if ($is_voucher_exist !== null) {
            array_push($errors, 'Invoice already exists!');
        }

        if (count($errors)  !== 0) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }


        if (!$this->pelatihan
            ->where('peserta_id', $peserta_id)
            ->where('master_class_id', $master_class_id)
            ->set($data_pelatihan)
            ->update()) {
            // Handle pelatihan insertion failure
            return redirect()->back()->withInput()->with('errors', $this->pelatihan->errors());
        }

        $this->successUpdate();
        return redirect()->to("/peserta/$peserta_id/edit-pelatihan/$master_class_id");
    }

    public function addProgress(int $id)
    {
        helper('form');
        $title = 'Add Progress';
        $progress = $this->getProgress($id);
        return view('pelatihan/progress', compact('title', 'progress'));
    }

    public function updateProgress(int $id)
    {
        helper('form');
        $progress = $this->request->getPost(['redeem_code']);
        $old_redeem_code = $this->request->getPost(['old_redeem_code']);
        $redeem_code = $progress['redeem_code'];
        if ($old_redeem_code !== $redeem_code) {
            $builder = $this->db->table('pelatihans')->where('redeem_code', $redeem_code)->whereNotIn('id', [$id]);
            $is_redeem_exists = $builder->get()->getResult();
            if (count($is_redeem_exists) !== 0) {
                return redirect()->back()->withInput()->with('errors', ['Redeem code already exists!']);
            }
        }
        $checked_box = $this->request->getPost(['checked_box']);

        if ($checked_box['checked_box']  === 'checked') {
            $progress['is_finished'] = $this->request->getPost(['is_finished']);
        }

        if (!$this->progress->update($id, $progress)) {
            return redirect()->back()->withInput()->with('errors', $this->progress->errors());
        }

        $this->successUpdate();
        return redirect()->to("/peserta/$id/add-progress");
    }

    public function editPayment(int $id)
    {
        helper('form');
        $title = 'Update Payment';
        $progress = $this->getProgress($id);
        return view('pelatihan/payment', compact('title', 'progress'));
    }

    public function updatePayment(int $id)
    {
        helper('form');
        $payment = $this->request->getPost(['is_paymented']);

        $progress = $this->progress->find($id);

        if ($progress['is_finished'] === null) {
            return redirect()->back()->withInput()->with('errors', ['Update payment only if pelatihan is finished!']);
        }

        $payment['payment_period'] = null;
        if ($payment['is_paymented'] === '1') {
            $payment['payment_period'] = $this->request->getPost(['payment_period']);
        }

        if (!$this->payment->update($id, $payment)) {
            return redirect()->back()->withInput()->with('errors', $this->payment->errors());
        }

        $this->successUpdate();
        return redirect()->to("/peserta/$id/update-payment");
    }
}
