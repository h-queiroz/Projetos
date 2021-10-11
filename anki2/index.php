<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Projeto Anki Melhorado</title>
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
    <link rel="manifest" href="ico/site.webmanifest">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <a href="create.php" id='create'>← Inserir Kanji</a>
    <a href="list.php" id='list'>Lista de Kanji's →</a>

    <div class="show-kanji">

    </div>
    <div class="response">
      <input type="text" name="Resposta" placeholder="Digite aqui a sua resposta..." maxlength="20" autofocus>
    </div>

    <script type="text/javascript" src="jquery.js">
    </script>
    <script type="text/javascript">
      let kanjis = [];
      let espaco = document.querySelector('.show-kanji');
      let resposta = document.querySelector('input');
      // Fazendo requisição de todos os kanjis no bando de dados
      $.ajax({
        type:'GET',
        url:'request.php',
        dataType:'JSON',
        // Inserindo eles na variável kanjis se a requisição for feita com sucesso
        success:function(result){
          result.forEach(function(kanji){
            kanjis.push(kanji);
          })
          let pos = Math.floor(Math.random() * (kanjis.length - 0) + 0);
          let atual = kanjis.splice(pos,1)[0];
          console.log(atual);
          espaco.innerHTML = atual.simbolo;

          document.addEventListener('keypress',function(event){
            if (event.key == 'Enter' && resposta.value != '') {
              if (resposta.value == atual.romaji) {
                if (kanjis.length != 0) {
                  pos = Math.floor(Math.random() * (kanjis.length - 0) + 0);
                  atual = kanjis.splice(pos,1)[0];
                  console.log(atual);
                  console.log("Quantos faltam : "+kanjis.length);
                  espaco.innerHTML = atual.simbolo;
                  resposta.value = '';
                }else{
                  espaco.style = 'background-color: green';
                  alert('Parabéns acabaram os kanji');
                  // espaco.style = 'background-color: white';
                }
              }else{
                // alert('Resposta Errada');
                espaco.style = 'background-color: red';
                setTimeout(function(){
                  espaco.style = 'background-color: white';
                },100);
                console.log('O que você digitou : '+resposta.value);
                resposta.value = '';
              }
            }
          })

        }
      })

    </script>
  </body>
</html>
