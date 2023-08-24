<?php

session_start();

use app\System\Router;

require_once 'vendor/autoload.php';
require_once 'app/config.php';
require_once 'app/helpers/Functions.php';


// Router::dispatch();
$router = new Router();


