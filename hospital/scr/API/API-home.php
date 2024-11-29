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

// Consulta de ultimas 9 avaliações
$sqlAvaliacoes = "SELECT avaliacoes.id AS id, setores.nome AS setor, TO_CHAR(avaliacoes.data_hora, 'HH24:MI:SS') AS hora, avaliacoes.resposta AS resposta, perguntas.pergunta AS pergunta
                    FROM avaliacoes
              INNER JOIN setores ON avaliacoes.id_setor = setores.id_setor
              INNER JOIN perguntas ON avaliacoes.id_pergunta = perguntas.id_perguntas
                ORDER BY avaliacoes.data_hora DESC
                   LIMIT 9;";

$data['avaliacoes_new'] = getDataFromQuery($conn, $sqlAvaliacoes, 'avaliações_new');

// Consulta de perguntas
$sqlPerguntas = "SELECT * FROM perguntas";
$data['perguntas'] = getDataFromQuery($conn, $sqlPerguntas, 'perguntas');

// Consulta de dispositivos
$sqlDispositivos = "SELECT * FROM dispositivos";
$data['dispositivos'] = getDataFromQuery($conn, $sqlDispositivos, 'dispositivos');

// Consultas para as avaliações positivas e negativas
$sqlAvaliacoesp = "SELECT count(resposta) AS AvaliacoesPositivas_total
                     FROM avaliacoes
                    WHERE resposta ~ '^\d+$'  
                      AND resposta::int > 5   
                 AND DATE(data_hora) = '$data_hoje'";

$data['avaliacoes_positivas'] = getDataFromQuery($conn, $sqlAvaliacoesp, 'avaliações positivas');

$sqlAvaliacoesn = "SELECT count(resposta) AS AvaliacoesNegativas_total
                     FROM avaliacoes
                    WHERE resposta ~ '^\d+$'  
                      AND resposta::int <= 5   
                      AND DATE(data_hora) = '$data_hoje'
";
$data['avaliacoes_negativas'] = getDataFromQuery($conn, $sqlAvaliacoesn, 'avaliações negativas');

// Total de avaliações
$sqlAvaliacoes = "SELECT count(resposta) AS Avaliacoes_totall
                    FROM avaliacoes
                   WHERE resposta ~ '^\d+$'  
                     AND DATE(data_hora) = '$data_hoje'";

$data['avaliacoes_total'] = getDataFromQuery($conn, $sqlAvaliacoes, 'Avaliacoes_total');

// Total de setores
$sqlTotalSetores = "SELECT COUNT(DISTINCT id_setor) AS total_setores FROM avaliacoes";
$data['total_setores'] = getDataFromQuery($conn, $sqlTotalSetores, 'setores');

// Média de setores por mês
$sqlSetoresMes = "SELECT setores.nome AS setor, EXTRACT(MONTH FROM avaliacoes.data_hora) AS mes, EXTRACT(YEAR FROM avaliacoes.data_hora) AS ano,
                         AVG(avaliacoes.resposta::int) AS media_resposta,
                         COUNT(avaliacoes.id) AS total_avaliacoes
                    FROM avaliacoes
              INNER JOIN setores ON avaliacoes.id_setor = setores.id_setor
                   WHERE avaliacoes.resposta ~ '^\d+$'
                GROUP BY setores.nome, mes, ano
                ORDER BY ano, mes, setor;";

$data['media_setores_mes'] = getDataFromQuery($conn, $sqlSetoresMes, 'média de setores por mês');

$sqlMaiorMediaMesAtual = "SELECT setores.nome AS setor, AVG(avaliacoes.resposta::int) AS media_resposta
                            FROM avaliacoes
                      INNER JOIN setores ON avaliacoes.id_setor = setores.id_setor
                           WHERE EXTRACT(MONTH FROM avaliacoes.data_hora) = '$mesAtual' 
                             AND EXTRACT(YEAR FROM avaliacoes.data_hora) = '$anoAtual'
                             AND avaliacoes.resposta ~ '^\d+$'
                        GROUP BY setores.nome
                        ORDER BY media_resposta DESC
                           LIMIT 1;";

$data['setor_maior_media_mes_atual'] = getDataFromQuery($conn, $sqlMaiorMediaMesAtual, 'setor com maior média do mês atual');

// Fechar a conexão
pg_close($conn);

if (empty($data)) {
    http_response_code(404);
    echo json_encode(["message" => "Nenhum dado encontrado"]);
} else {
    echo json_encode($data, JSON_PRETTY_PRINT);
}
?>
