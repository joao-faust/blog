<?php

require __DIR__ . '/../../vendor/autoload.php';

use \App\Classes\Session;
use \App\Controllers\PostController;

Session::start();
Session::validate();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);

$controller = new PostController();
$controller->deletePost($id);
header('Location: /posts');
