<?php
header('Content-Type: application/json; charset=utf-8');

include '../bd.php';

$data_hoje = date('Y-m-d');
$mesAtual = date('m');
$anoAtual = date('Y');

$data = [];

function getDataFromQuery($conn, $sql, $key) {
    $result = pg_query($conn, $sql);
    if ($result) {
        $data = [];
        while ($row = pg_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Erro na consulta de $key: " . pg_last_error($conn)]);
        exit();
    }
}

// Consulta de avaliações
$sqlAvaliacoes = "SELECT avaliacoes.id, setores.nome, avaliacoes.data_hora, avaliacoes.resposta, perguntas.pergunta
  	                FROM avaliacoes    
              inner join setores on avaliacoes.id_setor = setores.id_setor
              inner join perguntas on avaliacoes.id_pergunta = perguntas.id_perguntas";

$data['avaliacoes'] = getDataFromQuery($conn, $sqlAvaliacoes, 'avaliações');

// Fechar a conexão
pg_close($conn);

if (empty($data)) {
    http_response_code(404);
    echo json_encode(["message" => "Nenhum dado encontrado"]);
} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}
?>
