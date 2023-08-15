<?php

namespace app\controllers;

abstract class BaseController
{
    public function view($view, $data = [])
    {
        // check if data is array
        if(!is_array($data)){
            die("Data is not an array: " . var_dump($data));
        }

        // transforms data into variables
        extract($data);

        // includes the file if exists
        $arquivo = dirname(__DIR__)."/views/$view.php";
        if(file_exists($arquivo)){
            require_once $arquivo;
        } else {
            die("View não encontrada: " . $view);
        }
    }
}