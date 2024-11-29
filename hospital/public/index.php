<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Página de Avaliação</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel='stylesheet' type='text/css' media='screen' href='css/main.css'>
    <script src='js/Main.js' defer></script>
</head>
<body>
    <?php
        require_once '../scr/funcoes.php';
        DestroiAdmin();
    ?>
    <header>
        <!-- Container para Corrigir a orientação caso vire na orientação paisagem-->
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

                <figure class="config">
                    <img src="css/img/config.png" alt="Configurações" onclick="Config()">
                </figure>
            </div>  
    </header>

    <main>
    <div class="conteudo">

        <div class="walp"></div> <!-- wallpaper desencentralizado e realocado, por questões de css, animações, blur -->

        <div class="main">
            <!-- Container para Login de admin, (inicia no display: none) -->    
            <div class="Config-form out">
                <div class="logintitle">
                    <p>Painel do Administrador</p>
                </div>

                <form onsubmit="loginConfig(event)">
                    <div class="login">
                        <div class="userdiv">
                            <label for="user">Nome de Usuário</label><br>
                            <input id="user" name="user" type="text" required autofocus>
                        </div>
                        <div class="passworddiv">
                            <label for="password">Senha</label><br>
                            <input id="password" name="password" type="password">
                        </div>
                        <div class="LoginSubmit">
                            <input type="submit" value="Enviar" id="enviar">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Container para as perguntas e respostas gerenciadas pelo JavaScript -->
            <div class="transition">
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
    </main>
        <footer>
            <p>Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </footer>
    </div>
</body>
</html>

