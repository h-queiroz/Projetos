<?php
require('classes/Kanji.php');
require('classes/Tag.php');

if ($_POST) {
  $kanji = new Kanji();
  if (isset($_POST['tags']) && count($_POST['tags']) > 1) {
    $kanji->create($_POST['simbolo'],$_POST['romaji'],$_POST['tracos'],$_POST['english'],$_POST['kana'],$_POST['JLPT'],implode(',',$_POST['tags']));
  }elseif(isset($_POST['tags']) && count($_POST['tags']) == 1){
    $kanji->create($_POST['simbolo'],$_POST['romaji'],$_POST['tracos'],$_POST['english'],$_POST['kana'],$_POST['JLPT'],$_POST['tags'][0]);
  }else{
    $kanji->create($_POST['simbolo'],$_POST['romaji'],$_POST['tracos'],$_POST['english'],$_POST['kana'],$_POST['JLPT'],'NULL');
  }

  // echo '<pre>';
  // print_r($_POST);
  // echo '</pre>';
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inserção</title>
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
    <link rel="manifest" href="ico/site.webmanifest">
    <link rel="stylesheet" href="css/create.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <a href="index.html">← Voltar</a>
    <?php
    if ($_POST) {
      if ($kanji->ultimo) {
        echo "<h2 class='green'>A inserção foi feita com sucesso</h2>";
      }else{
        echo "<h2 class='red'>Não foi inserido</h2>";
      }
    }
     ?>
    <fieldset>
      <h1>Insira um Kanji</h1>
      <form method="post">
        <input type="text" name="simbolo" autofocus autocomplete="off" placeholder="Símbolo">
        <input type="text" name="kana" autocomplete="off" placeholder="Kana"><br>
        <input type="text" name="romaji" autocomplete="off" placeholder="Romaji">
        <input type="text" name="english" autocomplete="off" placeholder="English"><br>
        <select name="JLPT">
          <option value="">Selecione um nível</option>
          <option value="N5">N5</option>
          <option value="N4" selected>N4</option>
        </select>
        <input type="number" name="tracos" autocomplete="off" value='0' placeholder="Nº de Traços"><br>
        <br>
        <?php
        $tags = new Tag();
        $tags = $tags->list();
        foreach ($tags as $tag) {
          ?>
          <label>
            <input type="checkbox" name="tags[]" value="<?php echo $tag['id'] ?>"><?php echo $tag['nome'] ?>
          </label>
          <?php
        }
         ?>
        <br><br>
        <button type="submit">Enviar</button>
      </form>
    </fieldset>
  </body>
</html>
