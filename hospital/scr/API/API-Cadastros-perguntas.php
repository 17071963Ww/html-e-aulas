<?php
require '../bd.php';

$method = $_SERVER['REQUEST_METHOD'];

///////////////// perguntas /////////////////

if ($method === 'GET') {
    $result = pg_query($conn, "SELECT id_perguntas, pergunta, status, tipo FROM perguntas");
    if (!$result) {
        echo json_encode(["error" => "Erro ao buscar perguntas"]);
        exit;
    }
    $perguntas = pg_fetch_all($result);
    echo json_encode($perguntas);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $pergunta = $data['pergunta'];
    $tipo = $data['tipo'];

    $query = "INSERT INTO perguntas (pergunta, tipo, status) VALUES ('$pergunta', '$tipo', 'ativa')";
    $result = pg_query($conn, $query);

    echo json_encode(['status' => $result ? 'Pergunta criada com sucesso' : 'Erro ao criar pergunta']);
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_perguntas'];
    $pergunta = $data['pergunta'];

    $update = "UPDATE perguntas SET pergunta = '$pergunta' WHERE id_perguntas = $id";
    $result = pg_query($conn, $update);

    echo json_encode(['status' => $result ? 'Pergunta atualizada com sucesso' : 'Erro ao atualizar pergunta']);
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_perguntas'];

    $result = pg_query($conn, "DELETE FROM perguntas WHERE id_perguntas = $id");

    echo json_encode(['status' => $result ? 'Pergunta excluída com sucesso' : 'Erro ao excluir pergunta']);
}

if ($method === 'PATCH') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    // Pegando o id_pergunta da requisição
    $id = isset($data['id_perguntas']) ? (int)$data['id_perguntas'] : null;  

    // Verificando se o id é válido
    if ($id === null || !is_int($id)) {
        echo json_encode(['error' => 'ID da pergunta não fornecido ou inválido.']);
        exit;
    }

    // Consulta para verificar a pergunta
    $getPerguntaQuery = "SELECT pergunta, status FROM perguntas WHERE id_perguntas = $1";
    $result = pg_query_params($conn, $getPerguntaQuery, array($id)); 

    // Se a consulta falhar, retorna erro
    if (!$result) {
        echo json_encode(['error' => 'Erro ao verificar a pergunta: ' . pg_last_error($conn)]);
        exit;
    }

    // Verificando se a pergunta foi encontrada
    $row = pg_fetch_assoc($result);
    if (!$row) {
        echo json_encode(['error' => 'Pergunta não encontrada.']);
        exit;
    }

    // Status atual da pergunta
    $currentStatus = $row['status'];
    // Alterando o status
    $newStatus = ($currentStatus === 'ativo') ? 'inativo' : 'ativo';

    // Atualizando o status da pergunta
    $updateQuery = "UPDATE perguntas SET status = $1 WHERE id_perguntas = $2";
    $updateResult = pg_query_params($conn, $updateQuery, array($newStatus, $id)); 

    // Se a atualização for bem-sucedida, retorna a resposta
    if ($updateResult) {
        echo json_encode([
            'status' => 'Status da pergunta atualizado com sucesso.',
            'pergunta' => $row['pergunta'],
            'novo_status' => $newStatus  // Retorna o novo status
        ]);
    } else {
        echo json_encode(['error' => 'Erro ao atualizar o status da pergunta: ' . pg_last_error($conn)]);
    }
}

?>
