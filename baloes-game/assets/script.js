let iniciar = document.querySelector('#iniciar');
let menu = document.querySelector('#menu');
let contador = document.querySelector('#contador');
let valorContador = parseInt(contador.innerText);
let body = document.querySelector('body');
let cores = ['green','blue','red','yellow','purple'];

let cont = 3

let inicio = function(){
  menu.style = 'display: none;';
  contador.style.display = 'block';
  let intervalo = setInterval(function(){
    cont--;
    if(cont == 0){
      contador.innerText = 'Começar';
      clearInterval(intervalo);
      setTimeout(function(){
        contador.style = "display: none";
        jogar();
      },300);
    }else if (true) {
      contador.innerText = cont;
    }
  },1000);
}

iniciar.addEventListener('click',inicio);
window.addEventListener('keydown',function(event){
  if(event.key == "Enter"){
    inicio();
  }
});

function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min)) + min;
}

function jogar(){
  cont = 0;
  let bola = document.createElement('div');
  body.appendChild(bola);
  bola.setAttribute('class','bola');
  bola.style = 'top: '+getRandomInt(0,600)+'px; left: '+getRandomInt(0,900)+'px; background-color:'+cores[getRandomInt(0,5)]+';';
  bola.addEventListener('click',function(){
    this.style = 'display: none';
  });
  let intervalo2 = setInterval(function(){
    let bola = document.createElement('div');
    body.appendChild(bola);
    bola.setAttribute('class','bola');
    bola.addEventListener('click',function(){
      this.style = 'display: none';
    });
    bola.style = 'top: '+getRandomInt(0,581)+'px; left: '+getRandomInt(0,1266)+'px; background-color:'+cores[getRandomInt(0,5)]+';';
    cont++;
    if(cont == 100){
      clearInterval(intervalo2);
      console.log("Acabou o jogo");
      alert('Acabou o jogo');
    }
  },400)
}
