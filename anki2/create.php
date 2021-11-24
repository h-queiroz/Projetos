<?php
require('classes/Kanji.php');

if ($_POST) {
  $kanji = new Kanji();
  $kanji->create($_POST['simbolo'],$_POST['romaji'],$_POST['tracos'],$_POST['english'],$_POST['kana'],$_POST['JLPT']);
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inserção</title>
    <link rel="stylesheet" href="css/create.css">
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
    <link rel="manifest" href="ico/site.webmanifest">
  </head>
  <body>
    <a href="index.html">← Voltar</a>
    <h1>Insira um Kanji</h1>
    <?php
    if (isset($kanji) && $kanji->ultimo) {
      echo "<h2>A inserção foi feita com sucesso</h2>";
    }
     ?>
    <fieldset>
      <form method="post">
        <label for="simbolo">Símbolo</label>
        <input type="text" name="simbolo" autofocus autocomplete="off"><br>
        <label for="kana">Kana</label>
        <input type="text" name="kana" autocomplete="off"><br>
        <label for="romaji">Romaji</label>
        <input type="text" name="romaji" autocomplete="off"><br>
        <label for="english">English</label>
        <input type="text" name="english" autocomplete="off"><br>
        <label for="JLPT">JLPT</label>
        <select name="JLPT">
          <option value="N5">N5</option>
          <option value="N4" selected>N4</option>
        </select><br>
        <label for="tracos">Nº de Traços</label>
        <input type="number" name="tracos" autocomplete="off" value='0'><br>
        <button type="submit">Enviar</button>
      </form>
    </fieldset>
  </body>
</html>
