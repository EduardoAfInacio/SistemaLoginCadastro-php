<?php
require('db/conexaoDb.php');
?><link rel="stylesheet" href="style.css">
<?php
$usuarioSession = autorizacao($_SESSION['TOKEN']);
if($usuarioSession){
    echo "<h1> Login realizado com sucesso! Bem vindo <b style='color:green'>" . $usuarioSession['nome'] ."!</b></h1>";
    echo "<a href='logout.php' style='background:green; color=white; padding:10px; border-radius:10px; text-decoration:none;'> Logout </a>";
}else{
    header('location: index.php'); 
}

