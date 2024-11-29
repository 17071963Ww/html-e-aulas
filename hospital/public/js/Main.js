let questions = [];
let avaliation = [];
let index = 0;
let timeLeft = 10;
let thanksMessage = "O Hospital Regional Alto Vale (HRAV) agradece sua resposta! Ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços."; 

// DOM
document.addEventListener("DOMContentLoaded", () => {
    loadQuestions();
    checkOrientation();
    Question();
    window.addEventListener("resize", checkOrientation);
});

// Função para carregar perguntas
function loadQuestions() {
    fetch('/hospital/scr/perguntas.php')
        .then(response => response.json())
        .then(data => {
            questions = data.map(q => ({
                id: q.id_perguntas, // Adicionando o ID da pergunta
                text: q.pergunta,
                type: q.tipo
            }));
        })
        .catch(error => {
            alert('Nenhuma pergunta cadastrada: ' + error.message);
        });
}

// Função para enviar as respostas
// Função para enviar as respostas
function SendQuestions() {
    fetch('/hospital/scr/perguntas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            respostas: avaliation, 
            user_id: selectedUser 
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log(data); 
    })
    .catch(error => console.error(error));
}


// Função que exibe uma pergunta de cada vez
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
                    button.onclick = () => GetButtonValue(Question.id, option); // Enviando o id da pergunta junto
                    buttonsContainer.appendChild(button);
                });
            } else if (Question.type === "text") {
                buttonsContainer.style.display = "none";
                textAreaContainer.style.display = "block";
            }            
        } else {
            // Finaliza as perguntas
            questionTextElement.innerText = thanksMessage;
            buttonsContainer.style.display = "none";
            textAreaContainer.style.display = "none";

            // Criação de elementos de carregamento
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

            // Lógica do timer
            const countdown = setInterval(() => {
                timeLeft -= 1;
                timerDisplay.innerText = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    SendQuestions(); // Envia as respostas quando o timer chega a zero
                    console.log('acaba timer')
                }
            }, 1000); 
        }
        transition.classList.remove("out"); 
        index++;
    }, 1000);
}

// Função chamada ao clicar em um botão de opção
function GetButtonValue(questionId, value) {
    avaliation.push({ id: questionId, answer: value }); // Armazena a resposta com o ID da pergunta
    Question();
}

// Função chamada ao enviar texto
function submitText() {
    const textArea = document.querySelector(".TextArea textarea");
    const textValue = textArea.value;
    avaliation.push({ id: questions[index].id, answer: textValue }); // Associa a resposta com a pergunta
    textArea.value = ""; 
    Question();
}
