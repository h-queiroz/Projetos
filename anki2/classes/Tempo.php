<?php
require_once('BancoDados.php');

class Tempo{

  private $pdo;

  public function __construct(){
    $this->pdo = new BancoDados();
    $this->pdo = $this->pdo->getPdo();
  }

  public function insert($erros,$tempo,$niveis){
    $query = $this->pdo->prepare('INSERT INTO historico (erros,tempo,niveis) VALUES (:erros,:tempo,:niveis)');
    $query->bindValue(':erros',$erros);
    $query->bindValue(':tempo',$tempo);
    $query->bindValue(':niveis',implode(',',$niveis));
    $query->execute();
  }

  public function list(){
    $query = $this->pdo->query('SELECT data,erros,tempo,niveis FROM historico');
    $lista = $query->fetchAll(PDO::FETCH_ASSOC);
    return $lista;
  }
}
