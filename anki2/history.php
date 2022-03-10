<?php
require('classes/Tempo.php');

$tempo = new Tempo();
$historico = $tempo->list();
$lista = $historico;

// echo "<pre>";
// print_r($historico);
// echo "</pre>";

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


function sort_array($array, $order, $order_by1, $order_by2 = null){
    if($order == "asc") {
      usort($array, function ($first, $second) use ($order_by1) {
        return $first[$order_by1] <=> $second[$order_by1];
      });
    }else{
      usort($array, function ($first, $second) use ($order_by1) {
        return $second[$order_by1] <=> $first[$order_by1];
      });
    }

    if($order_by2){
      $i = 1;
      $j = 0;
      $terceiro;
      if ($order == "asc") {
        while($i != count($array) - 1){
          if($array[$j][$order_by1] == $array[$i][$order_by1]){
            if($array[$j][$order_by2] < $array[$i][$order_by2]){
              $terceiro = $array[$j];
              $array[$j] = $array[$i];
              $array[$i] = $terceiro;
              $terceiro = '';
            }
          }
          $i++;
          $j++;
        }
      }else{
        while($i != count($array) - 1){
          if($array[$j][$order_by1] == $array[$i][$order_by1]){
            if($array[$j][$order_by2] > $array[$i][$order_by2]){
              $terceiro = $array[$j];
              $array[$j] = $array[$i];
              $array[$i] = $terceiro;
              $terceiro = '';
            }
          }
          $i++;
          $j++;
        }
      }
    }

    return $array;
}

$lista = sort_array($lista,'asc','erros','tempo');
// var_dump($lista);

echo "<pre>";
print_r($lista);
echo "</pre>";

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>History</title>
  </head>
  <body>
    <a href="index.php">← Página Principal</a>

    <table border='1'>
      <tr>
        <th>data</th>
        <th>erros</th>
        <th>tempo</th>
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
