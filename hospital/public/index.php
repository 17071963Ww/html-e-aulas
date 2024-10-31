<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Página de Avaliação</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel='stylesheet' type='text/css' media='screen' href='css/style.css'>
    <script src='js/script.js' defer></script>
</head>
<body>
    <header>
        <!-- Container para Corrigir a orientação  -->
        <div class="rotate">
            <div class="rotate-message">
                <figure class="img-cell">
                    <img src="css/img/Cell.jpeg" alt="Celular virando">
                </figure>
            </div>
            <div class="rotate-message">
                <p>Por favor, vire o dispositivo</p>
            </div>
        </div>

    <div class="top-info">
        <figure class="Logo">
            <img src="css/img/Logo.png" alt="Logo-Hospital-regional-Alto-Vale">
        </figure>

        <p>Hospital Regional Alto Vale (HRAV)</p>
    </div>    

    </header>

    <div class="conteudo">
        <div class="walp"></div>
        <div class="main">
            <div class="transition">
                <!-- Container para as perguntas e respostas geradas pelo JavaScript -->
                <div class="question-box">
                    <div class="question-box-text">
                        <p></p>
                    </div>
                    <div class="Buttons"></div>
                    <div class="TextArea" style="display: none;">
                        <textarea placeholder="Escreva seu comentário aqui..."></textarea>
                        <button class="TextSubmit" onclick="submitText()">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </footer>
    </div>
</body>
</html>
