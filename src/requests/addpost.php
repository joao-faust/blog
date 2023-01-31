<?php

require __DIR__ . '/../../vendor/autoload.php';

use \App\Classes\Session;
use \App\Classes\Error;
use \App\Controllers\PostController;

Session::start();
Session::validate();

/**
 * @param string $msg
 * @param string $status
 */
function response($msg, $status = 400){
  http_response_code($status);
  echo json_encode(['data' => $msg, 'status' => $status]);
  exit;
}

$data = file_get_contents('php://input');
if(!$data) response(Error::INVALID_DATA);

$parseData = json_decode($data, TRUE);
if(!is_array($parseData)) response(Error::INVALID_DATA);

$validatedData = filter_var_array($parseData, FILTER_SANITIZE_SPECIAL_CHARS);
if(!isset($validatedData['title']) or !isset($validatedData['text'])){
  response(Error::INVALID_DATA);
}

['title' => $title, 'text' => $text] = $validatedData;
$controller = new PostController();
$res = $controller->addPost($title, $text);

if($res != 'OK') response($res);
response('OK', 201);
