<?php
require '../bd.php';

$method = $_SERVER['REQUEST_METHOD'];

///////////////// user /////////////////

if ($method === 'GET') {
    $result = pg_query($conn, "SELECT id_usuarios, usuario, data_criacao FROM usuarios");
    if (!$result) {
        echo json_encode(["error" => "Erro ao buscar usuários"]);
        exit;
    }
    $usuarios = pg_fetch_all($result);
    echo json_encode($usuarios);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['usuario'];
    $senha = password_hash($data['senha'], PASSWORD_BCRYPT);

    $query = "INSERT INTO usuarios (usuario, senha, data_criacao) VALUES ('$nome', '$senha', NOW())";
    $result = pg_query($conn, $query);

    echo json_encode(['status' => $result ? 'Usuário criado com sucesso' : 'Erro ao criar usuário']);
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_usuarios'];
    $nome = $data['usuario'];

    $update = pg_prepare($conn, "update_usuario", "UPDATE usuarios SET usuario = $1 WHERE id_usuarios = $2");
    $result = pg_execute($conn, "update_usuario", array($nome, $id));

    if ($result) {
        echo json_encode(['status' => 'Usuário atualizado com sucesso']);
    } else {
        echo json_encode(['error' => pg_last_error($conn)]);
    }
}

if ($method === 'PATCH') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    // Recebe os dados do corpo da requisição
    $id_usuario = isset($data['id_usuario']) ? (int)$data['id_usuario'] : null;
    $nova_senha = isset($data['nova_senha']) ? $data['nova_senha'] : null;

    // Verifica se os dados estão corretos
    if ($id_usuario === null || !is_int($id_usuario) || !$nova_senha) {
        echo json_encode(['error' => 'ID do usuário ou nova senha não fornecidos ou inválidos.']);
        exit;
    }

    // Verificar se o ID do usuário existe no banco de dados
    $getUserQuery = "SELECT usuario FROM usuarios WHERE id_usuarios = $1";
    $result = pg_query_params($conn, $getUserQuery, array($id_usuario));

    // Depuração: Verifique se a consulta retornou um resultado
    if (!$result) {
        echo json_encode(['error' => 'Erro ao verificar o usuário: ' . pg_last_error($conn)]);
        exit;
    }

    // Depuração: Verificar se o resultado foi encontrado
    $row = pg_fetch_assoc($result);
    if (!$row) {
        echo json_encode(['error' => 'Usuário não encontrado. ID fornecido: ' . $id_usuario]);
        exit;
    }

    // Criptografa a nova senha
    $hashedPassword = password_hash($nova_senha, PASSWORD_BCRYPT);

    // Atualiza a senha no banco de dados
    $updateQuery = "UPDATE usuarios SET senha = $1 WHERE id_usuarios = $2";
    $updateResult = pg_query_params($conn, $updateQuery, array($hashedPassword, $id_usuario));

    if ($updateResult) {
        echo json_encode([
            'status' => 'Senha do usuário atualizada com sucesso.',
            'usuario' => $row['usuario']
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar a senha do usuário: ' . pg_last_error($conn)]);
    }
}
?>
