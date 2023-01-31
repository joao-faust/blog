<?php

namespace App\Controllers;

use \Dotenv\Dotenv;
use \App\Models\DAO\PostDAO;
use \App\Models\Post;
use \App\Models\User;
use \App\Classes\Error;

Dotenv::createImmutable(__DIR__ . '/../../')->load();

class PostController{
  private $DAO;

  public function __construct(){
    $this->DAO = new PostDAO();
  }

  /**
   * @param string $title
   * @return boolean Returns true if the title is valid or false otherwise
   */
  private static function validateTitle($title){
    return strlen($title) >= 5 and strlen($title) <= 255;
  }

    /**
   * @param string $text
   * @return boolean Returns true if the text is valid or false otherwise
   */
  private static function validateText($text){
    return strlen($text) >= 20;
  }

  /**
   * @param string $title
   * @param string $text
   * @return string Returns the result
   */
  public function addPost($title, $text){
    if(!self::validateTitle($title)) return Error::INVALID_DATA;
    if(!self::validateText($text)) return Error::INVALID_DATA;

    $user = new User();
    $user->setId($_SESSION['USER_ID']);
    $post = new Post($title, $text, date('Y-m-d'), $user);
    $id = $this->DAO->addPost($post);
    $post->setId($id);
    return 'OK';
  }

  /**
   * @return array Returns an array with posts
   */
  public function posts(){
    return $this->DAO->posts();
  }

  /**
   * @param string $id
   * @return Post Returns a post
   */
  public function postById($id){
    return $this->DAO->postById($id);
  }

  /**
   * @return Post Returns an array with posts
   */
  public function userPosts(){
    return $this->DAO->userPosts();
  }

  /**
   * @param string $id
   */
  public function deletePost($id){
    $this->DAO->deletePost($id);
  }
}
