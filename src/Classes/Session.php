<?php

namespace App\Classes;

use \Dotenv\Dotenv;

Dotenv::createImmutable(__DIR__ . '/../../')->load();

class Session{

  public static function start(){
    ini_set('session.cookie_httponly', 1);
    session_name(md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
    session_start();
  }

  public static function destroy(){
    session_destroy();
  }

  public static function validate(){
    $secret = $_ENV['SECRET'];
    $token = md5($secret.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
    if($_SESSION['OWNER_SESSION'] != $token){
      header('Location: /login');
      exit;
    }
  }
}
