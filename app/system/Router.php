<?php

namespace app\System;

use app\Controllers\Main;
use app\controllers\Paginas;
use Exception;

// class Router
// {
//     public static function dispatch()
//     {
//         // main route values
//         $httpverb = $_SERVER['REQUEST_METHOD'];
//         $controller = 'main';
//         $method = 'index';

//         // check uri parameters
//         if(isset($_GET['ct'])){
//             $controller = $_GET['ct'];
//         }

//         if(isset($_GET['mt'])){
//             $method = $_GET['mt'];
//         }

//         // method parameters
//         $parameters = $_GET;

//         // remove controller from parameters
//         if(key_exists("ct", $parameters)) {
//             unset($parameters["ct"]);
//         }

//         // remove method from parameters
//         if(key_exists("mt", $parameters)) {
//             unset($parameters["mt"]);
//         }

//         // tries to instanciate the controller and execute the method
//         try {
//             $class = "app\controllers\\$controller";
//             $controller = new $class();
//             $controller->$method(...$parameters);
//         } catch (Exception $err) {
//             die($err->getMessage());
//         }
//     }
// }

class Router
{
    private $controlador = 'Main';
    private $metodo = 'index';
    private $parametros = [];
    
    public function __construct()
    {
        $url = $this->url() ?? [0];

        // Verifica se o controlador existe
        if(file_exists(dirname(__DIR__).'/controllers/'. ucwords($url[0]).'.php')):
            $this->controlador = ucwords($url[0]);
            
            unset($url[0]);
        endif;
        
        // Inclui o arquivo e instancia a classe
        // var_dump(dirname(__DIR__).'/controllers/'. $this->controlador.'.php');
        // exit;
        require_once dirname(__DIR__).'/controllers/'. $this->controlador.'.php';
        $classeComNameSpace = 'app\controllers\\'.$this->controlador;
        $this->controlador =  new $classeComNameSpace;
  
            
        // Verifica se o método existe
        if(isset($url[1])):
            if(method_exists($this->controlador, $url[1])):
                $this->metodo = $url[1];
                unset($url[1]);
            endif;
        endif;

        // Verifica se existe parametros
        $this->parametros = $url ?? [];

        call_user_func_array([$this->controlador, $this->metodo], $this->parametros);
    }

    public function url()
    {
        $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
        if(isset($url)):
            $url = trim(rtrim($url, '/'));
            $url = explode('/', $url);
            return $url;
            
        endif;
    }
}