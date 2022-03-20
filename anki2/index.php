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
    <a href="history.php" id='history'>← Histórico</a>

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
          <input type="checkbox" name="JLPTs[]" value="N5">JLPT N5
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N4">JLPT N4
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N3">JLPT N3
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N2" checked>JLPT N2
        </label>
        <label>
          <input type="checkbox" name="JLPTs[]" value="N1">JLPT N1
        </label>
        <button type="submit" autofocus>Iniciar</button>
      </form>
    </div>

    <!-- Onde o kanji prévio é mostrado -->
    <div class="previous">

    </div>

    <!-- Onde o Kanji Atual será inserido -->
    <div class="show-kanji">Inicie</div>

    <!-- Onde você digita o romaji do Kanji mostrado -->
    <div class="response">
      <input type="text" name="Resposta" placeholder="Digite aqui a sua resposta..." maxlength="20">
    </div>

    <!-- Tabela com valores -->
    <div class="contadores">
      <span id="time">Contagem 00:00</span>
      <span id="erros">Erros: 0</span>
      <span id="faltam">Quantos faltam: 0</span>
      <img src="assets/up-arrow.png" class="arrows" width="30px">
      <img src="assets/down-arrow.png" class="arrows" width="30px">
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
      let anterior;
      let previous = document.querySelector('.previous');
      let contadores = document.querySelector('.contadores');
      let faltam = document.querySelector('#faltam');
      let erros = document.querySelector('#erros');
      let time = document.querySelector('#time');
      let timeMsg = time.textContent;
      let nerros = 0;
      let upArrow = document.querySelectorAll('.arrows')[0];
      let downArrow = document.querySelectorAll('.arrows')[1];

      // let height = document.body.offsetHeight;
      // let width = document.body.offsetWidth;
      // document.body.style = 'width:'+document.body.offsetWidth+'px;height:'+document.body.offsetHeight+'px';

      // Menu de Seleção de nível de JLPT
      let form = document.querySelector('.JLPT-form');
      let jlpt = document.querySelector('.JLPT');
      let submit = document.querySelector('button[type=submit]');
      let levels;
      form.onsubmit = function(event){
        event.preventDefault();
        let niveis = {levels: []};
        form.elements['JLPTs[]'].forEach(function(element){
          if(element.checked){
            niveis.levels.push(element.value);
          }
        });
        levels = niveis.levels;
        requisitar(niveis);
      }

      // Criando os eventos do modo escuro e padrão
      dark.addEventListener('change',function(event){
        document.body.style = "background-color: #246b93";
        espaco.style = "background-color: #04293A";
        previous.style = "background-color: #04293A";
        resposta.style = "background-color: #04293A";
        contadores.style = "background-color: #ECB365";
        jlpt.style = "background-color: #ECB365"
      });

      bright.addEventListener('change',function(event){
        document.body.style = "background-color: #009DAE";
        espaco.style = "background-color: #71DFE7";
        previous.style = "background-color: #71DFE7";
        resposta.style = "background-color: #71DFE7";
        contadores.style = "background-color: #FFE652";
        jlpt.style = "background-color: #FFE652"
      });

      // Criando Eventos de mudar o valor dos Erros na tabela
      upArrow.addEventListener('click',()=>{
        nerros++;
        erros.innerHTML = `Erros: ${nerros}`;
      })

      downArrow.addEventListener('click',()=>{
        nerros--;
        erros.innerHTML = `Erros: ${nerros}`;
      })

      // Criando Evento de se usuário apertar TAB, ir direto para o campo de Resposta
      document.body.onkeydown = (event) => {
        if(event.key == 'Tab'){
          event.preventDefault();
          resposta.focus();
        }
      }

      // Criando função de contagem a partir do momento que começar o jogo
      let contador;
      function contar(m = 0, s = 0){
        let minutos = m != 0 ? m : 0;
        let segundos = s != 0 ? s : 0;
        if(typeof contador !== undefined){
          clearInterval(contador);
          timeMsg = `Contagem ${("0"+minutos).slice(-2)}:${("0"+segundos).slice(-2)}`;
          time.innerHTML = timeMsg;
        }
        contador = setInterval(() => {
          segundos++;
          if(segundos >= 60){
            segundos = 0;
            minutos++;
          }
          timeMsg = `Contagem ${("0"+minutos).slice(-2)}:${("0"+segundos).slice(-2)}`;
          time.innerHTML = timeMsg;
        },1000);
      }

      function jogar(kanjis){

        // Misturando o array inteiro e limitando para ter apenas 10 kanjis
        // kanjis = kanjis.sort(() => Math.random() - 0.5);
        // while(kanjis.length > 3){
        //   kanjis.pop();
        // }
        // console.log(kanjis);

        // Pegando um kanji aleatório e inserindo na variável atual e colocando a atual na tela
        resposta.focus();
        let pos = Math.floor(Math.random() * kanjis.length);
        let atual = kanjis.splice(pos,1)[0];
        espaco.innerHTML = atual.simbolo;
        console.log(atual);
        // Procurando tags para o kanji atual se tiver
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

        contar();

        // Criando Função de parar o tempo se sair da aba atual.

        window.onblur = () => {
          document.title = "Pausado";
          clearInterval(contador);
        }

        window.onfocus = () => {
          let minutoAtual = parseInt(timeMsg.slice(9,11));
          let segundoAtual = parseInt(timeMsg.slice(12,15));
          contar(minutoAtual,segundoAtual);
          document.title = "Voltou";
        }

        // Gerando Evento que se o tecla "Enter" for pressionada, fará a verificação se o que foi digitado está certo
        resposta.onkeypress = function(event){
          // Se pressionar "Enter" e campo não estiver vazio..
          if (event.key == 'Enter' && resposta.value != '') {
            // Se o que foi digitado estiver certo..
            if (resposta.value == atual.romaji) {
              // E se não sobrar mais nenhum kanji a ser verificado
              if (kanjis.length == 0) {
                // Mostrar isso..
                clearInterval(contador);
                faltam.innerHTML = "Quantos faltam: 0";
                alert('Acabaram os kanjis');
                espaco.style = 'background-color: green';
                submit.focus();
                espaco.innerHTML = '';
                espaco.classList.add('finished');
                let h4 = document.createElement('h4')
                h4.innerHTML = atual.simbolo;
                let h5a = document.createElement('h5')
                h5a.innerHTML = atual.kana;
                let h5b = document.createElement('h5')
                h5b.innerHTML = atual.english;
                espaco.appendChild(h4);
                espaco.appendChild(h5a);
                espaco.appendChild(h5b);
                resposta.value = "";

                // E registre o tempo e a quantidade de erros cometidos
                $.ajax({
                  type: 'POST',
                  url: 'tempo-request.php',
                  data: {'erros': nerros,'tempo': `${timeMsg.slice(9)}`,'niveis': levels},
                  dataType: 'JSON'
                  // success: (result) => {
                  //   console.log('success');
                  //   console.log(result);
                  // },
                  // error: (result) => {
                  //   console.log('error');
                  //   console.log(result);
                  // },
                  // complete: (result) => {
                  //   console.log('complete');
                  //   console.log(result);
                  // }
                })
                // .done(() => alert('Registrado'))
                // .fail(() => alert('Não registrado'));

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
              nerros++;
              erros.innerHTML = `Erros: ${nerros}`;
              espaco.style = 'background-color: red';
              setTimeout(function(){
                if (bright.checked) {
                  espaco.style = 'background-color: #71DFE7';
                  previous.style = 'background-color: #71DFE7';
                  previous.style = 'background-color: #71DFE7';
                }else{
                  espaco.style = 'background-color: #04293A';
                  previous.style = 'background-color: #04293A';
                }
              },100);
            }
          }
        }
      }

      // Fazendo requisição de todos os kanjis no bando de dados
      function requisitar(niveis){
        if(espaco.classList.contains('finished')){
          espaco.classList.remove('finished');
        }

        // Animação de loading enquanto carrega os Kanji's
        espaco.innerHTML = '<img src="assets/loading_icon.png" width="80px">';

        // Limpando os campos e restando valores para decidir jogar novamente
        kanjis = [];
        previous.innerHTML = '';
        nerros = 0;
        erros.innerHTML = `Erros: ${nerros}`;
        if (bright.checked){
          espaco.style = 'background-color: #71DFE7';
        }else{
          espaco.style = 'background-color: #04293A';
        }

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
            });

            // kanjis = kanjis.filter(kanji => kanji.tags != null);
            // console.log(kanjis);
            jogar(kanjis);
          }
        })
      }
    </script>
  </body>
</html>
