<?php

namespace App\Controllers;

use App\Models\MasterClass;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MasterClassController extends BaseController
{
    protected $masterClass;
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->masterClass = new MasterClass();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $title = 'Master Class';
        $perPage = 50;
        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $perPage;
        $builder = $this->db->table('master_classes as mc')
            ->join('users as u', 'u.id = mc.user_update', 'left')
            ->select('mc.*, u.username');
        $total = $builder->countAllResults(false);
        $masterClasses = $builder->limit($perPage, $offset)->get()->getResult();
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total, 'default_full');

        return view('master-class/index', compact('title', 'masterClasses', 'pager'));
    }


    public function new()
    {
        helper('form');
        $title = 'Create Master Class';
        return view('master-class/create', compact('title'));
    }

    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['class_name', 'jadwal', 'jam', 'is_prakerja', 'tipe',  'price']);

        $data = array_merge($data, $this->user_create_update);

        // Attempt to save; will validate based on rules in the model
        if ($this->masterClass->save($data)) {
            // Success action
            $this->successInsert();
            return redirect()->to('/master-class/new');
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->masterClass->errors();

        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    public function edit(int $id)
    {
        helper('form');
        $title = 'Edit Master Class';
        $data = $this->masterClass->find($id);
        return view('master-class/edit', compact('title', 'data'));
    }


    public function update(int $id)
    {
        helper('form');

        $data = $this->request->getPost(['class_name', 'jadwal', 'jam', 'is_prakerja', 'tipe',  'price']);

        $data = array_merge($data, $this->user_update);

        // Attempt to save; will validate based on rules in the model
        if ($this->masterClass->update($id, $data)) {
            // Success action
            $this->successUpdate();
            return redirect()->to("/master-class/$id/edit");
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->masterClass->errors();

        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }
}
