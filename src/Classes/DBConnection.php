<?php

namespace App\Classes;

use \PDO;
use \Dotenv\Dotenv;
use \PDOException;

Dotenv::createImmutable(__DIR__ . '/../../')->load();

class DBConnection extends PDO{
  private $host;
  private $name;
  private $user;
  private $password;

  public function __construct(){
    $this->host = $_ENV['DB_HOST'];
    $this->name = $_ENV['DB_NAME'];
    $this->user = $_ENV['DB_USER'];
    $this->password = $_ENV['DB_PASSWORD'];
    $this->connect();
  }

  public function connect(){
    $dns = 'mysql:host='.$this->host.';dbname='.$this->name;
    try{
      parent::__construct($dns, $this->user, $this->password);
    }
    catch(PDOException $e) {
      die('Error to connect the database');
    }
  }
}
