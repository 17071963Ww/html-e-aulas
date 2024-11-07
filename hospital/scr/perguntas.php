<?php
header('Content-Type: application/json');

include 'bd.php';

$sql = "SELECT id_perguntas, pergunta, tipo FROM perguntas where status = 'ativa' "; 
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
?>
