<?php
require('classes/Kanji.php');

if ($_POST && !empty($_POST['simbolo']) && !empty($_POST['romaji']) && !empty($_POST['tracos']) && !empty($_POST['english']) && !empty($_POST['kana'])) {
  $kanji = new Kanji();
  $kanji->create(addslashes($_POST['simbolo']),addslashes($_POST['romaji']),addslashes($_POST['tracos']),addslashes($_POST['english']),addslashes($_POST['kana']));
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
        <label for="romaji">Romaji</label>
        <input type="text" name="romaji" autocomplete="off"><br>
        <label for="tracos">Nº de Traços</label>
        <input type="number" name="tracos" autocomplete="off"><br>
        <label for="english">English</label>
        <input type="text" name="english" autocomplete="off"><br>
        <label for="kana">Kana</label>
        <input type="text" name="kana" autocomplete="off"><br>
        <button type="submit">Enviar</button>
      </form>
    </fieldset>
  </body>
</html>
