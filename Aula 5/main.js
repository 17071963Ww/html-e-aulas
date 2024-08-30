// willian pinotti

///////////////{              CALCULADORA             }////////////////////////

let Tree = [];
let operacao = '';

function LimitPush(val) {
    if (Tree.length === 0) {
        Tree.push(val);
    } else if (Tree.length === 1) {
        Tree.push(val);
    } else {
        Tree[1] = val; 
    }
}

function alteraVisor() {
    let Sval = document.getElementById('monitor');
    VisorCor = document.getElementById('visor');
    if (Sval.value > 0) {
        VisorCor.style.backgroundColor = "rgb(0, 56, 37)";
    }
    if (Sval.value < 0) {
        VisorCor.style.backgroundColor = "rgb(255, 0, 0)";
    }
    if (Sval.value == 0) {
        VisorCor.style.backgroundColor = "rgb(145, 145, 145)";
    }
}

function igual() {
    let Sval = document.getElementById('monitor');
    let val = parseFloat(Sval.value.replace(',', '.'));
    let valorfinal = 0;

    LimitPush(val);

    if (Tree.length < 2 || operacao === '') {
        return;
    }

    switch (operacao) {
        case '+':
            valorfinal = Tree[0] + Tree[1];
            break;
        case '-':
            valorfinal = Tree[0] - Tree[1];
            break;
        case '*':
            valorfinal = Tree[0] * Tree[1];
            break;
        case '/':
            if (Tree[1] === 0) {
                alert('Por favor nem tente kk');
                Tree = [];
                operacao = '';
                return;
            }
            valorfinal = Tree[0] / Tree[1];
            break;
    }

    Sval.value = valorfinal;
    Tree = [valorfinal]; 
    operacao = '';

    alteraVisor()
    
}

function simulaClick(id) {
    let but = document.getElementById(id);
    if (but) {
        but.classList.add('button-active-function');

        setTimeout(function() {
            but.classList.remove('button-active-function');
        }, 100);
    } 
}

function ValorAtual(digito) {
    const monitor = document.getElementById('monitor');
    monitor.value += digito;   
}

function Deletar() {
    const del = document.getElementById('monitor');
    del.value = del.value.substring(0, del.value.length - 1); 
}

function setOperacao(op) {
    const monitor = document.getElementById('monitor');
    if (Tree.length === 0 && monitor.value !== '') {
        LimitPush(parseFloat(monitor.value));
    }
    operacao = op;
    monitor.placeholder = `${op} `;
    monitor.value = '';  
}

function soma() {
    setOperacao('+');
}

function subs() {
    setOperacao('-');
}

function div() {
    setOperacao('/');
}

function mult() {
    setOperacao('*');
}

function virgula() {
    ValorAtual(',');
}

function um() { ValorAtual('1'); }
function dois() { ValorAtual('2'); }
function tres() { ValorAtual('3'); }
function quatro() { ValorAtual('4'); }
function cinco() { ValorAtual('5'); }
function seis() { ValorAtual('6'); }
function sete() { ValorAtual('7'); }
function oito() { ValorAtual('8'); }
function nove() { ValorAtual('9'); }
function zero() { ValorAtual('0'); }

document.addEventListener('DOMContentLoaded', function() {
    var reset = document.getElementById('limpardiv');
    
    reset.addEventListener('click', function() {
        Tree = [];
        
        var monitor = document.getElementById('monitor');
        monitor.placeholder = '0';

        VisorCor = document.getElementById('visor');
        VisorCor.style.backgroundColor = "rgb(145, 145, 145)";
    });
});

document.addEventListener('keydown', function(event) {
    if (event.code === 'Numpad1') {
        um()
        simulaClick('Um');
    }
    if (event.code === 'Numpad2') {
        dois()
        simulaClick('Dois')
    }
    if (event.code === 'Numpad3') {
        tres()
        simulaClick('Tres')
    }
    if (event.code === 'Numpad4') {
        quatro()
        simulaClick('Quatro')
    }
    if (event.code === 'Numpad5') {
        cinco()
        simulaClick('Cinco')
    }
    if (event.code === 'Numpad6') {
        seis()
        simulaClick('Seis')
    }
    if (event.code === 'Numpad7') {
        sete()
        simulaClick('Sete')
    }
    if (event.code === 'Numpad8') {
        oito()
        simulaClick('Oito')
    }
    if (event.code === 'Numpad9') {
        nove()
        simulaClick('Nove')
    }
    if (event.code === 'Numpad0') {
        zero()
        simulaClick('Zero')
    }
    if (event.code === 'NumpadAdd') {
        soma()
        simulaClick('Soma')
    }
    if (event.code === 'NumpadSubtract') {
        subs()
        simulaClick('Subs')
    }
    if (event.code === 'NumpadMultiply') {
        mult()
        simulaClick('Mult')
    }
    if (event.code === 'NumpadDivide') {
        subs()
        simulaClick('Div')
    }
    if (event.code === 'NumpadDecimal') {
        Virgula()
        simulaClick('Virgula')
    }
    if (event.code === 'Backspace') {
        Deletar()
        simulaClick('deletar')
    }
    if (event.code === 'NumpadEnter' ||event.code === 'Enter') {
        igual()
        simulaClick('=')
    }
  });

///////////////{              TABELA             }//////////////////////// 

