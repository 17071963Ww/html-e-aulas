<?php
require '../bd.php';

$method = $_SERVER['REQUEST_METHOD'];

///////////////// setores /////////////////

if ($method === 'GET') {
    $result = pg_query($conn, "SELECT id_setor, nome, status FROM setores");
    if (!$result) {
        echo json_encode(["error" => "Erro ao buscar setores"]);
        exit;
    }
    $setores = pg_fetch_all($result);
    echo json_encode($setores);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['nome'];

    $query = "INSERT INTO setores (nome, status) VALUES ('$nome', 'ativo')";
    $result = pg_query($conn, $query);

    echo json_encode(['status' => $result ? 'Setor criado com sucesso' : 'Erro ao criar setor']);
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_setor'];
    $nome = $data['nome'];

    $update = "UPDATE setores SET nome = '$nome' WHERE id_setor = $id";
    $result = pg_query($conn, $update);

    echo json_encode(['status' => $result ? 'Setor atualizado com sucesso' : 'Erro ao atualizar setor']);
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_setor'];

    $result = pg_query($conn, "DELETE FROM setores WHERE id_setor = $id");

    echo json_encode(['status' => $result ? 'Setor excluído com sucesso' : 'Erro ao excluir setor']);
}

if ($method === 'PATCH') {
    header('Content-Type: application/json');
    $data = json_decode(file_get_contents('php://input'), true);

    $id = $data['id_setor'] ?? null;
    $status = $data['status'] ?? null;

    if (!$id || !$status) {
        echo json_encode(['error' => 'ID ou status ausente']);
        exit;
    }

    $update = pg_prepare($conn, "update_status", "UPDATE setores SET status = $1 WHERE id_setor = $2");
    $result = pg_execute($conn, "update_status", array($status, $id));

    if ($result && pg_affected_rows($result) > 0) {
        echo json_encode(['status' => 'Status do setor atualizado com sucesso']);
    } else {
        echo json_encode(['error' => pg_last_error($conn)]);
    }
}


?>
