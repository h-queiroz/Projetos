<?php
require('classes/Kanji.php');

$kanji = new Kanji();
$lista = $kanji->search($_POST['levels']);

// Nota: apenas mandar assim não vai fazer que receba como JSON do lado de lá.
// Tem que se certificar que na hora da requisição por Jquery, esteja lá dataType:'JSON'
// se não irá receber um array de JSON's com uma string.
echo json_encode($lista);

 ?>
