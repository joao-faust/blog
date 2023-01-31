<?php

namespace App\Models\DAO;

use \PDO;
use App\Classes\DBConnection;
use App\Models\User;

class UserDAO{
  private $conn;

  public function __construct(){
    $this->conn = new DBConnection();
  }

  public function __destruct(){
    $this->conn = NULL;
  }

  /**
   * @param User $user
   * @return string Returns the user id
   */
  public function addUser($user){
    $query = 'INSERT INTO user(name, email, password) VALUES(?, ?, ?)';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $user->getName());
    $sth->bindValue(2, $user->getEmail());
    $sth->bindValue(3, $user->getPassword());

    $sth->execute();
    return $this->conn->lastInsertId();
  }

  /**
   * @param string $email
   * @return User Returns an user object
   */
  public function searchUserForEmail($email){
    $query = 'SELECT email, name FROM user WHERE email = ?';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $email);

    $sth->execute();
    $user = new User();
    while($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
      $user->setEmail($row[0]);
      $user->setName($row[1]);
    }
    return $user;
  }

  /**
   * @param string $email
   * @return User Returns an user object
   */
  public function login($email){
    $query = 'SELECT id, password, name FROM user WHERE email = ?';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $email);

    $sth->execute();
    $user = new User();
    while($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
      $user->setId($row[0]);
      $user->setPassword($row[1]);
      $user->setName($row[2]);
    }
    return $user;
  }
}
