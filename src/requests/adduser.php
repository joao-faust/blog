<?php

require __DIR__ . '/../../vendor/autoload.php';

use \App\Controllers\UserController;
use \App\Classes\Error;


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
if(!isset($validatedData['email']) or !isset($validatedData['password'])
or !isset($validatedData['name']) or !isset($validatedData['captcha'])){
  response(Error::INVALID_DATA);
}

[
  'email' => $email,
  'password' => $password,
  'name' => $name,
  'captcha' => $captcha
] = $validatedData;
$controller = new UserController();
$res = $controller->addUser($name, $email, $password, $captcha);

if($res != 'OK') response($res);
response('OK', 201);
