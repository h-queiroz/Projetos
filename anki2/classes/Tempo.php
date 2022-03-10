<?php
require_once('BancoDados.php');

class Tempo{

  private $pdo;

  public function __construct(){
    $this->pdo = new BancoDados();
    $this->pdo = $this->pdo->getPdo();
  }

  public function insert($erros,$tempo){
    $query = $this->pdo->prepare('INSERT INTO historico (erros,tempo) VALUES (:erros,:tempo)');
    $query->bindValue(':erros',$erros);
    $query->bindValue(':tempo',$tempo);
    $query->execute();
  }

  public function list(){
    $query = $this->pdo->query('SELECT data,erros,tempo FROM historico');
    $lista = $query->fetchAll(PDO::FETCH_ASSOC);
    return $lista;
  }
}
