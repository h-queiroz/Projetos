<?php
require_once('BancoDados.php');

class Tag{

  private $pdo;

  public function __construct(){
    $this->pdo = new BancoDados();
    $this->pdo = $this->pdo->getPdo();
  }

  public function search($id){
    if (strlen($id) == 1) {
      $query = $this->pdo->prepare('SELECT nome FROM tags WHERE id = :id');
      $query->bindValue(':id',$id);
      $query->execute();
      $result = $query->fetch(PDO::FETCH_ASSOC);
      $result = $result['nome'];
    }else{
      $tags = str_split($id);
      $result = [];
      foreach ($tags as $tag){
        $query = $this->pdo->prepare('SELECT nome FROM tags WHERE id = :id');
        $query->bindValue(':id',$tag);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        array_push($result,$row['nome']);
      }
    }
    return $result;
  }
}

 ?>
