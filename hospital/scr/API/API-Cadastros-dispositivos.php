<?php
require '../bd.php';

$method = $_SERVER['REQUEST_METHOD'];

///////////////// dispositivos /////////////////

if ($method === 'GET') {
    $result = pg_query($conn, "SELECT id_dispositivos, nome_dispositivo, status FROM dispositivos");
    if (!$result) {
        echo json_encode(["error" => "Erro ao buscar dispositivos"]);
        exit;
    }
    $dispositivos = pg_fetch_all($result);
    echo json_encode($dispositivos);
}

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = $data['nome'];

    $query = "INSERT INTO dispositivos (nome_dispositivo, status) VALUES ('$nome', 'ativo')";
    $result = pg_query($conn, $query);

    echo json_encode(['status' => $result ? 'Dispositivo criado com sucesso' : 'Erro ao criar dispositivo']);
}

if ($method === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_dispositivos'];
    $nome = $data['nome_dispositivo'];

    $update = "UPDATE dispositivos SET nome_dispositivo = '$nome' WHERE id_dispositivos = $id";
    $result = pg_query($conn, $update);

    echo json_encode(['status' => $result ? 'Dispositivo atualizado com sucesso' : 'Erro ao atualizar dispositivo']);
}

if ($method === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id_dispositivos'];

    $result = pg_query($conn, "DELETE FROM dispositivos WHERE id_dispositivos = $id");

    echo json_encode(['status' => $result ? 'Dispositivo excluído com sucesso' : 'Erro ao excluir dispositivo']);
}


?>
