<?php

namespace App\Controllers;

use \Dotenv\Dotenv;
use \App\Models\DAO\UserDAO;
use \App\Models\User;
use \App\Classes\Error;
use \App\Classes\Session;

Session::start();
Dotenv::createImmutable(__DIR__ . '/../../')->load();

class UserController{
  private $DAO;

  public function __construct(){
    $this->DAO = new UserDAO();
  }

  /**
   * @param string $name
   * @return boolean Returns true if the name is valid or false otherwise
   */
  private static function validateName($name){
    return strlen($name) >= 4 and strlen($name) <= 255;
  }

  /**
   * @param string $email
   * @return boolean Returns true if the email is valid or false otherwise
   */
  private static function validateEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  /**
   * @param string $password
   * @return boolean Returns true if the password is valid or false otherwise
   */
  private static function validatePassword($password){
    return strlen($password) >= 8 and strlen($password) <= 72;
  }

  /**
   * @param string $email
   * @return boolean Returns true if the email exists or false otherwise
   */
  private function searchUserForEmail($email){
    return $this->DAO->searchUserForEmail($email)->getEmail() == NULL;
  }

  /**
   * @param string $captcha
   * @return boolean Returns true if the captcha code is valid or false otherwise
   */
  private function validateCaptcha($captcha){
    return $captcha == $_SESSION['CAPTCHA_CODE'];
  }

  /**
   * @param string $email
   * @param string $password
   * @param string $captcha
   * @return string Returns the result
   */
  public function addUser($name, $email, $password, $captcha){
    if(!self::validateName($name)) return Error::INVALID_DATA;
    if(!self::validateEmail($email)) return Error::INVALID_DATA;
    if(!self::validatePassword($password)) return Error::INVALID_DATA;
    if(!self::searchUserForEmail($email)) return Error::EMAIL_EXISTS;
    if(!self::validateCaptcha($captcha)) return Error::INVALID_CAPTCHA;

    $hash = password_hash($password, PASSWORD_BCRYPT);
    $user = new User($name, $email, $hash);
    $id = $this->DAO->addUser($user);
    $user->setId($id);
    return 'OK';
  }

  /**
   * @param string $email
   * @param string $password
   * @param string $captcha
   * @return string Returns the result
   */
  public function login($email, $password, $captcha){
    if(!self::validateCaptcha($captcha)) return Error::INVALID_CAPTCHA;
    if(!self::validateEmail($email)) return Error::INVALID_CREDENTIALS;
    if(!self::validatePassword($password)) return Error::INVALID_CREDENTIALS;

    $user = $this->DAO->login($email);
    if($user->getId() == NULL or !password_verify($password, $user->getPassword())){
      return Error::INVALID_CREDENTIALS;
    }

    $secret = $_ENV['SECRET'];
    $token = md5($secret.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
    $_SESSION['OWNER_SESSION'] = $token;
    $_SESSION['USER_ID'] = $user->getId();
    $_SESSION['USER_NAME'] = $user->getName();
    return 'OK';
  }
}
