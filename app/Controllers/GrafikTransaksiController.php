<?php

namespace App\Controllers;

use Config\Database;
use App\Models\MasterClass;
use CodeIgniter\API\ResponseTrait;
use App\Controllers\BaseController;
use App\Models\Mitra;
use CodeIgniter\HTTP\ResponseInterface;

class GrafikTransaksiController extends BaseController
{
    use ResponseTrait;
    protected $masterClass;
    protected $mitra;
    protected $db;
    protected $pelatihans;

    public function __construct()
    {
        $this->masterClass = new MasterClass();
        $this->mitra = new Mitra();
        $this->db = Database::connect();
        $this->pelatihans = $this->db->table('pelatihans as p')->join('master_classes as mc', 'mc.id = p.master_class_id', 'left');
    }

    public function index()
    {
        $title = 'Grafik Transaksi';
        $master_classes =  $this->masterClass->findAll();
        $pelatihans = array_unique(array_map(function ($x) {
            return trim($x['class_name']);
        }, $master_classes));

        $periodes = $this->db->table('pelatihans')->select('payment_period')->groupBy('payment_period')->where(array("payment_period IS NOT NULL" => NULL))->get()->getResult();

        return view('grafik/index', compact('title',  'master_classes', 'pelatihans', 'periodes'));
    }


    public function fetchPembelianPenyelesaian()
    {

        $requestInput = $this->request->getGet(['pelatihan', 'master_class_id']);
        $pelatihans =  $this->pelatihans;
        if (!empty($requestInput['pelatihan'])) {
            $pelatihans->like('mc.class_name', $requestInput['pelatihan']);
        } else if (!empty($requestInput['master_class_id'])) {
            $pelatihans->where('p.master_class_id', $requestInput['master_class_id']);
        }
        $pembelians =  clone $pelatihans;
        $redemptions =  clone $pelatihans;
        $completions =  clone $pelatihans;
        $pembelian =  $pembelians->countAllResults();
        $redemption =  $redemptions->where(array('redeem_code IS NOT NULL' => NULL))->countAllResults();
        $completion =  $completions->where(array('is_finished IS NOT NULL' => NULL))->countAllResults();

        $data = (object)[
            'title' => [
                'Pembelian',
                'Redemption',
                'Completion'
            ],
            'datasets' => [
                (object) [
                    'label' => 'Semua data kelas',
                    'data' => [$pembelian, $redemption, $completion],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ],
                    'hoverOffset' => 4

                ],

            ]
        ];


        return   $this->respond($data);
    }


    public function fetchPenjualanKelas()
    {
        $requestInput = $this->request->getGet(['pelatihan', 'master_class_id', 'periode']);
        $periode = $requestInput['periode'] ?? '2024';
        $year = $periode[2] . $periode[3];
        $periodes = [
            "Jan-$year",
            "Feb-$year",
            "Mar-$year",
            "Apr-$year",
            "May-$year",
            "Jun-$year",
            "Jul-$year",
            "Aug-$year",
            "Sep-$year",
            "Oct-$year",
            "Nov-$year",
            "Des-$year",
        ];

        $arrayMitras = [];
        $arrayNonMitras = [];

        foreach ($periodes as $periode) {
            $arrayMitras[$periode] = null;
            $arrayNonMitras[$periode] = null;
        }


        $datas = $this->pelatihans->join('pesertas as ps', 'ps.id = p.peserta_id', 'left');
        $dataNonMitras = clone $datas;
        $queryNonMitras = $dataNonMitras->where(array('ps.mitra_id = 0' => null))->select("DATE_FORMAT(p.created_at, '%b-%y') AS month_year")
            ->selectCount('p.id')->groupBy('month_year');
        $queryMitras = $datas->where(array('ps.mitra_id != 0' => null))->select('p.payment_period')->selectCount('p.id')->where(array('p.payment_period IS NOT NULL' => null))->groupBy('p.payment_period');

        if (!empty($requestInput['pelatihan'])) {
            $queryMitras->like('mc.class_name', $requestInput['pelatihan']);
            $queryNonMitras->like('mc.class_name', $requestInput['pelatihan']);
        } else if (!empty($requestInput['master_class_id'])) {
            $queryMitras->where('p.master_class_id', $requestInput['master_class_id']);
            $queryNonMitras->where('p.master_class_id', $requestInput['master_class_id']);
        }

        $nonMitras = $queryNonMitras->get()->getResult();
        $mitras = $queryMitras->get()->getResult();

        foreach ($nonMitras as $val) {
            $arrayNonMitras[$val->month_year] = (int) $val->id;
        }
        foreach ($mitras as $val) {
            $arrayMitras[$val->payment_period] = (int) $val->id;
        }

        $result = [];


        foreach ($periodes as $periode) {
            $obj = (object)[
                'x' => $periode,
                'mitra' => $arrayMitras[$periode],
                'nonMitra' => $arrayNonMitras[$periode]
            ];
            array_push($result, $obj);
        }

        $data = (object)[
            'title' => $periodes,
            'datasets' => [
                (object) [
                    'label' => 'Mitra',
                    'data' => $result,
                    'parsing' => (object) [
                        'yAxisKey' => 'mitra'
                    ],
                    'backgroundColor' => '#20c997',
                    'borderColor' => '#20c997',
                    'borderWidth' => 2
                ],
                (object) [
                    'label' => 'Non Mitra',
                    'data' => $result,
                    'parsing' => (object) [
                        'yAxisKey' => 'nonMitra'
                    ],
                    'backgroundColor' => '#6610f2',
                    'borderColor' => '#6610f2',
                    'borderWidth' => 2
                ],

            ]
        ];


        return   $this->respond($data);
    }

    public function fetchPenjualanMitra()
    {
        $requestInput = $this->request->getGet(['pelatihan', 'master_class_id', 'periode']);

        $mitras = array_map(function ($x) {
            return $x['mitra_name'];
        }, $this->mitra->findAll());
        $query = $this->pelatihans->join('pesertas as ps', 'ps.id = p.peserta_id', 'left')->join('mitras as m', 'm.id = ps.mitra_id', 'left')
            ->select('p.id, mc.id, mc.class_name, ps.mitra_id, m.mitra_name')
            ->where(array("ps.mitra_id != 0" => null));


        if (!empty($requestInput['pelatihan'])) {
            $query->like('mc.class_name', $requestInput['pelatihan']);
        } else if (!empty($requestInput['master_class_id'])) {
            $query->where('p.master_class_id', $requestInput['master_class_id']);
        } else if (!empty($requestInput['periode'])) {
            $query->where('p.payment_period', $requestInput['periode']);
        }

        $datas = $query->get()->getResult();
        $arrayMitras = [];
        $result = [];
        foreach ($datas as $data) {
            $arrayMitras[$data->mitra_name][] = $data->id;
        }


        foreach ($arrayMitras  as $key => $m) {
            $obj = (object)[
                'x' => $key,
                'value' => count($arrayMitras[$key])
            ];
            array_push($result, $obj);
        }

        $data = (object)[
            'title' => $mitras,
            'datasets' => [
                (object) [
                    'label' => 'Jumlah Penjualan Terafiliasi Mitra Semua Periode',
                    'data' => $result,
                    'parsing' => (object) [
                        'yAxisKey' => 'value'
                    ],
                    'backgroundColor' => '#20c997',
                    'borderColor' => '#20c997',
                    'borderWidth' => 2
                ],


            ]
        ];

        return $this->respond($data);
    }
}
