<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;


class Options implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // var_dump($_POST);
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: *");//X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, cache-control
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
        die();
        }
        
        return true;
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
