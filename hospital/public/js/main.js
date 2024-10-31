const questions = [
    { text: "Com base na sua experiência em nossa instituição, em uma escala de 0 (MUITO INSATISFEITO) a 10 (COMPLETAMENTE SATISFEITO), o quão provável você recomendaria nossos serviços a um amigo e/ou familiar?", type: "button" },
    { text: "Como você avalia a cordialidade da equipe de atendimento?", type: "button" },
    { text: "O atendimento foi rápido e eficiente?", type: "button" },
    { text: "Comente algo (opcional)", type: "text" }
];
const options = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]; 

let avaliation = [];
let index = 0;
let timeLeft = 15;
let thanksMessage = "O Hospital Regional Alto Vale (HRAV) agradece sua resposta! Ela é muito importante para nós, pois nos ajuda a melhorar continuamente nossos serviços."

const socket = new WebSocket('ws://localhost:8080/hospital');

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

    checkOrientation();
    Question();
    window.addEventListener("resize", checkOrientation);
});

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
