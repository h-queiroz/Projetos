<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <!-- Tags Necessárias -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <title>Projeto Anki Melhorado</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="ico/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="ico/favicon-16x16.png">
    <link rel="manifest" href="ico/site.webmanifest">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

    <!-- Arquivo CSS -->
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <!-- Links para outras páginas -->
    <a href="create.php" id='create'>← Inserir Kanji</a>
    <a href="list.php" id='list'>Lista de Kanji's →</a>

    <!-- Onde o Kanji será inserido -->
    <div class="show-kanji"></div>

    <!-- Onde você digita o romaji do Kanji mostrado -->
    <div class="response">
      <input type="text" name="Resposta" placeholder="Digite aqui a sua resposta..." maxlength="20" autofocus>
    </div>

    <div class="contadores">
      <span id="erros">Erros: 0</span>
      <span id="faltam">Quantos faltam: </span>
    </div>

    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript">
      // Pegando itens do DOM
      let kanjis = [];
      let espaco = document.querySelector('.show-kanji');
      let resposta = document.querySelector('input');
      let contadores = document.querySelector('.contadores');
      let faltam = document.querySelector('#faltam');
      let erros = document.querySelector('#erros');
      let nerros = 1;
      let height = document.body.offsetHeight;
      let width = document.body.offsetWidth;
      document.body.style = 'width:'+document.body.offsetWidth+'px;height:'+document.body.offsetHeight+'px';

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
          // Pegando um kanji aleatório e inserindo na variável atual e colocando a atual na tela
          let pos = Math.floor(Math.random() * (kanjis.length - 0) + 0);
          let atual = kanjis.splice(pos,1)[0];
          espaco.innerHTML = atual.simbolo;
          faltam.innerHTML = "Quantos faltam: "+kanjis.length;

          // Gerando Evento que se o tecla "Enter" for pressionada, fará a verificação se o que foi digitado está certo
          document.addEventListener('keypress',function(event){
            // Se pressionar "Enter" e campo não estiver vazio..
            if (event.key == 'Enter' && resposta.value != '') {
              // Se o que foi digitado estiver certo..
              if (resposta.value == atual.romaji) {
                // E se não sobrar mais nenhum kanji a ser verificado
                if (kanjis.length == 0) {
                  // Mostre isso..
                  espaco.style = 'background-color: green';
                  alert('Parabéns acabaram os kanji');
                }else{
                  // Se não, mostre outro.
                  pos = Math.floor(Math.random() * (kanjis.length - 0) + 0);
                  atual = kanjis.splice(pos,1)[0];
                  console.log(atual);
                  console.log("Quantos faltam : "+kanjis.length);
                  espaco.innerHTML = atual.simbolo;
                  faltam.innerHTML = "Quantos faltam: "+kanjis.length;
                  resposta.value = '';
                }
              }else{
                // Ações para se digitou errado
                erros.innerHTML = "Erros: "+nerros++;
                espaco.style = 'background-color: red';
                setTimeout(function(){
                  espaco.style = 'background-color: white';
                },100);
              }
            }
          })
        }
      })

    </script>
  </body>
</html>
