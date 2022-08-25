<?php
require('db/conexaoDb.php');
if(isset($_GET['codConfirmacao']) && (!empty($_GET['codConfirmacao']))){
    $codigo = limpaDado($_GET['codConfirmacao']);

    $sql = $pdo->prepare('SELECT * FROM usuarios WHERE $codigo=? LIMIT 1');
    $sql->execute(array($codigo));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $status ='confirmado';
        $sql = $pdo->prepare('UPDATE usuarios SET status=? WHERE $codigo=?');
        if($sql->execute(array($status, $codigo))){
            header('location: index.php');
        }
    }else{
        echo "<h1>Código de confirmação inválido.</h1>";
    }
}else{
    header('location: index.php');
}
?>