<?php
header('Content-Type: application/json');
include 'bd.php';

$sql = "SELECT * FROM sua_tabela"; 
$result = pg_query($conn, $sql);

$dados = array();

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $dados[] = $row;
    }
}

echo json_encode($dados);

pg_close($conn);
?>
