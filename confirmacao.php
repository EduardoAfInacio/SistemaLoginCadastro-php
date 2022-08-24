<?php
require('db/conexaoDb.php');
if(isset($_GET['codConfirmacao']) && (!empty($_GET['codConfirmacao']))){
    $codigo = limpaDado($codigo);

    $sql = $pdo->prepare('SELECT * FROM usuarios WHERE codigo_confirmacao=? LIMIT 1');
    $sql->execute(array($codigo));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $status ='confirmado';
        $sql = $pdo->prepare('UPDATE usuarios SET status=? WHERE codigo_confirmacao=?');
        if($sql->execute(array($status, $codigo))){
            header('location: index.php');
        }
    }else{
        echo "<h1>Código de confirmação inválido.</h1>";
    }
}
?>