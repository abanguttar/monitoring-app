<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DigitalPlatform;
use CodeIgniter\HTTP\ResponseInterface;

class DigitalPlatformController extends BaseController
{

    protected $dp;
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->dp = new DigitalPlatform();
        $this->db = \Config\Database::connect();
    }


    public function index()
    {
        $title = 'Digital Platform';
        $dps = $this->db->table('digital_platforms as dp')
            ->join('users as u', 'u.id = dp.user_update', 'left')
            ->select('dp.*, u.username')->get()->getResult();;
        return view('digital-platform/index', compact('title', 'dps'));
    }


    public function new()
    {
        helper('form');
        $title = 'Create Digital Platform';
        return view('digital-platform/create', compact('title'));
    }


    public function create()
    {
        helper('form');

        $data = $this->request->getPost(['dp_name']);

        $data = array_merge($data, $this->user_create_update);
        // Attempt to save; will validate based on rules in the model
        if ($this->dp->save($data)) {
            // Success action
            $this->successInsert();
            return redirect()->to('/digital-platform/new');
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->dp->errors();

        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    public function edit(int $id)
    {
        helper('form');
        $title = 'Edit Digital Platform';
        $data = $this->dp->find($id);
        return view('digital-platform/edit', compact('title', 'data'));
    }

    public function update(int $id)
    {
        helper('form');

        $data = $this->request->getPost(['dp_name']);

        $data = array_merge($data, $this->user_update);
        // Attempt to save; will validate based on rules in the model
        if ($this->dp->update($id, $data)) {
            // Success action
            $this->successUpdate();
            return redirect()->to("/digital-platform/$id/edit");
        }

        // If validation fails, retrieve errors from the model
        $errors = $this->dp->errors();

        // Redirect back with input and errors
        return redirect()->back()->withInput()->with('errors', $errors);
    }
}
