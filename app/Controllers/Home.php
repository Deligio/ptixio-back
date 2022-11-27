<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class Home extends BaseController
{
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

    public function register()
    {
        if($this->request->getMethod() != 'post'){
            $resp = ['msg' => 'Only post request is allowed'];
			return $this->fail($resp,'Only post request is allowed');
        }
        echo '<pre>';
         print_r($_POST);
        echo '</pre>';
        $model = new UserModel();
        // $user = $model->insert($data)

    }
}
