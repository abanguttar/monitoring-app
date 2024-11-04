<?php

namespace App\Controllers;

use App\Models\Mitra;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Peserta;
use App\Models\Progress;
use App\Models\Pelatihan;
use App\Models\MasterClass;
use App\Models\DigitalPlatform;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class PesertaController extends BaseController
{
    protected $peserta;
    protected $pelatihan;
    protected $masterClass;
    protected $message;
    protected $db;


    public function __construct()
    {
        parent::__construct();
        $this->peserta = new Peserta();
        $this->pelatihan = new Pelatihan();
        $this->masterClass = new MasterClass();
        $this->message = new Message();
        $this->db      = \Config\Database::connect();
    }

    private function getPelatihan($id, $mc_id)
    {
        $builder = $this->db->table('pelatihans as pl');
        $builder->join('pesertas as p', 'p.id = pl.peserta_id', 'left')
            ->join('mitras as mc', 'mitra.id = pl.master_class_id', 'left')
            ->where('pl.peserta_id', $id)->where('pl.master_class_id', $mc_id);
        return $builder->get()->getResult()[0];
    }

    public function index()
    {
        $title = 'Peserta';
        helper('form');

        $perPage = 50;
        $params = $this->request->getGet(['peserta_name', 'pelatihans', 'master_class_id', 'voucher', 'invoice', 'redeem_code', 'payment_period']);

        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $perPage;
        $builder = $this->db->table('pelatihans as pl');
        $builder->join('pesertas as p', 'p.id = pl.peserta_id', 'left');
        $builder->join('master_classes as mc', 'mc.id = pl.master_class_id', 'left');
        $builder->join('mitras as m', 'm.id = p.mitra_id', 'left');
        $builder->join('users as u', 'u.id = pl.user_update', 'left');
        $builder->select(
            'pl.* , p.mitra_id, p.digital_platform_id, p.peserta_name, p.email, p.phone, m.mitra_name , mc.class_name,mc.jadwal,
            mc.jam,
            mc.is_prakerja,
            mc.tipe,
            mc.price,
            u.username'
        );


        if (!empty($params['peserta_name'])) {
            $builder->like('p.peserta_name', $params['peserta_name'])
                ->orLike('p.email', $params['peserta_name']);
        }

        if (!empty($params['pelatihans'])) {
            $builder->where('mc.class_name', $params['pelatihans']);
        }
        if (!empty($params['master_class_id'])) {
            $builder->where('pl.master_class_id', $params['master_class_id']);
        }
        if (!empty($params['voucher'])) {
            $builder->where('pl.voucher', $params['voucher']);
        }
        if (!empty($params['invoice'])) {
            $builder->where('pl.invoice', $params['invoice']);
        }
        if (!empty($params['redeem_code'])) {
            $builder->where('pl.redeem_code', $params['redeem_code']);
        }
        if (!empty($params['payment_period'])) {
            $builder->like('pl.payment_period', trim($params['payment_period']));
        }




        $total = $builder->countAllResults(false);
        $datas = $builder->limit($perPage, $offset)->get()->getResult();
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total, 'default_full');
        $master_classes = $this->masterClass->findAll();

        $pelatihans = array_unique(array_map(function ($x) {
            return trim($x['class_name']);
        }, $master_classes));


        return view('peserta/index', compact('title', 'datas', 'pager', 'master_classes', 'pelatihans', 'params'));
    }


    public function new()
    {
        helper('form');
        $title = 'Create Peserta';
        $master_classes = $this->masterClass->findAll();
        return view('peserta/create', compact('title', 'master_classes'));
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['peserta_name', 'email', 'phone']);
        $pelatihan = $this->request->getPost(['invoice', 'voucher', 'master_class_id']);
        $data = array_merge($data, $this->user_create_update);
        try {
            $this->db->transStart();

            /**
             * check is email exists? 
             */
            $is_email_exists = $this->peserta->where('email', $data['email'])->first();
            if ($is_email_exists !== null) {
                return redirect()->back()->withInput()->with('errors', ['Email already exists']);
            }

            $validateInvoiceVoucher = $this->validateInvoiceVoucher($pelatihan['invoice'], $pelatihan['voucher']);
            if ($validateInvoiceVoucher['voucher'] !== null) {
                array_push($errors, 'Voucher already exists!');
            }

            if ($validateInvoiceVoucher['invoice'] !== null) {
                array_push($errors, 'Invoice already exists!');
            }

            if (count($errors)  !== 0) {
                return redirect()->back()->withInput()->with('errors', $errors);
            }


            $peserta = $this->peserta->insert($data, false);

            if (!$peserta) {
                return redirect()->back()->withInput()->with('errors', $this->peserta->errors());
            }

            if ($peserta) {
                $pelatihan['peserta_id'] = $this->peserta->getInsertID();
                $data_pelatihan = array_merge($pelatihan, $this->user_create_update);
                if (!$this->pelatihan->save($data_pelatihan)) {
                    // Handle pelatihan insertion failure
                    return redirect()->back()->withInput()->with('errors', $this->pelatihan->errors());
                }
                // Commit transaction
                $this->db->transComplete();
                $this->successInsert();
                return redirect()->to("peserta/new");
            }
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return redirect()->back()->with('errors', ['An unexpected error occurred.']);
        }
    }

    public function edit(int $id)
    {
        helper('form');
        $title = 'Edit Peserta';
        $data = $this->peserta->find($id);
        $master_classes = $this->masterClass->findAll();
        return view('peserta/edit', compact('title', 'data', 'master_classes'));
    }

    public function update(int $id)
    {
        helper('form');

        $data = $this->request->getPost(['peserta_name', 'email', 'phone']);
        $peserta = $this->peserta->find($id);

        // Is email changed?
        if ($peserta['email'] !== $data['email']) {
            $is_email_exist = $this->peserta->where('email', $data['email'])->first();
            if ($is_email_exist !== null) {
                return redirect()->back()->withInput()->with('errors', ['Email already exists']);
            }
        }
        $data = array_merge($data, $this->user_update);

        if ($this->peserta->update($id, $data)) {
            $this->successUpdate();
            return redirect()->to("peserta/$id/edit");
        }

        $errors = $this->peserta->errors();

        return redirect()->back()->withInput()->with('errors', $errors);
    }



    public function editMitra(int $peserta_id, $master_class_id)
    {
        helper('form');
        $title = 'Update Mitra Peserta';
        $peserta = $this->getPelatihan($peserta_id, $master_class_id);
        $mitras = $this->db->table('mitras')->get()->getResult();
        return view('peserta/mitra', compact('title', 'peserta', 'mitras'));
    }

    public function updateMitra(int $peserta_id, $master_class_id)
    {
        helper('form');

        $data = $this->request->getPost(['mitra_id']);

        $peserta = $this->getPelatihan($peserta_id, $master_class_id);
        if ($data['mitra_id'] === '') {
            return redirect()->back()->withInput()->with('errors', ['Mitra must be required!']);
        }
        if ($peserta->is_finished === null) {
            return redirect()->back()->withInput()->with('errors', ['Peletihan is not finished cant update mitra!']);
        }

        $this->db->table('pesertas')->where('id', $peserta_id)->update($data);
        $this->successUpdate();
        return redirect()->to("peserta/$peserta_id/update-mitra/$master_class_id");
    }


    public function viewImportPembelian()
    {
        helper('form');
        $title = 'Import Data Pembelian';
        $master_classes = $this->masterClass->findAll();
        $messages = $this->db->table('messages as m')
            ->join('master_classes as mc', 'mc.id = m.master_class_id', 'left')
            ->join('mitras as ma', 'ma.id = m.mitra_id', 'left')
            ->get()->getResult();
        return view('peserta/import-pembelian', compact('title',  'messages', 'master_classes'));
    }
    public function viewImportRedemption()
    {
        helper('form');
        $title = 'Import Data Redemption';
        $messages = $this->db->table('messages as m')
            ->join('master_classes as mc', 'mc.id = m.master_class_id', 'left')
            ->join('mitras as ma', 'ma.id = m.mitra_id', 'left')
            ->get()->getResult();
        return view('peserta/import-redemption', compact('title',  'messages'));
    }
    public function viewImportCompletion()
    {
        helper('form');
        $title = 'Import Data Completion';
        $messages = $this->db->table('messages as m')
            ->join('master_classes as mc', 'mc.id = m.master_class_id', 'left')
            ->join('mitras as ma', 'ma.id = m.mitra_id', 'left')
            ->get()->getResult();
        return view('peserta/import-redemption', compact('title',  'messages'));
    }
    public function viewImportReconcile()
    {
        helper('form');
        $title = 'Import Data Reconcile Mitra';
        $messages = $this->db->table('messages as m')
            ->join('master_classes as mc', 'mc.id = m.master_class_id', 'left')
            ->join('mitras as ma', 'ma.id = m.mitra_id', 'left')
            ->get()->getResult();
        $mitra = new Mitra();
        $mitras = $mitra->findAll();
        return view('peserta/import-reconcile', compact('title', 'mitras', 'messages'));
    }

    public function storeImportPembelian()
    {
        helper('form');
        $data_class = $this->request->getPost(['master_class_id']);
        $data = $this->request->getFile('formFile');

        // Define validation rules
        $rules = [
            'master_class_id' => 'required',
            'formFile' => [
                'rules' => 'uploaded[formFile]|ext_in[formFile,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Please upload a file.',
                    'ext_in' => 'The uploaded file must be in .xls or .xlsx format.',
                ],
            ],
        ];

        // Validate the data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $master_class_id = $data_class['master_class_id'];
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($data);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();
        unset($activeWorksheet[0]);

        $errors = [];
        $countSuccess = 0;
        $countErrors = 0;


        try {
            // $this->db->transStart();
            foreach ($activeWorksheet as $aw) {
                /**
                 * Skipp file if empty
                 */
                if ($aw['2'] === null) {
                    break;
                }

                $data_peserta = [
                    'peserta_name' => $aw['1'],
                    'email' => $aw['2'],
                    'phone' => $aw['3'],
                ];


                $data_pelatihan = [
                    'master_class_id' => (int) $master_class_id,
                    'voucher' => $aw['4'],
                    'invoice' => $aw['5']
                ];


                /**
                 * check is email exists? 
                 */
                $is_email_exists = $this->peserta->where('email', $data_peserta['email'])->first();

                if ($is_email_exists !== null) {
                    array_push($errors, 'Email already exists');
                }

                $validateInvoiceVoucher = $this->validateInvoiceVoucher($data_pelatihan['invoice'], $data_pelatihan['voucher']);
                if ($validateInvoiceVoucher['voucher'] !== null) {
                    array_push($errors, 'Voucher already exists');
                }

                if ($validateInvoiceVoucher['invoice'] !== null) {
                    array_push($errors, 'Invoice already exists');
                }


                /**
                 * If have errors skip to insert data
                 */
                if (count($errors)  !== 0) {

                    /**
                     * Insert error to table error_messages
                     */
                    $insert_error = array_merge($data_peserta, $data_pelatihan);
                    $insert_error['message'] = implode(', ', $errors);
                    if (! $this->db->table('messages')->insert($insert_error)) {
                        return "fails";
                    };
                    $countErrors++;
                    continue;
                }


                $insert_peserta = array_merge($data_peserta, $this->user_create_update);


                $peserta = $this->peserta->insert($insert_peserta, false);

                if (!$peserta) {
                    return redirect()->back()->withInput()->with('errors', $this->peserta->errors());
                }

                if ($peserta) {
                    $data_pelatihan['peserta_id'] = $this->peserta->getInsertID();
                    $pelatihan_data = array_merge($data_pelatihan, $this->user_create_update);

                    if (!$this->pelatihan->save($pelatihan_data)) {
                        // Handle pelatihan insertion failure
                        return redirect()->back()->withInput()->with('errors', $this->pelatihan->errors());
                    }
                    // Commit transaction
                    // $this->db->transComplete();
                }
                $countSuccess++;
            }


            $session = session();
            if ($countSuccess > 0) {
                $this->successInsert();
                $session->setFlashdata('countSuccess', "Total Success Insert Data $countSuccess");
            }

            if ($countErrors > 0) {
                $session->setFlashdata('countErrors', "Total Data Failed to Insert $countErrors");
            }
            return redirect()->to('/peserta/import-data/pembelian');
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return redirect()->back()->with('errors', ['An unexpected error occurred.']);
        }
    }


    public function storeImportRedemption()
    {
        helper('form');
        $data = $this->request->getFile('formFile');

        // Define validation rules
        $rules = [
            'formFile' => [
                'rules' => 'uploaded[formFile]|ext_in[formFile,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Please upload a file.',
                    'ext_in' => 'The uploaded file must be in .xls or .xlsx format.',
                ],
            ],
        ];

        // Validate the data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }


        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($data);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();
        unset($activeWorksheet[0]);

        $countSuccess = 0;
        $countErrors = 0;


        try {
            // $this->db->transStart();
            foreach ($activeWorksheet as $aw) {
                $errors = [];
                $voucher = $aw['1'];
                $redeem_code = $aw['2'];
                $data = [
                    'voucher' => $voucher,
                    'redeem_code' => $redeem_code,
                ];
                /**
                 * Skipp file if empty
                 */
                if ($voucher === null) {
                    break;
                }


                /**
                 * check is voucher exist? 
                 */
                $is_voucher_exists = $this->db->table('pelatihans')->where('voucher', $voucher)->get()->getResult();

                if ($is_voucher_exists === null || count($is_voucher_exists) === 0) {
                    array_push($errors, 'Voucher not found');
                } else  if ($is_voucher_exists[0]->redeem_code !== null) {
                    array_push($errors, 'This Peserta already have redeem code');
                }



                /**
                 * If have errors skip to insert data
                 */
                if (count($errors)  !== 0) {

                    /**
                     * Insert error to table error_messages
                     */
                    $insert_error = $data;
                    $insert_error['message'] = implode(', ', $errors);
                    if (! $this->db->table('messages')->insert($insert_error)) {
                        return "fails";
                    };
                    $countErrors++;
                    continue;
                }

                $progress = new Progress();
                $progress->update($is_voucher_exists[0]->id, $data);
                $countSuccess++;
            }


            $session = session();
            if ($countSuccess > 0) {
                $this->successInsert();
                $session->setFlashdata('countSuccess', "Total Success Updated Data $countSuccess");
            }

            if ($countErrors > 0) {
                $session->setFlashdata('countErrors', "Total Data Failed to Insert $countErrors");
            }
            return redirect()->to('/peserta/import-data/redemption');
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return redirect()->back()->with('errors', [$th->getMessage()]);
        }
    }


    public function storeImportCompletion()
    {
        helper('form');
        $data = $this->request->getFile('formFile');

        // Define validation rules
        $rules = [
            'formFile' => [
                'rules' => 'uploaded[formFile]|ext_in[formFile,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Please upload a file.',
                    'ext_in' => 'The uploaded file must be in .xls or .xlsx format.',
                ],
            ],
        ];

        // Validate the data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }


        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($data);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();
        unset($activeWorksheet[0]);

        $countSuccess = 0;
        $countErrors = 0;


        try {
            // $this->db->transStart();
            foreach ($activeWorksheet as $aw) {
                $errors = [];
                $voucher = $aw['1'];
                $redeem_code = $aw['2'];
                $data = [
                    'voucher' => $voucher,
                    'is_finished' => $redeem_code,
                ];
                /**
                 * Skipp file if empty
                 */
                if ($voucher === null || $voucher === '') {
                    break;
                }


                /**
                 * check is voucher exist? 
                 */
                $is_voucher_exists = $this->db->table('pelatihans')->where('voucher', $voucher)->get()->getResult();

                if ($is_voucher_exists === null || count($is_voucher_exists) === 0) {
                    array_push($errors, 'Voucher not found');
                } else if ($is_voucher_exists[0]->redeem_code === null) {
                    array_push($errors, 'This Peserta doesnt have redeem code');
                }


                /**
                 * If have errors skip to insert data
                 */
                if (count($errors)  !== 0) {

                    /**
                     * Insert error to table error_messages
                     */
                    $insert_error = $data;
                    $insert_error['message'] = implode(', ', $errors);
                    if (! $this->db->table('messages')->insert($insert_error)) {
                        return "fails";
                    };
                    $countErrors++;
                    continue;
                }

                // dd($is_voucher_exists);

                $progress = new Progress();
                $progress->update($is_voucher_exists[0]->id, $data);
                $countSuccess++;
            }


            $session = session();
            if ($countSuccess > 0) {
                $this->successInsert();
                $session->setFlashdata('countSuccess', "Total Success Updated Data $countSuccess");
            }

            if ($countErrors > 0) {
                $session->setFlashdata('countErrors', "Total Data Failed to Insert $countErrors");
            }
            return redirect()->to('/peserta/import-data/completion');
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return redirect()->back()->with('errors', [$th->getMessage()]);
        }
    }


    public function storeImportReconcile()
    {
        helper('form');
        $data_mitra = $this->request->getPost(['mitra_id']);
        $data = $this->request->getFile('formFile');

        // Define validation rules
        $rules = [
            'mitra_id' => 'required',
            'formFile' => [
                'rules' => 'uploaded[formFile]|ext_in[formFile,xls,xlsx]',
                'errors' => [
                    'uploaded' => 'Please upload a file.',
                    'ext_in' => 'The uploaded file must be in .xls or .xlsx format.',
                ],
            ],
        ];

        // Validate the data
        if (! $this->validate($rules)) {
            // If validation fails, redirect back with errors
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }


        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($data);
        $activeWorksheet = $spreadsheet->getActiveSheet()->toArray();
        unset($activeWorksheet[0]);

        $countSuccess = 0;
        $countErrors = 0;
        $mitra_id =  $data_mitra['mitra_id'];

        try {
            // $this->db->transStart();
            foreach ($activeWorksheet as $aw) {
                $errors = [];
                $peserta_name = $aw['1'];
                $email = $aw['2'];
                $invoice = $aw['3'];
                $periode = $aw['4'];

                $data = [
                    'peserta_name' => $peserta_name,
                    'email' => $email,
                    'invoice' => $invoice,
                    'payment_period' => $periode,
                    'mitra_id' => $mitra_id,
                    'is_paymented' => 1,

                ];
                /**
                 * Skipp file if empty
                 */
                if ($email === null || $email === '') {
                    break;
                }


                /**
                 * check is voucher exist? 
                 */
                $is_invoice_exists = $this->db->table('pelatihans')->where('invoice', $invoice)->get()->getResult();

                if ($is_invoice_exists === null || count($is_invoice_exists) === 0) {
                    array_push($errors, 'Invoice not found');
                } else if ($is_invoice_exists[0]->redeem_code === null) {
                    array_push($errors, 'This Peserta doesnt have redeem code');
                } else if ($is_invoice_exists[0]->is_finished === null) {
                    array_push($errors, 'This Peserta doesnt finished class');
                } else if ($is_invoice_exists[0]->is_paymented !== 0) {
                    array_push($errors, 'This Peserta already paymented');
                }


                /**
                 * If have errors skip to insert data
                 */
                if (count($errors)  !== 0) {

                    /**
                     * Insert error to table error_messages
                     */
                    $insert_error = $data;
                    $insert_error['message'] = implode(', ', $errors);
                    if (! $this->db->table('messages')->insert($insert_error)) {
                        return "fails";
                    };
                    $countErrors++;
                    continue;
                }

                // dd($is_invoice_exists);

                unset($data['mitra_id']);
                $payment = new Payment();
                // Update payment
                $payment->update($is_invoice_exists[0]->id, $data);
                // Update peserta
                $this->peserta->update($is_invoice_exists[0]->peserta_id, ['mitra_id' =>  $mitra_id]);
                $countSuccess++;
            }


            $session = session();
            if ($countSuccess > 0) {
                $this->successInsert();
                $session->setFlashdata('countSuccess', "Total Success Updated Data $countSuccess");
            }

            if ($countErrors > 0) {
                $session->setFlashdata('countErrors', "Total Data Failed to Insert $countErrors");
            }
            return redirect()->to('/peserta/import-data/reconcile');
        } catch (\Throwable $th) {
            log_message('error', $th->getMessage());
            return redirect()->back()->with('errors', [$th->getMessage()]);
        }
    }

    public function destroyMessage()
    {

        $this->db->table('messages')->truncate();

        return    $this->response->setStatusCode(200, 'success truncate');
    }
}
