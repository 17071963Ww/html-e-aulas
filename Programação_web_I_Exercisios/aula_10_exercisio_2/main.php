<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_COOKIE['usuario']) || !isset($_COOKIE['data_inicio'])) {
    echo "<script>alert('Os dados da sessão foram perdidos. Por favor, faça login novamente.');</script>";
    header("Location: login.php");
    exit();
}

$_SESSION['ultima_requisicao'] = time();

$tempo_sessao = time() - $_SESSION['data_inicio'];

$data_inicio = date('d/m/Y H:i:s', $_SESSION['data_inicio']);

$data_ultima_requisicao = date('d/m/Y H:i:s', $_SESSION['ultima_requisicao']);

$tempo_sessao_minutos = round($tempo_sessao / 60, 2);

$usuario_cookie = isset($_COOKIE['usuario']) ? $_COOKIE['usuario'] : 'Não disponível';
$data_inicio_cookie = isset($_COOKIE['data_inicio']) ? date('d/m/Y H:i:s', $_COOKIE['data_inicio']) : 'Não disponível';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>
    
    <h2>Informações de Sessão</h2>
    <p><strong>Login (sessão):</strong> <?php echo $_SESSION['usuario']; ?></p>
    <p><strong>Senha (sessão):</strong> <?php echo $_SESSION['senha']; ?></p>
    <p><strong>Data/Hora de Início da Sessão (sessão):</strong> <?php echo $data_inicio; ?></p>
    <p><strong>Data/Hora da Última Requisição (sessão):</strong> <?php echo $data_ultima_requisicao; ?></p>
    <p><strong>Tempo de Sessão:</strong> <?php echo $tempo_sessao_minutos; ?> minutos</p>

    <h2>Informações do Cookie</h2>
    <p><strong>Usuário (cookie):</strong> <?php echo $usuario_cookie; ?></p>
    <p><strong>Data/Hora de Início (cookie):</strong> <?php echo $data_inicio_cookie; ?></p>

    <a href="logout.php">Sair</a>
</body>
</html>
