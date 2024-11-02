<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Mitra;
use CodeIgniter\Commands\Help;
use CodeIgniter\HTTP\ResponseInterface;

class MitraController extends BaseController
{
    protected $validationRules = 'mitras';
    protected $mitra;
    // protected $user_create_update;

    public function __construct()
    {
        $this->mitra = new Mitra();
        parent::__construct();
    }



    public function index()
    {
        $title = 'Mitra';
        $mitras = $this->mitra->findAll();
        return view('mitra/index', compact('title', 'mitras'));
    }


    public function new()
    {
        helper('form');
        $title = 'Create Mitra';
        return view('mitra/create', compact('title'));
    }


    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['mitra_name', 'responsible', 'address']);

        $data = array_merge($data, $this->user_create_update);

        // Attempt to save; will validate based on rules in the model
        if ($this->mitra->save($data)) {
            // Success action
            $this->successInsert();
            return redirect()->to('/mitra/new');
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->mitra->errors();

        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    public function edit(int $id)
    {
        helper('form');
        $title = 'Edit Mitra';
        $data = $this->mitra->find($id);
        return view('mitra/edit', compact('title', 'data'));
    }



    public function update($id)
    {
        helper('form');

        $data = $this->request->getPost(['mitra_name', 'responsible', 'address']);
        $datas = array_merge($data, $this->user_update);

        if ($this->mitra->update($id, $datas)) {
            $this->successUpdate();
            return redirect()->to("/mitra/$id/edit");
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->mitra->errors();
        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }
}
