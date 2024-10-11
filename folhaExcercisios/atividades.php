<?php
function somar() {
    $valor1 = 0;
    $valor2 = 0;
    $valor3 = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $valor1 = $_POST["valor1"] ?? 0; 
        $valor2 = $_POST["valor2"] ?? 0; 
        $valor3 = $_POST["valor3"] ?? 0; 
        $soma = $valor1 + $valor2 + $valor3;
        
        if ($valor1 > 10) {
            echo "<h1 style='background-color: lightblue;'>A Soma é " . $soma . "</h1>";
        }
        elseif ($valor2 < $valor3) {
            echo "<h1 style='background-color: lightgreen;'>A Soma é " . $soma . "</h1>";
        }
        elseif ($valor3 < $valor1 && $valor3 < $valor2) {
            echo "<h1 style='background-color: lightcoral;'>A Soma é " . $soma . "</h1>";
        }
        else {
            echo "<h1> A Soma é $soma </h1>";
        }   
    }
}

function divisao() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $div = $_POST["divisao"] ?? 0; 

        if ($div % 2 == 0 && $div <> 0) {   
            echo "<h1> Valor divisível por 2 </h1>";
        } else {
            echo "<h1> O valor não é divisível por 2 </h1>";
        }
}}

function quadrado() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $quadrado = $_POST["quadrado"] ?? 0; 

        echo ("<h1> Área de quadrado é: " . ($quadrado * $quadrado));
        }}

function retangulo() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $retangulo1 = $_POST["retangulo1"] ?? 0; 
        $retangulo2 = $_POST["retangulo2"] ?? 0; 

        echo ('<h1> A área do retângulo de lados de ' . $retangulo1 . ' e '. $retangulo2 . ' metros é ' . ($retangulo1 * $retangulo2) . ' metros quadrados.');
        }}        

function triangulo() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $base = $_POST["base"] ?? 0; 
        $altura = $_POST["altura"] ?? 0; 

        echo ('<h1> A área do triangulo de base: ' . $base . ' e altura: '. $altura . ' é de ' . ($base * $altura)/2 . ' metros quadrados.');
        }}   
        
function joao() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $macaval = 1;
        $melval = 15;
        $larval = 17;
        $repval = 2;
        $cenval = 4;
        $batval = 6;

        $maca = $_POST["maca"] ?? 0; 
        $mel = $_POST["melancia"] ?? 0; 
        $lar = $_POST["laranja"] ?? 0; 
        $rep = $_POST["repolho"] ?? 0; 
        $cen = $_POST["cenoura"] ?? 0; 
        $bat = $_POST["batatinha"] ?? 0;
        
        $total = 50;
        $total = ($total - ($maca * $macaval) - ($lar * $larval) - ($rep * $repval) - ($cen * $cenval) - ($bat * $batval));

        echo ('<h1> saldo do joão ' . $total .'</h1>');
        }}  
        
function maria() {

    $vista = 22500.00; 
    $parcela = 489.65; 

    echo ('<p>valor a vista é '.$vista.'</p>');
    echo ('<p>valor da parcela é '.$parcela.'</p>');
    echo ('<p>todas parcelas é '.($parcela * 60).'</p>');
    echo ('<p>juros é '. ($parcela * 60) - $vista.'</p>');
}       

