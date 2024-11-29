<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Página de Avaliação</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" href="css/admin.css">
    <script src="js/admin-cadastros.js" defer></script>

</head>
<body>
    <?php
        require_once '../scr/funcoes.php';
        TrueAdmin();
    ?>

    <!-- BASE DO HTML -->
    
    <!-- Formulário para Usuários -->

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
                    <a href="admin-home.php" class="select-input">
                        <img src="css/img/casa.png" alt="Botão casa">
                    </a>
                </li>
                        
                <li>
                    <a href="admin-BI.php" class="select-input">
                        <img src="css/img/grafico.png" alt="Botão gráfico">
                    </a>
                </li>    
                
                <li>
                    <a href="admin-cadastros.php" class="select-input active">
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
                    <p class="info-head-valor">0</p>
                    <p>Setores cadastrados</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor">0</p>
                    <p>Avaliações positivas hoje</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor">0</p>
                    <p>Avaliações Negativas hoje</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor">Nome dispositivo</p>
                    <p>Dispositivo Atual</p>
                </div>

                <div class="info-head">
                    <p class="info-head-valor page">- Cadastros</p>
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
            <div class="Grafic-bar table-2 cad">
                <div class="cad-scrool">

                    <!-- Usuarios -->
                     
                    <table>
                        <thead>
                            <tr class="table-title">
                                <td colspan="3">Usuarios</td>
                            </tr>
                            <tr>
                                <th>#ID</th>
                                <th>Usuario</th>
                                <th>Data Criação</th>
                            </tr>
                        </thead>
                        <tbody id="usuariosTableBody">

                        </tbody>
                    </table>

                </div>    
                <div class="select-cad">
                    <div class="central-cad">
                        <div class="select-cad-button criar">                        
                            <button id="actionButtonUser">Criar Usuário</button>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-username">
                            <h1>Usuário Selecionado:</h1>
                            <input type="hidden" id="selectedUserId">
                            <p id="selectedUserName">Nenhum usuário selecionado</p>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-button">                        
                            <button id="editButtonUsuario">Editar</button>
                            <button id="deleteButtonUsuario">Excluir</button>
                            <button id="alterarSenhaButton">Alterar Senha</button>            
                        </div>
                    </div>
                </div> 
            </div>

            <!-- Setores -->

            <div class="Grafic-bar table-2 cad">
                <div class="cad-scrool">
                    <table>
                        <thead>
                            <tr class="table-title">
                                <td colspan="3">Setores</td>
                            </tr>
                            <tr>
                                <th style="width: 50px;">#ID</th>
                                <th>Setor</th>
                                <th style="width: 90px;">Status</th>
                            </tr>
                        </thead>
                        <tbody  id="setoresTableBody">
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="select-cad">
                    <div class="central-cad">
                        <div class="select-cad-button criar">                        
                            <button id="actionButtonSetor">Criar Setor</button>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-username">
                        <h1>Setor Selecionado:</h1>
                        <input type="hidden" id="selectedSetorId">
                        <p id="selectedSetorName">Nenhum setor selecionado</p>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-button">                        
                            <button id="editButtonSetor">Editar</button>
                            <button id="deleteButtonSetor">Excluir</button>
                            <button id="toggleStatusButtonSetor">Ativar/Desativar</button>         
                        </div>
                    </div>
                </div> 
            </div>
        </div>

        <!-- Perguntas -->

        <div class="div grafico">
            
        <div class="Grafic-bar table-2 cad">
                <div class="cad-scrool">
                    <table>
                        <thead>
                            <tr class="table-title">
                                <td colspan="4">Perguntas</td>
                            </tr>
                            <tr>
                                <th>#ID</th>
                                <th style="width: 200px;">Pergunta</th>
                                <th>Status</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody id="perguntasTableBody">
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="select-cad">
                    <div class="central-cad">
                        <div class="select-cad-button criar">                        
                            <button id="actionButtonPergunta">Criar Pergunta</button>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-username">
                            <h1>Pergunta Selecionada:</h1>
                            <input type="hidden" id="selectedPerguntaId">
                            <p id="selectedPerguntaName">Nenhuma pergunta selecionada</p>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-button">                        
                        <button id="editButtonPergunta">Editar</button>
                        <button id="deleteButtonPergunta">Excluir</button>
                        <button id="toggleStatusButtonPerguntas">Ativar/Desativar</button>          
                        </div>
                    </div>
                </div> 
            </div>

            <!-- Dispositivos -->

            <div class="Grafic-bar table-2 cad">
                <div class="cad-scrool">
                    <table>
                        <thead>
                            <tr class="table-title">
                                <td colspan="3">Dispositivos</td>
                            </tr>
                            <tr>
                                <th style="width: 50px;">#ID</th>
                                <th>Dispositivo</th>
                                <th style="width: 90px;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="dispositivosTableBody">
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>  
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>    
                <div class="select-cad">
                    <div class="central-cad">
                        <div class="select-cad-button criar">                        
                            <button id="actionButtonDispositivo">Criar Dispositivo</button>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-username">
                            <h1>Dispositivo Selecionado:</h1>
                            <input type="hidden" id="selectedDispositivoId">
                            <p id="selectedDispositivoName">Nenhum dispositivo selecionado</p>
                        </div>
                    </div>
                    <div class="central-cad">
                        <div class="select-cad-button">                        
                            <button id="editButtonDispositivo">Editar</button>
                            <button id="deleteButtonDispositivo">Excluir</button>
                            <button>Ativar/Desativar</button>              
                        </div>
                    </div>
                </div> 
            </div>

        </div>
    </div> 
    <!-- FIM - BASE DO HTML -->
</body>
</html>
