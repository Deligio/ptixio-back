<?php namespace App\Controllers;

// use App\Models\TestsModel;

class Exercise extends BaseController
{
    protected $db;
    // use ResponseTrait;

    // function __construct () 
    // {
    //     $this->db = db_connect();
    // }

    public function index(){
        // $model = new TestsModel();
        // $data = $model->where('t_status','Active')->first();
        // return $data; 
        echo 'tests';
    }

    public function getTests()
    {
        $model = new TestsModel();
        $data = $model->where('t_status','Active')->first();
        return $data; 
    }

    public function asda()
    {

    }
}