<?php
include 'bd.php'; 

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true); 
    if ($data === null) {
        echo json_encode(['success' => false, 'message' => 'Erro ao decodificar JSON']);
        exit();
    }
    
    $user = $data['user']; 
    $senha = $data['password'];

    if ($user === null || $senha === null) {
        echo json_encode(['success' => false, 'message' => 'Usuário e senha são obrigatórios']);
        exit();
    }

    // Consulta para buscar o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE usuario = $1";
    $result = pg_query_params($conn, $sql, array($user));

    if ($result === false) {
        echo json_encode(['success' => false, 'message' => 'Erro na consulta ao banco de dados']);
        exit();
    }

    if (pg_num_rows($result) > 0) {
        $usuario = pg_fetch_assoc($result);

        // Verifica se a senha está correta
        if (password_verify($senha, $usuario['senha'])) {
            session_start();
            
            // Armazenando o ID e o nome do usuário na sessão
            $_SESSION['usuario_id'] = $usuario['id_usuarios'];
            $_SESSION['usuario_nome'] = $usuario['usuario']; // Armazenando o nome do usuário

            // Retorna a resposta de sucesso e a página para redirecionamento
            echo json_encode(['success' => true, 'redirect' => 'admin-home.php']);
            exit();
        } else {
            echo json_encode(['success' => false, 'message' => 'Usuário ou senha inválidos']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Usuário ou senha inválidos']);
        exit();
    }

    pg_close($conn); 
}
?>
