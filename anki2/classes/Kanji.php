<?php
require_once('BancoDados.php');

class Kanji{

  private $pdo;
  public $ultimo = false;

  public function __construct(){
    $this->pdo = new BancoDados();
    $this->pdo = $this->pdo->getPdo();
  }

  public function create($s,$r,$n,$e,$k,$j,$t){
    $query = $this->pdo->prepare('INSERT INTO kanji(simbolo, romaji, ntracos, english, kana, JLPT,tags) VALUES (:s,:r,:n,:e,:k,:j,:t)');
    $query->bindValue(':s',addslashes($s));
    $query->bindValue(':r',addslashes($r));
    $query->bindValue(':n',addslashes($n));
    $query->bindValue(':e',addslashes($e));
    $query->bindValue(':k',addslashes($k));
    $query->bindValue(':j',addslashes($j));
    $query->bindValue(':t',addslashes($t));
    if(strlen($s) > 0 && strlen($r) > 0 && $n != 0 && strlen($e) > 0 && strlen($k) > 0 && $j != null){
      $query->execute();
      $this->ultimo = true;
    }
  }

  public function list(){
    $query = $this->pdo->query('SELECT * FROM kanji');
    $lista = $query->fetchAll(PDO::FETCH_ASSOC);
    return $lista;
  }

  public function search($array){
    $lista = [];
    foreach ($array as $n) {
      $query = $this->pdo->prepare('SELECT * FROM kanji WHERE JLPT = :n');
      $query->bindValue(':n',$n);
      $query->execute();
      $kanjis = $query->fetchAll(PDO::FETCH_ASSOC);
      foreach($kanjis as $kanji){
        array_push($lista,$kanji);
      }
    }
    return $lista;
  }
}

 ?>
