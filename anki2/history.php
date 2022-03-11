<?php
require('classes/Tempo.php');

$tempo = new Tempo();
$historico = $tempo->list();
$lista = $historico;

function sort_my_array($array, $order_by, $order){
 switch ($order) {
     case "asc":
         usort($array, function ($first, $second) use ($order_by) {
           return $first[$order_by] <=> $second[$order_by];
         });
         break;
     case "desc":
         usort($array, function ($first, $second) use ($order_by) {
           return $second[$order_by] <=> $first[$order_by];
         });
         break;
     default:
         break;
 }
 return $array;
}


// Tentando fazer a página ordenar os não apenas o primeiro valor como também o segundo, mas sem sucesso até então.

// function sort_array($array, $order, $order_by1, $order_by2 = null){
//     if($order == "asc") {
//       usort($array, function ($first, $second) use ($order_by1) {
//         return $first[$order_by1] <=> $second[$order_by1];
//       });
//     }else{
//       usort($array, function ($first, $second) use ($order_by1) {
//         return $second[$order_by1] <=> $first[$order_by1];
//       });
//     }
//
//     if($order_by2){
//       $i = 1;
//       $j = 0;
//       $terceiro;
//       if ($order == "asc") {
//         while($i != count($array) - 1){
//           if($array[$j][$order_by1] == $array[$i][$order_by1]){
//             if($array[$j][$order_by2] < $array[$i][$order_by2]){
//               $terceiro = $array[$j];
//               $array[$j] = $array[$i];
//               $array[$i] = $terceiro;
//               $terceiro = '';
//             }
//           }
//           $i++;
//           $j++;
//         }
//       }else{
//         while($i != count($array) - 1){
//           if($array[$j][$order_by1] == $array[$i][$order_by1]){
//             if($array[$j][$order_by2] > $array[$i][$order_by2]){
//               $terceiro = $array[$j];
//               $array[$j] = $array[$i];
//               $array[$i] = $terceiro;
//               $terceiro = '';
//             }
//           }
//           $i++;
//           $j++;
//         }
//       }
//     }
//
//     return $array;
// }

if($_POST && isset($_POST['erros'])){
  $lista = sort_my_array($lista,'erros','asc');
}elseif($_POST && isset($_POST['tempo'])){
  $lista = sort_my_array($lista,'tempo','asc');
}else{
  $lista = sort_my_array($lista,'data','asc');
}

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>History</title>
  </head>
  <body>
    <a href="index.php">← Página Principal</a>
    <form method="post">
      <button type="submit" name="data">Data</button>
      <button type="submit" name="erros">Erros</button>
      <button type="submit" name="tempo">Tempo</button>
    </form>

    <table border='1'>
      <tr>
        <th>Data</th>
        <th>Erros</th>
        <th>Tempo</th>
        <th>Níveis</th>
      </tr>
      <?php
      foreach ($lista as $item) {
        echo "<tr>";
        foreach($item as $key => $value){
          echo "<td>$value</td>";
        }
        echo "</tr>";
      }
       ?>

    </table>
  </body>
</html>
