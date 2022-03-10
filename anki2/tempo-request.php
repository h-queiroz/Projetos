<?php
require_once('classes/Tempo.php');

$tempo = new Tempo();
$tempo->insert($_POST['erros'],$_POST['tempo']);

echo json_encode('Parabéns acabaram os kanji');
 ?>
