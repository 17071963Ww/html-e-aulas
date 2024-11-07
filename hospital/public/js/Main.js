const options = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
let questions = [];
let avaliation = [];
let index = 0;
let timeLeft = 10;
let thanksMessage = "O Hospital Regional Alto Vale (HRAV) agradece sua resposta! Ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços."; 

// DOM
document.addEventListener("DOMContentLoaded", () => {
    function checkOrientation() {
        if (window.innerHeight > window.innerWidth) {
            document.querySelector('.rotate-message').style.display = 'flex';
            document.querySelector('.conteudo').style.display = 'none';
        } else {
            document.querySelector('.rotate-message').style.display = 'none';
            document.querySelector('.conteudo').style.display = 'block';
        }
    }

    loadQuestions();
    checkOrientation();
    Question();
    window.addEventListener("resize", checkOrientation);
});

// Funções
function Config() {
    const configForm = document.querySelector('.Config-form');
    if (configForm.classList.contains('out')) {
        configForm.classList.remove('out'); 
    } else {
        configForm.classList.add('out'); 
    }
}

// Main authentication function that handles the fetch request and response processing
function auth(user, password, redirectOnSuccess = 'index.php') {
    fetch('/hospital/scr/auth.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ user: user, password: password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect || redirectOnSuccess;
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Erro:', error));    
}

function loginConfig(event) {
    event.preventDefault();

    const user = document.getElementById('user').value;
    const password = document.getElementById('password').value;

    if (!user || !password) {
        alert("Usuário e senha são obrigatórios.");
        return;
    }

    auth(user, password);
}


function loadQuestions() {
    fetch('/hospital/scr/perguntas.php')
        .then(response => {
            return response.json();
        })
        .then(data => {
            questions = data.map(q => ({
                text: q.pergunta,
                type: q.tipo
            }));
        })
        .catch(error => {
            alert('Nenhuma pergunta cadastrada: ' + error.message);
        });
}

// editar, funcao imcompleta /////////////
function SendQuestions() {
    fetch('/hospital/scr/respostas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'avaliation=' + encodeURIComponent(JSON.stringify(avaliation))
    })
    .then(response => response.text())
    .then(data => {
        console.log(data); 
    })
    .catch(error => console.error(error));
}
////////////////////////////////////////

function Question() {   
    const transition = document.querySelector(".transition");
    transition.classList.add("out");

    setTimeout(() => {
        const questionTextElement = document.querySelector(".question-box-text p");
        const buttonsContainer = document.querySelector(".Buttons");
        const textAreaContainer = document.querySelector(".TextArea");
        buttonsContainer.innerHTML = "";

        if (index < questions.length) {
            const Question = questions[index];
            questionTextElement.innerText = Question.text;

            if (Question.type === "button") {
                buttonsContainer.style.display = "flex";
                textAreaContainer.style.display = "none";

                let i = 0;
                options.forEach(option => {
                    i++;
                    const button = document.createElement("button");
                    button.innerText = option;
                    button.className = 'bt' + i;
                    button.value = option;
                    button.onclick = () => GetButtonValue(option);
                    buttonsContainer.appendChild(button);
                });
            } else if (Question.type === "text") {
                buttonsContainer.style.display = "none";
                textAreaContainer.style.display = "block";
            }            
        } else {
            // layout 
            questionTextElement.innerText = thanksMessage;
            buttonsContainer.style.display = "none";
            textAreaContainer.style.display = "none";
        
            const carregarbox = document.createElement("div");
            carregarbox.className = 'carregar-box'; 
        
            const carregar = document.createElement("div");
            carregar.className = 'carregar'; 
            carregarbox.appendChild(carregar);
            
            document.querySelector('.question-box').appendChild(carregarbox);
        
            const timerDisplay = document.createElement("div");
            timerDisplay.className = 'timer-display';
            document.querySelector('.question-box').appendChild(timerDisplay);
            
            timerDisplay.innerText = timeLeft;
            
            // lógica


            const countdown = setInterval(() => {
                timeLeft -= 1;
                timerDisplay.innerText = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    location.reload();
                    console.log('acaba timer')
                }
            }, 1000); 
        }
        transition.classList.remove("out"); 
        index++;
    }, 1000);
}

function GetButtonValue(value) {
    avaliation.push(value); 
    Question();
}

function submitText() {
    const textArea = document.querySelector(".TextArea textarea");
    avaliation.push(textArea.value); 
    textArea.value = ""; 
    Question();
}