function paulo() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $vista = 8654.00; 
        $parcela = $_POST["parcela"] ?? 1; 
        $juros = 0;

        if ($parcela > 24) {
            $juros = 1.5;
        }
        elseif ($parcela > 36) {
            $juros = 2.0;
        }
        elseif ($parcela > 48) {
            $juros = 2.5;
        }
        elseif ($parcela > 60) {
            $juros = 3.0;
        }

        $jurosdinheiro = (($vista / $parcela) / 100) * $juros;

        echo '<h1>Valor a vista é '.$vista.', de '.$parcela.' parcelas, temos atualmente '.$juros.' de juros, somando o total de de '.($jurosdinheiro + $vista).' sendo '.$jurosdinheiro.' de juros inteiro</h1>';

    }}
    
    function juca() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $vista = 8654.00; 
            $parcela = $_POST["parcelaComposta"] ?? 1; 
            $jurosBase = 2 / 100; 
            $incremento = 0.003; 

            $jurosTotal = $jurosBase + (($parcela - 24) / 12) * $incremento; 
    
            $montanteTotal = $vista * pow(1 + $jurosTotal, $parcela);
    
            $jurosPagos = $montanteTotal - $vista;
    
            echo '<h1>Valor à vista: R$ ' . $vista .', número de parcelas: ' . $parcela. ', taxa de juros: ' . $jurosTotal. '%, total a pagar: R$ ' . round(($montanteTotal),2) . ', total de juros: R$ ' . round(($jurosPagos),2) .'</h1>';
        }
    }

    function Arvore($pastas = null, $nivel = 0) {
        if ($pastas === null) {
            $pastas = array(
                "bsn" => array(
                    "3a Fase" => array(
                        "desenvWeb",
                        "bancoDados 1",
                        "engSoft 1"
                    ),
                    "4a Fase" => array(
                        "Intro Web",
                        "bancoDados 2",
                        "engSoft 2"
                    )
                )
            );
        }
    
        foreach ($pastas as $pasta => $conteudo) {
            $espacos = str_repeat(' ', $nivel * 2);
            
            if (is_array($conteudo)) {
                echo $espacos . "- " . $pasta . "\n";
        
                Arvore($conteudo, $nivel + 1);
            } else {
                echo $espacos . "-- " . $conteudo . "\n";
            }
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Soma</title>
</head>
<body>
    <h1>Atividade 1<h1>
    <form method="post">
        <fieldset>
            <input type="text" name="valor1">
            <input type="text" name="valor2">
            <input type="text" name="valor3">
            <input type="submit" value="Somar">
        </fieldset>    
    </form>
    <?php
        somar();
    ?>

    <hr>
    <hr>    

    <h1>Atividade 2<h1>

    <form method="post">
        <fieldset>
            <input type="text" name="divisao">
            <input type="submit" value="é divisivel?">
        </fieldset>    
    </form>
    <?php
        divisao(); 
    ?>

    <hr>
    <hr>

    <h1>Atividade 3<h1>

    <form method="post">
        <fieldset>
            <input type="text" name="quadrado">
            <input type="submit" value="calcular quadrado">
        </fieldset>    
    </form>
    <?php
        quadrado()
    ?>

    <hr>
    <hr>

    <h1>Atividade 4<h1>

    <form method="post">
        <fieldset>
           <input type="text" name="retangulo1">
          <input type="text" name="retangulo2">
          <input type="submit" value="calcular retangulo">
      </fieldset>    
    </form>
    <?php
       retangulo();
    ?>

    <hr>
    <hr>
    
    <h1>Atividade 6<h1>

    <form method="post">
        <fieldset>
            <p>João tem 50 reais inicialmente</p><br>

            <p></p>
            <p>O valor da maçã é 1$</p>
            <p>O valor da melancia é 15$</p>
            <p>O valor da laranja é 7$</p>
            <p>O valor da repolho é 2$</p>
            <p>O valor da cenoura é 4$</p>
            <p>O valor da batatinha é 6$</p>

            <label for='maca'>kg comprados da maçã: </label>
            <input type="number" name='maca'>
            <br>
            <label for='melancia'>kg comprados da melancia: </label>
            <input type="number" name='melancia'>
            <br>
            <label for='laranja'>kg comprados da laranja: </label>
            <input type="number" name='laranja'>
            <br>        
            <label for='repolho'>kg comprados do repolho: </label>
            <input type="number" name='repolho'>
            <br>
            <label for='cenoura'>kg comprados da cenoura: </label>
            <input type="number" name='cenoura'>
            <br>
            <label for='batatinha'>kg comprados da batatinha: </label>
            <input type="number" name='batatinha'>

            <input type="submit" value="calcular compra">
      </fieldset>    
    </form>
    <?php
       joao();
    ?>

    <hr>
    <hr>

    <h1>Atividade 7<h1>

    <?php
       maria();
    ?>

    <hr>
    <hr>

    <h1>atividade 8</h1>

    <form method="post">
        <fieldset>
            <p>moto a vista: 8.654,00</p>
           <input type="text" name="parcela">
           <input type="submit" value="calcular parcelas">
      </fieldset>    
    </form>
    <?php
       paulo();
    ?>

    <hr>
    <hr>

    <h1>atividade 9</h1>

    <form method="post">
        <fieldset>
            <p>moto a vista: 8.654,00</p>
           <input type="text" name="parcelaComposta">
           <input type="submit" value="calcular parcelas">
      </fieldset>    
    </form>
    <?php
        juca();
    ?>

    <hr>
    <hr>

    <h1>atividade 10</h1>

    <form method="post">
        <fieldset>
            <p>Saida da array:</p>
            <?php
                arvore();
            ?>
      </fieldset>    
    </form>

    </body>
</html>