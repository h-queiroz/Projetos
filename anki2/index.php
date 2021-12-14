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

    <!-- Selecionar Modo Escuro -->
    <div class="dark-mode">
      <h3>Selecione o modo</h3>
      <label>Claro
        <input id="bright" type="radio" name="mode" value="bright">
      </label>
      <label>Escuro
        <input id="dark" type="radio" name="mode" value="dark" checked>
      </label>
    </div>

    <!-- Onde seleciona quais Kanji mostrar -->
    <div class="JLPT">
      <form class="JLPT-form">
        <label>
          <input type="checkbox" name="JLPTs[]" value="N5" checked>JLPT N5
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N4">JLPT N4
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N3">JLPT N3
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N2">JLPT N2
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N1">JLPT N1
        </label>
        <button type="submit">Iniciar</button>
      </form>
    </div>

    <!-- Onde o kanji prévio é mostrado -->
    <div class="previous">

    </div>

    <!-- Onde o Kanji Atual será inserido -->
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
      let response = document.querySelector('.response');
      let resposta = document.querySelector('input[name="Resposta"]');
      let bright = document.querySelector('#bright')
      let dark = document.querySelector('#dark')
      let contadores = document.querySelector('.contadores');
      let anterior;
      let previous = document.querySelector('.previous');
      let faltam = document.querySelector('#faltam');
      let erros = document.querySelector('#erros');
      let nerros = 1;
      // let height = document.body.offsetHeight;
      // let width = document.body.offsetWidth;
      // document.body.style = 'width:'+document.body.offsetWidth+'px;height:'+document.body.offsetHeight+'px';
      let form = document.querySelector('.JLPT-form');
      let submit = document.querySelector('button[type=submit]');
      form.onsubmit = function(event){
        event.preventDefault();
        let niveis = {levels: []};
        form.elements['JLPTs[]'].forEach(function(element){
          if(element.checked){
            niveis.levels.push(element.value);
          }
        });
        requisitar(niveis);
      }

      // Criando os eventos do modo escuro e padrão
      dark.addEventListener('change',function(event){
        document.body.style = "background-color: #246b93";
        espaco.style = "background-color: #274060";
        previous.style = "background-color: #274060";
        resposta.style = "background-color: #274060";
      });

      bright.addEventListener('change',function(event){
        document.body.style = "background-color: #42BCF5";
        espaco.style = "background-color: white";
        previous.style = "background-color: white";
        resposta.style = "background-color: white";
      });

      function jogar(kanjis){
        // Pegando um kanji aleatório e inserindo na variável atual e colocando a atual na tela
        let pos = Math.floor(Math.random() * kanjis.length);
        let atual = kanjis.splice(pos,1)[0];
        espaco.innerHTML = atual.simbolo;
        console.log(atual);
        if(atual.tags != null){
          let span = document.createElement('span');
          $.ajax({
            type: 'POST',
            url: 'tags-request.php',
            data: {id: atual.tags},
            dataType: 'JSON',
            success: function(result){
              console.log("Tag:"+result);
              let largura = espaco.clientWidth / 2;
              span.innerText = result;
              espaco.appendChild(span);
              span.style = 'left:'+(largura - (span.clientWidth/2))+'px';
            }
          })
        }
        faltam.innerHTML = "Quantos faltam: "+(kanjis.length + 1);

        // Gerando Evento que se o tecla "Enter" for pressionada, fará a verificação se o que foi digitado está certo
        document.onkeypress = function(event){
          // Se pressionar "Enter" e campo não estiver vazio..
          if (event.key == 'Enter' && resposta.value != '') {
            // Se o que foi digitado estiver certo..
            if (resposta.value == atual.romaji) {
              // E se não sobrar mais nenhum kanji a ser verificado
              if (kanjis.length == 0) {
                // Mostre isso..
                alert('Parabéns acabaram os kanji');
                espaco.style = 'background-color: green';
                faltam.innerHTML = "Quantos faltam: 0";
              }else{
                // Se ainda tiver kanjis, mostre outro.
                anterior = atual;
                previous.innerHTML = '<span>'+anterior.simbolo+'</span><span>'+anterior.kana+'</span><span>'+anterior.english+'</span>';
                pos = Math.floor(Math.random() * kanjis.length);
                atual = kanjis.splice(pos,1)[0];
                console.log(atual);
                console.log("Quantos faltam : "+kanjis.length);
                espaco.innerHTML = atual.simbolo;
                if(atual.tags != null){
                  let span = document.createElement('span');
                  $.ajax({
                    type: 'POST',
                    url: 'tags-request.php',
                    data: {id: atual.tags},
                    dataType: 'JSON',
                    success: function(result){
                      console.log("Tag:"+result);
                      let largura = espaco.clientWidth / 2;
                      span.innerText = result;
                      espaco.appendChild(span);
                      span.style = 'left:'+(largura - (span.clientWidth/2))+'px';
                    }
                  })
                }
                faltam.innerHTML = "Quantos faltam: "+(kanjis.length + 1);
                resposta.value = '';
              }
            }else{
              // Ações para se digitou errado
              erros.innerHTML = `Erros: ${nerros += 1}`;
              espaco.style = 'background-color: red';
              setTimeout(function(){
                if (bright.checked) {
                  espaco.style = 'background-color: white';
                  previous.style = 'background-color: white';
                  previous.style = 'background-color: white';
                }else{
                  espaco.style = 'background-color: #274060';
                  previous.style = 'background-color: #274060';
                }
              },100);
            }
          }
        }
      }

      // Fazendo requisição de todos os kanjis no bando de dados
      function requisitar(niveis){
        // Limpando os campos e restando valores para decidir jogar novamente
        kanjis = [];
        previous.innerHTML = '';
        nerros = 0;
        erros.innerHTML = `Erros: ${nerros}`;
        espaco.style = 'background-color: #274060';
        resposta.value = '';

        $.ajax({
          type:'POST',
          url:'request.php',
          data: niveis,
          dataType:'JSON',
          // Inserindo eles na variável kanjis se a requisição for feita com sucesso
          success:function(result){
            result.forEach(function(kanji){
              kanjis.push(kanji);
            })


            // kanjis = kanjis.filter(kanji => kanji.tags != null);
            // console.log(kanjis);
            jogar(kanjis);
          }
        })
      }
    </script>
  </body>
</html>
