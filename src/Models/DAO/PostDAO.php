<?php

namespace App\Models\DAO;

use \PDO;
use \App\Classes\DBConnection;
use \App\Models\Post;
use \App\Models\User;

class PostDAO{
  private $conn;

  public function __construct(){
    $this->conn = new DBConnection();
  }

  public function __destruct(){
    $this->conn = NULL;
  }

  /**
   * @param Post $post
   * @return string Returns the post id
   */
  public function addPost($post){
    $query = 'INSERT INTO post(title, text, date, user_id) VALUES(?, ?, ?, ?)';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $post->getTitle());
    $sth->bindValue(2, $post->getText());
    $sth->bindValue(3, $post->getDate());
    $sth->bindValue(4, $post->getUser()->getId());

    $sth->execute();
    return $this->conn->lastInsertId();
  }

  /**
   * @return array Returns an array with posts
   */
  public function posts(){
    $query = 'SELECT p.text, p.title, p.date, p.id, u.name, u.id ';
    $query .= 'FROM post p INNER JOIN user u ';
    $query .= 'ON p.user_id = u.id';

    $sth = $this->conn->prepare($query);
    $sth->execute();

    $posts = [];
    while($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
      $post = new Post();
      $user = new User();
      $post->setText($row[0]);
      $post->setTitle($row[1]);
      $post->setDate($row[2]);
      $post->setId($row[3]);
      $user->setName($row[4]);
      $user->setId($row[5]);
      $post->setUser($user);
      $posts[] = $post;
    }
    return $posts;
  }

  /**
   * @param string $id
   * @return Post Returns a post
   */
  public function postById($id){
    $query = 'SELECT p.text, p.title, p.date, u.name ';
    $query .= 'FROM post p INNER JOIN user u ';
    $query .= 'ON p.user_id = u.id WHERE p.id = ?';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $id);
    $sth->execute();

    $post = new Post();
    $user = new User();
    while($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
      $post->setText($row[0]);
      $post->setTitle($row[1]);
      $post->setDate($row[2]);
      $user->setName($row[3]);
      $post->setUser($user);
    }
    return $post;
  }

  /**
   * @return array Returns an array with posts
   */
  public function userPosts(){
    $query = 'SELECT text, title, date, id ';
    $query .= 'FROM post WHERE user_id = ?';

    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $_SESSION['USER_ID']);
    $sth->execute();

    $posts = [];
    while($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)){
      $post = new Post();
      $user = new User();
      $post->setText($row[0]);
      $post->setTitle($row[1]);
      $post->setDate($row[2]);
      $post->setId($row[3]);
      $user->setId($_SESSION['USER_ID']);
      $user->setName($_SESSION['USER_NAME']);
      $post->setUser($user);
      $posts[] = $post;
    }
    return $posts;
  }

  /**
   * @param string $id
   */
  public function deletePost($id){
    $query = 'SELECT user_id FROM post WHERE id = ?';
    $sth = $this->conn->prepare($query);
    $sth->bindValue(1, $id);
    $sth->execute();
    $result = $sth->fetch();
    if($result and $result['user_id'] == $_SESSION['USER_ID']){
      $query = 'DELETE FROM post WHERE id = ?';
      $sth = $this->conn->prepare($query);
      $sth->bindValue(1, $id);
      $sth->execute();
    }
  }
}
