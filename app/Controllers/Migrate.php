<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Throwable;

class Migrate extends Controller
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            echo 'Success';
        } catch (Throwable $e) {
            // Do something with the error here...
            echo '<pre>';
             print_r($e);
            echo '</pre>';
        }
    }
}