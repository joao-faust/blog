<?php

namespace App\Models;

class Post{
  /** @var null|int */
  private $id;
  /** @var null|string */
  private $title;
  /** @var null|string */
  private $text;
  /** @var null|string */
  private $date;
  /** @var null|int */
  private $user;

  public function __construct($title=NULL, $text=NULL, $date=NULL, $user=NULL, $id=NULL){
    $this->title = $title;
    $this->text = $text;
    $this->date = $date;
    $this->user = $user;
    $this->id = $id;
  }

  /** @return int $id */
  public function getId(){
    return $this->id;
  }

  /** @param int $id */
  public function setId($id){
    $this->id = $id;
  }

  /** @return string $title */
  public function getTitle(){
    return $this->title;
  }

  /** @param string $title */
  public function setTitle($title){
    $this->title = $title;
  }

  /** @return string $text */
  public function getText(){
    return $this->text;
  }

  /** @param string $text */
  public function setText($text){
    $this->text = $text;
  }

  /** @param string $date */
  public function getDate(){
    return $this->date;
  }

  /** @return string $date */
  public function setDate($date){
    $this->date = $date;
  }

  /** @return User $user */
  public function getUser(){
    return $this->user;
  }

  /** @param User $user */
  public function setUser($user){
    $this->user = $user;
  }
}
