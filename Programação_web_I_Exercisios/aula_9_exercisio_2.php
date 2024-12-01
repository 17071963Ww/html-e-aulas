<?php
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

foreach($pastas["bsn"] as $fase => $disciplinas) {
    echo $fase . ":<br>";  
    foreach($disciplinas as $disciplina) {
        echo "--" . $disciplina . "<br>";  
    }
}
?>
