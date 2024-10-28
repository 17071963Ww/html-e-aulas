var avaliation = [];

function GetButtonValue(id) {
    var button = document.getElementById(id); 
    if (button) { 
        avaliation.push(button.value); 
    } else {
        console.log("Erro na captura de avaliação");
    }
}

function exibe() {
    console.log(avaliation);
}