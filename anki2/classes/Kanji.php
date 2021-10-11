<?php
require('BancoDados.php');

class Kanji{

  private $pdo;
  public $ultimo = false;

  public function __construct(){
    $this->pdo = new BancoDados();
    $this->pdo = $this->pdo->getPdo();
  }

  public function create($s,$r,$t,$e,$k){
    $query = $this->pdo->prepare('INSERT INTO kanji(simbolo, romaji, ntracos, english, kana) VALUES (:s,:r,:t,:e,:k)');
    $query->bindValue(':s',$s);
    $query->bindValue(':r',$r);
    $query->bindValue(':t',$t);
    $query->bindValue(':e',$e);
    $query->bindValue(':k',$k);
    $query->execute();
    $this->ultimo = true;
  }

  public function list(){
    $query = $this->pdo->query('SELECT simbolo,ntracos,english,kana,romaji FROM kanji LIMIT 2');
    $lista = $query->fetchAll(PDO::FETCH_ASSOC);
    return $lista;
  }
}

 ?>
