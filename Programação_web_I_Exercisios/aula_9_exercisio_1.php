<?php
$notas = [8, 3, 9, 2, 7];  
$faltas = [1, 0, 1, 1, 0];        

function Media($notas) {
    $soma = array_sum($notas);  
    $qtdNotas = count($notas);  
    return $soma / $qtdNotas;  
}

function aprovacao($media) {
    if ($media >= 7) {
        return "Aprovado";
    } else {
        return "Reprovado";
    }
}

function Frequencia($faltas) {
    $totalFaltas = array_sum($faltas); 
    $Aulas = count($faltas);  
    return (($Aulas - $totalFaltas) / $Aulas) * 100; 
}

function AprovacaoFrequencia($frequencia) {
    if ($frequencia >= 70) {
        return "Aprovado na Frequência";
    } else {
        return "Reprovado na Frequência";
    }
}


$media = Media($notas); 
$statusNota = aprovacao($media);  

$frequencia = Frequencia($faltas); 
$statusFrequencia = AprovacaoFrequencia($frequencia); 


echo "Média das Notas: " . $media . "<br>";
echo $statusNota . "<br>";
echo "Frequência: " . $frequencia . "%<br>";
echo $statusFrequencia . "<br>";

?>
