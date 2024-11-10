<?php

namespace App\Controllers;

use Myth\Auth\Models\UserModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{

    protected    $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $title = 'Users';
        helper('form');

        $perPage = 20;
        $params = $this->request->getGet(['username']);

        $page = $this->request->getVar('page') ?? 1;
        $offset = ($page - 1) * $perPage;
        $builder = $this->db->table('users');
        $total = $builder->countAllResults(false);
        $datas = $builder->limit($perPage, $offset)->get()->getResult();


        $uri = (string) current_url(true);
        if ($params['username'] === null) {
            $uri = (string) current_url(true) . "?";
        }
        $currentPage =  (int) $page;
        $tempPage = $page;
        $nextPage = ++$page;
        $prevPage = --$tempPage;
        $lastPage = (int) round($total / $perPage);
        $pagination = (object)[
            'total' => $total,
            'currentPage' =>  $currentPage,
            'nextUrl' => $uri . "&page=" . $nextPage,
            'previousUrl' => $uri . "&page=" . $prevPage,
            'lastPage' => $lastPage,
            'from' =>  $currentPage >= $lastPage ? $total : ($page - 1) * $perPage
        ];
        return view('users/index', compact('title',  'datas', 'pagination',  'params'));
    }

    public function new()
    {

        $title = 'Create New User';
        helper('form');
        return view('users/create', compact('title',));
    }

    public function create()
    {
        helper('form');

        $users = model(UserModel::class);

        // Validate basics first since some password rules rely on these fields
        $rules = config('Validation')->registrationRules ?? [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password'    => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $requestDatas =    $this->request->getPost(['username', 'email', 'password']);
        $requestDatas['password_hash'] = password_hash($requestDatas['password'], PASSWORD_DEFAULT);
        unset($requestDatas['password']);

        if (!$users->save($requestDatas)) {
            return redirect()->back()->withInput()->with('errors', $users->getErrors());
        }

        $this->successInsert();
        return redirect()->back();
    }

    public function edit(int $id)
    {

        $title = 'Edit User';
        helper('form');
        $user = $this->db->table('users')->where('id', $id)->get()->getResult()[0];
        return view('users/edit', compact('title', 'user'));
    }


    public function update(int $id)
    {
        helper('form');

        $users = model(UserModel::class);
        $user = $users->find($id);

        $requestDatas =    $this->request->getPost(['password']);

        if (!empty($requestDatas['password'])) {
            $user->setPassword($requestDatas['password']);
            $users->save($user);
        }



        $this->successUpdate();
        return redirect()->back();
    }

    public function viewPermissions(int $id)
    {

        $title = 'Permissions User';
        helper('form');
        $user = $this->db->table('users')->where('id', $id)->get()->getResult()[0];
        $data_permissions = $this->db->table('permissions')->get()->getResult();
        $user_permissions = $this->db->table('user_permissions')->get()->getResult();
        $permissions = [];

        foreach ($data_permissions as $value) {
            $permissions[$value->groups][] = [
                'name' => $value->name,
                'id' => $value->id
            ];
        }

        return view('users/permissions', compact('title', 'user', 'permissions', 'user_permissions'));
    }

    public function updatePermissions(int $id)
    {
        helper('form');

        $requestDatas =    $this->request->getPost(['permissions']);

        if ($requestDatas['permissions'] ===  null) {
            return redirect()->back()->withInput()->with('errors', ['Permissions required at least 1 access']);
        }
        $datas = [];
        $this->db->table('user_permissions')->delete("user_id = $id");
        foreach ($requestDatas['permissions'] as $key => $value) {
            $datas[] = ['user_id' => $id, 'permission_id' => $value];
        }
        $this->db->table('user_permissions')->insertBatch($datas);
        $this->successUpdate();
        return redirect()->back();
    }
}
