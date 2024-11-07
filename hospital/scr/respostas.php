<?php

include 'bd.php';

$meuArray = json_decode($_POST['avaliation'], true);

//$sql = "INSERT INTO perguntas ()"; 
//pg_query($conn, $sql);

foreach ($meuArray as $valor) {
    echo $valor . '<br>';
}
?>