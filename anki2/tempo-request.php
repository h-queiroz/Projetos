<?php
require_once('classes/Tempo.php');

$tempo = new Tempo();
$tempo->insert($_POST['erros'],$_POST['tempo'],$_POST['niveis']);

echo json_encode('Parabéns acabaram os kanji');
 ?>
