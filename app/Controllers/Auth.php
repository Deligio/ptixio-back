<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel;
use App\Models\StudentsModel;

class Auth extends BaseController
{
    use ResponseTrait;

    function __construct () 
    {
        $this->db = db_connect();
        // $db = \Config\Database::connect();
    }
    
    public function index()
    {
        echo 'home';
        // return view('welcome_message');
    }

    public function register(){

        if($this->request->getMethod() != 'post'){
            return $this->fail('Only post request is allowed');
        }

        $rules = [
            'name' => 'required',
            'surname' => 'required',
            'password' => 'required|min_length[8]',
            'passconf' => 'required|matches[password]',
            'email'    => 'required|valid_email',
        ];

        if(! $this->validate($rules)){
            return $this->respond($this->validator->getErrors());
        }

        $data = [
            'u_name' => $this->request->getVar('name'),
            'u_surname' => $this->request->getVar('surname'),
            'u_email' => $this->request->getVar('email'),
            'u_password' => $this->request->getVar('password'),
            'u_type' => $this->request->getVar('type'),
        ];
        $model = new UsersModel();
        $user = $model->insert($data);
        $resp = [
            'user_id' => $user,
            'msg' => 'Success Registration',
        ];
        if(boolval($user)){
            return $this->respond($resp,200);
        }else{
            return $this->fail('Something went wrong with registration.');
        }
    }

    public function login(){
        if($this->request->getMethod() != 'post'){
            return $this->fail('Only post request is allowed');
        }
        // echo 'login';exit;
        $email = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $model = new UsersModel();
        $where = [
            'u_email' => $email,
        ];
        $user = $model
                ->select(" 
                    u_id as id,
                    u_name as name,
                    u_surname as surname,
                    u_email as email,
                    u_type as type
                ")
                    ->where($where)->find();
        if(boolval($user[0])){
            $resp = [
                'user' => $user[0],
                'msg' => 'Success Registration',
            ];
            return $this->respond($resp,200);
        }else{
            return $this->fail('Cannot find user.');
        }
        
    }

    public function users()
    {
        $model = new UsersModel();
        $users = $model->findAll();
        echo '<pre>';
         print_r($users);
        echo '</pre>';
    }
}
