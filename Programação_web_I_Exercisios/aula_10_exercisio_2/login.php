<?php
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: main.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];


    if ($usuario == 'admin' && $senha == 'admin') {
        
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;
        $_SESSION['data_inicio'] = time(); 
        $_SESSION['ultima_requisicao'] = time();

        setcookie('usuario', $usuario, time() + 60 * 5, "/");
        setcookie('data_inicio', $_SESSION['data_inicio'], time() + 60 * 5, "/");

        header("Location: main.php");
        exit();
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login </title>
</head>
<body>
    <h1>Login - user: admin | admin</h1>
    <form method="POST">
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <button type="submit">Entrar</button>
    </form>

    <?php if (isset($erro)) { echo "<p style='color: red;'>$erro</p>"; } ?>
</body>
</html>
