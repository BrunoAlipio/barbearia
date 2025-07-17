const avaliacoes = document.querySelectorAll('.avaliacao');
let offset = 0;
let passos = 0;
const deslocamento = 450; // distância por movimento
const maxPassos = 1;

setInterval(() => {
  if (passos < maxPassos) {
    offset += deslocamento;
    passos++;
  } else {
    offset = 0;
    passos = 0;
  }

  avaliacoes.forEach(avaliacao => {
    avaliacao.style.transform = `translateX(-${offset}px)`;
  });
}, 3000);

window.alert('Aviso!! Este é um site para teste, não representa uma barbearia real')