<?php

namespace app\controllers;

use app\controllers\BaseController;
use app\Models\Agents;

class Main extends BaseController
{
    
    public function index()
    {
        
        // verifica se não há usuário logado
        if (!check_session()){
            
            $this->login_frm();
            return;
        }

        $this->view('layouts/html_header');
        echo '<h3 class="text-white text-center">Olá Mundo!<h3>';
        $this->view('layouts/html_footer');
    }

    // Login
    public function login_frm()
    {
    
        // verifica se não há usuário logado
        
        if (check_session()){
            $this->index();
            return;
        }
        
        // Verifica se há erros depois de submeter o login
        $data = [];
        if(!empty($_SESSION['validation_errors'])){
            $data['validation_errors'] = $_SESSION['validation_errors'];
            unset($_SESSION['validation_errors']);
        }
    
        // Views
        $this->view('layouts/html_header');
        $this->view('login_frm', $data);
        $this->view('layouts/html_footer');

    }

    public function login_submit()
    {
        
        // verifica se não há usuário logado
        if (check_session()){
            $this->index();
            return;
        }

        
        if($_SERVER['REQUEST_METHOD'] != 'POST'){
            $this->index();
            return;
        }

        
        $validation_errors = [];
       
        if(empty($_POST['text_username']) || empty($_POST['text_password'])){
            $validation_errors[] = 'Username e password são obrigatórios';
        }

        if(!empty($validation_errors)){
            
            $_SESSION['validation_errors'] = $validation_errors;
            $this->login_frm();
            return;
        }

        $username = $_POST['text_username'];
        $password = $_POST['text_password'];
    
        echo $username. '<br>' . $password;
    }

}