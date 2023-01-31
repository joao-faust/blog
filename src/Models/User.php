<?php

namespace App\Models;

class User{
  /** @var null|int */
  private $id;
  /** @var null|string */
  private $name;
  /** @var null|string */
  private $email;
  /** @var null|string */
  private $password;

  public function __construct($name=NULL, $email=NULL, $password=NULL, $id=NULL){
    $this->id = $id;
    $this->name = $name;
    $this->email = $email;
    $this->password = $password;
  }

  /** @return int $id */
  public function getId(){
    return $this->id;
  }

  /** @param int $id */
  public function setId($id){
    $this->id = $id;
  }

  /** @return string $name */
  public function getName(){
    return $this->name;
  }

  /** @param string $name */
  public function setName($name){
    $this->name = $name;
  }

  /** @return string $email */
  public function getEmail(){
    return $this->email;
  }

  /** @param string $email */
  public function setEmail($email){
    $this->email = $email;
  }

  /** @return string $password */
  public function getPassword(){
    return $this->password;
  }

  /** @param string $password */
  public function setPassword($password){
    $this->password = $password;
  }
}
