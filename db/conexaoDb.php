<?php

$modo = 'local';

if($modo=='local'){
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'login';

}elseif($modo=='producao'){
    $servidor ='';
    $usuario = '';
    $senha = '';
    $banco = '';

}

try{
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco",$usuario,$senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $erro){
    echo "A conexão com o banco falhou.";

}

function limpaDado($dado){
    $dado = trim($dado);
    $dado = stripslashes($dado);
    $dado = htmlspecialchars($dado);
    return $dado;
}