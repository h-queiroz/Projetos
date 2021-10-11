<?php

class BancoDados{

  private $pdo;

  public function __construct(){
    $this->pdo = new PDO('mysql:host=localhost;dbname=Projetos;charset=utf8mb4','root','root');
  }

  public function getPdo(){
    return $this->pdo;
  }

}


 ?>
