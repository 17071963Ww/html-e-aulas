<?php
header('Content-Type: application/json');
include 'bd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebe as respostas enviadas via POST
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Verifica se os dados foram recebidos corretamente
    if (isset($data['respostas']) && isset($data['user_id'])) {
        $respostas = $data['respostas'];
        $user_id = $data['user_id'];

        // Inicia a transação para garantir a integridade dos dados
        pg_query($conn, "BEGIN");

        // Loop para inserir as respostas na tabela de avaliação
        foreach ($respostas as $resposta) {
            // Certifique-se de que cada resposta tem o id_pergunta e o valor da resposta
            if (isset($resposta['id_pergunta']) && isset($resposta['resposta'])) {
                $id_pergunta = $resposta['id_pergunta'];
                $resposta_texto = $resposta['resposta'];

                // Query para inserir a resposta na tabela de avaliação
                $query = "INSERT INTO avaliation (user_id, id_pergunta, resposta, data_resposta) 
                          VALUES ($1, $2, $3, NOW())";
                $result = pg_query_params($conn, $query, array($user_id, $id_pergunta, $resposta_texto));

                if (!$result) {
                    // Caso ocorra um erro, faz o rollback da transação
                    pg_query($conn, "ROLLBACK");
                    echo json_encode(['error' => 'Erro ao inserir respostas: ' . pg_last_error($conn)]);
                    exit;
                }
            }
        }

        // Se não houve erro, confirma a transação
        pg_query($conn, "COMMIT");

        echo json_encode(['status' => 'Respostas enviadas com sucesso']);
    } else {
        echo json_encode(['error' => 'Dados inválidos ou faltando']);
    }
} else {
    // Se for uma requisição GET, retorna as perguntas
    $sql = "SELECT id_perguntas, pergunta, tipo FROM perguntas WHERE status = 'ativa'"; 
    $result = pg_query($conn, $sql);

    $perguntas = [];
    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $perguntas[] = $row;
        }

        if (empty($perguntas)) {
            http_response_code(404); 
            echo json_encode(["message" => "Nenhuma pergunta encontrada"]);
            exit();
        }
    } else {
        http_response_code(500); 
        echo json_encode(["message" => "Erro na consulta: " . pg_last_error($conn)]);
        exit();
    }

    pg_close($conn); 
    echo json_encode($perguntas);  
}
?>
