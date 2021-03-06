<?php
require ('classes/Kanji.php');
require ('classes/Tag.php');

$objectTag = new Tag();
$kanji = new Kanji();
$lista = $kanji->list();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Lista de Kanjis</title>
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
    <link rel="manifest" href="ico/site.webmanifest">
    <style media="screen">
      body{
        font-size: 25px;
        font-family: sans-serif;
        background-color: rgb(83, 86, 92);
      }
      a{
        color:black;
      }
      table{
        margin: auto;
        background-color: white;
      }
      td{
        padding: auto 5px;
      }

      tbody tr td:nth-child(1){
        background-color: rgba(0,0,0,0.7);
        color: white;
      }

      tbody tr td:nth-child(2), tbody tr td:nth-child(3), tbody tr td:nth-child(4){
        font-size: 30px;
      }
    </style>
  </head>
  <body>
    <a href="index.php">← Voltar</a><br><br>
    <table border='1'>
      <tr bgcolor='#878b91'>
        <th width='50'>ID</th>
        <th width='170'>Símbolo</th>
        <th width="200">Kana</th>
        <th width='200'>English</th>
        <th width='200'>Tag</th>
        <th width='100'>JLPT</th>
        <th width='70'>N° de traços</th>
        <th width='120'>Ações</th>
      </tr>
        <?php
        foreach($lista as $kanji){
          echo "<tr align='center'>";
          echo "<td>".$kanji['id']."</td>";
          echo "<td>".$kanji['simbolo']."</td>";
          echo "<td>".$kanji['kana']."</td>";
          echo "<td>".$kanji['english']."</td>";
          if ($kanji['tags'] == null || $kanji['tags'] == 'NULL') {
            echo "<td>-</td>";
          }else{
            $tags = $objectTag->search($kanji['tags']);
            if(gettype($tags) != 'array'){
              echo "<td>".$tags."</td>";
            }else{
              echo "<td>".implode(' / ',$tags)."</td>";
            }
          }
          echo "<td>".$kanji['JLPT']."</td>";
          echo "<td>".$kanji['ntracos']."</td>";
          echo "<td><a href='#'><img src='assets/edit.png' width='30px'></a></td>";
          echo "</tr>";
        }

         ?>
    </table>
  </body>
</html>
