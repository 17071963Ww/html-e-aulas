<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Página de Avaliação</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/admin.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <?php
        require_once '../scr/funcoes.php';
        TrueAdmin();
    ?>

    <!-- BASE DO HTML -->
    <nav class="sidebar">
        <div class="left-section">
            <figure class="logo">
                <img src="css/img/Logo.png" alt="Logo Hospital Regional Alto Vale">
            </figure>

            <div class="separator">
                <div class="separator-element"></div>
            </div>

            <ul class="nav-list">         
                <li>
                    <a href="admin-home.php" class="select-input active">
                        <img src="css/img/casa.png" alt="Botão casa">
                    </a>
                </li>
                        
                <li>
                    <a href="admin-BI.php" class="select-input">
                        <img src="css/img/grafico.png" alt="Botão gráfico">
                    </a>
                </li>     
                
                <li>
                    <a href="admin-cadastros.php" class="select-input">
                        <img src="css/img/usuario.png" alt="Botão Cadastros">
                    </a>
                </li>  

                <li>
                    <a href="index.php" class="select-input">
                        <img src="css/img/transferir.png" alt="Botão Trocar modo">
                    </a>
                </li>  
            </ul>
        </div>

        <div class="right-section">
            <h1 class="nav-title">HRAV</h1>
            <ul class="nav-items">
                <li>Início</li>
                <li>Gráficos</li>
                <li>Cadastros</li>
                <li>Avaliação</li>
            </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <div class="main-content">
        
        <div class="head">
            <div class="info">
                <div class="info-head">
                    <p class="info-head-valor" id="totalSetores">0</p>
                    <p>Setores cadastrados</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor" id="AvaliacaoPositivas">0</p>
                    <p>Avaliações positivas hoje</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor" id="AvaliacaoNegativas">0</p>
                    <p>Avaliações Negativas hoje</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor" id="Dispositivo">Nome dispositivo</p>
                    <p>Dispositivo Atual</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor page">- Pagina Inicial</p>
                </div>
            </div>

            <div class="account" onclick="account_list()">
                <p>
                    <?php
                        echo getNomeUsuario();
                    ?>
                </p>

                <figure>
                    <img src="css/img/foto-perfil.png" alt="foto de perfil">
                </figure>
            </div>
        </div>
        
        <div class="div grafico">
            <div class="Grafic-bar">
                <canvas id="myChart" height="310px" width="400px"></canvas>
            </div>

            <div class="block">
                <div class="Grafic-bar most-value">
                    <div class="trofeu">
                        <figure>
                            <img src="css/img/trofeu.png" alt="troféu">
                        </figure>
                    </div>

                    <div class="most-value-title">
                        <h1 id="setor-top">setor_nome</h1>
                    </div>

                    <div class="most-value-text">
                        <p>É o setor mais bem avaliado deste mês!</p>
                    </div>
                </div>

                <div class="Grafic-bar most-value">
                    <div class="trofeu">
                        <figure id="ava">
                            <img src="css/img/avaliacao.png" alt="avaliação">
                        </figure>
                    </div>

                    <div class="most-value-title">
                        <h1 id="AvaliacaoTotal">0</h1>
                    </div>

                    <div class="most-value-text">
                        <p id="avatext">Avaliações hoje</p>
                    </div>
                </div>    
            </div>

            <div class="Grafic-bar filters">
                <canvas id="myChart-history" height="310px" width="760px"></canvas>
            </div>
        </div>
        <div class="div grafico">
    <div class="Grafic-bar table">
        <table>
            <thead>
                <tr class="table-title">
                    <td colspan="5">Últimas Avaliações</td>
                </tr>
                <tr>
                    <th style="width: 20px;">#ID</th>
                    <th style="width: 50px;">Setor</th>
                    <th style="width: 50px;">Hora</th>
                    <th>Pergunta</th>
                    <th>Resposta</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
        </div>
    </div>

    </div>
    <!-- FIM - BASE DO HTML -->
</body>


</html>
