<?php

namespace App\Controllers;

use App\Models\Pelatihan;
use CodeIgniter\Controller;
use Psr\Log\LoggerInterface;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];
    protected $user_create_update;
    protected $user_update;
    protected $pelatihan;
    protected $auth;

    public function __construct()
    {

        $this->auth = service('authentication');
        $this->user_create_update = [
            'user_create' => $this->auth->user()->id,
            'user_update' => $this->auth->user()->id
        ];
        $this->user_update = [
            'user_update' => $this->auth->user()->id
        ];
        $this->pelatihan = new Pelatihan();
    }


    public function successInsert()
    {
        $session = session();
        $session->setFlashdata('success', 'Created data successfully!');
    }
    public function successUpdate()
    {
        $session = session();
        $session->setFlashdata('success', 'Updated data successfully!');
    }


    public function validateInvoiceVoucher($invoice, $voucher)
    {
        return [
            'invoice' => $this->pelatihan->where('invoice', $invoice)->first(),
            'voucher' => $this->pelatihan->where('voucher', $voucher)->first()
        ];
    }


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        helper('auth');
    }
}
