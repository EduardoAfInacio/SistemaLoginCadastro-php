<?php
session_start();
$modo = 'local';


if($modo=='local'){
    $servidor = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'login';

}elseif($modo=='publico'){
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

function autorizacao($tokenSession){
    global $pdo;
    $sql = $pdo->prepare('SELECT * FROM usuarios WHERE token=? LIMIT 1');
    $sql->execute(array($tokenSession));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if(!$usuario){
        return false;
    }else{
        return $usuario;
    }
}
