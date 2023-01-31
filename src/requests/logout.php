<?php

require __DIR__ . '/../../vendor/autoload.php';

use \App\Classes\Session;

Session::start();
Session::validate();
Session::destroy();

header('Location: /login');
