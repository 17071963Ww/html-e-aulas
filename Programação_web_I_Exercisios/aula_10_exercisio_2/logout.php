<?php
session_start();
session_unset(); 
session_destroy(); 

setcookie('usuario', '', time() - 3600, "/");
setcookie('data_inicio', '', time() - 3600, "/");

header("Location: login.php");
exit();
?>
