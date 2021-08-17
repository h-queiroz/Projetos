let header = document.querySelector('header');
let secao = document.querySelector('section');
let array = Array.from(secao.children);

array.forEach(function(element){

  if (element.firstElementChild.innerText != "+" && element.firstElementChild.innerText != "=" && element.firstElementChild.innerText != "C" && element.firstElementChild.innerText != "-") {
    let numero = element.firstElementChild.innerText;
    element.addEventListener('click',function(){
      header.innerHTML += numero;
    });
  }else if (element.firstElementChild.innerText == "+") {
    element.addEventListener('click',function(){
      if (header.childNodes.length > 0 && header.lastChild.textContent != "+") {
        let span = document.createElement('span');
        let mais = document.createElement('span');
        mais.textContent = "+";

        if (header.children.length == 0) {
          span.textContent = header.innerText;
          header.innerHTML = "";
          header.appendChild(span);
        }else if(header.lastChild.nodeName == "#text"){
          let ultimo = header.lastChild;
          span.textContent = header.lastChild.data;
          header.removeChild(ultimo);
          header.appendChild(span);
        }
        header.appendChild(mais);
      }
    });
  }else if (element.firstElementChild.innerText == "-") {
    element.addEventListener('click',function(){
      if (header.childNodes.length > 0 && header.lastChild.textContent != "+") {
        let span = document.createElement('span');
        let menos = document.createElement('span');
        menos.textContent = "-";

        if (header.children.length == 0) {
          span.textContent = header.innerText;
          header.innerHTML = "";
          header.appendChild(span);
        }else if(header.lastChild.nodeName == "#text"){
          let ultimo = header.lastChild;
          span.textContent = header.lastChild.data;
          header.removeChild(ultimo);
          header.appendChild(span);
        }
        header.appendChild(menos);
      }
    });
  }else if (element.firstElementChild.innerText == "=") {
    element.addEventListener('click',function(){
      // Finalizando último item da calculadora
      if (header.lastChild.nodeName == "#text") {
        let span = document.createElement('span');
        span.textContent = header.lastChild.textContent;
        let ultimo = header.lastChild;
        span.textContent = header.lastChild.data;
        header.removeChild(ultimo);
        header.appendChild(span);
      }else if(header.lastChild.nodeName == "SPAN" && header.lastChild.textContent == "+" || header.lastChild.nodeName == "SPAN" && header.lastChild.textContent == "-"){
        let ultimo = header.lastChild;
        header.removeChild(ultimo);
      }

      // Fazendo a conta
      let conta = [];
      let operadores = [];
      Array.from(header.children).forEach(function(item){
        if (item.innerText != "+" && item.innerText != "-") {
          conta.push(item.innerText);
        }else if(item.innerText == "+" || item.innerText == "-"){
          operadores.push(item.innerText);
        }
      });
      let resultado = parseInt(conta[0]);
      conta.shift();
      while (conta.length != 0) {
        if (operadores[0] == "+") {
          resultado += parseInt(conta[0]);
        }else if(operadores[0] == '-'){
          resultado -= parseInt(conta[0]);
        }
        conta.shift();
        operadores.shift();
      }
      header.innerHTML = "<span>"+resultado+"</span>";
    });

  }else if (element.firstElementChild.innerText == "C") {
    element.addEventListener('click',function(){
      header.innerHTML = "";
    });
  }
});
