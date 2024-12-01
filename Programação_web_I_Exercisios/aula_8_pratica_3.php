<?php
$SALARIO1 = 1000; 
$SALARIO2 = 2000; 

$SALARIO2 = $SALARIO1;

$SALARIO2++;

$AUMENTO = ($SALARIO1 / 100) * 10;
$SALARIO1 = $SALARIO1 + $AUMENTO;

if ($SALARIO1 > $SALARIO2) {
    echo "O Valor da variável SALARIO1 é maior que o valor da variável SALARIO2";
} elseif ($SALARIO1 < $SALARIO2) {
    echo "O Valor da variável SALARIO1 é menor que o valor da variável SALARIO2";
} else {
    echo "Os valores são iguais";
}
?>
