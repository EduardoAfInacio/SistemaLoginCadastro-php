<?php
require('db/conexaoDb.php');

if(isset($_GET['codRecuperacao']) && (!empty($_GET['codRecuperacao']))){
    if(isset($_POST['novaSenha']) && isset($_POST['novaSenhaRepet']) && !empty($_POST['novaSenha']) && !empty($_POST['novaSenhaRepet'])){
        $codRecuperacao = $_GET['codRecuperacao'];
        $novaSenha = limpaDado($_POST['novaSenha']);
        $novaSenhaRepet = limpaDado($_POST['novaSenhaRepet']);
        $codNovaSenha = sha1($novaSenha);

        if(strlen($novaSenha) < 6){
            $erroNovaSenha = "A senha deve conter no mínimo 6 caracteres.";
        }

        if($novaSenha !== $novaSenhaRepet){
            $erroNovaSenhaRepet = "A senhas digitadas não são iguais.";
        }

        if(!isset($erroNovaSenha) && !isset($erroNovaSenhaRepet)){
            $sql = $pdo->prepare('SELECT usuarios WHERE recupera_senha=? LIMIT 1');
            $sql->execute(array($codRecuperacao));
            $usuario = $sql->fetch(PDO::FETCH_ASSOC);
            if($usuario){
                $sql = $pdo->prepare('UPDATE usuarios SET senha=? WHERE recupera_senha=?');
                $sql->execute(array($codNovaSenha, $codRecuperacao));
                header('location: index.php?resultadoRecuperacao=Senha redefinida com sucesso!');

            }else{
                echo 'Recuperação de senha inválida.';
            }
        }


    }else{
        $erroRedefinirSenha = 'Preencha os campos corretamente.';
    }

}else{
    header('location: index.php');
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueci minha senha</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body>
    <form method="POST">
        <h1>Redefinir senha</h1>
        <?php if (isset($erroRedefinirSenha)) { ?>
            <div class="erroGlobal animate__animated animate__wobble">
                <?php echo $erroRedefinirSenha; ?>
            </div>
        <?php } ?>

        <div class="inputGroup">
            <img class='inputIcon' src="img/web-browser.png">
            <input <?php if(isset($erroRedefinirSenha) or isset($erroNovaSenha)){echo 'class="erroInput"';}?> type="password" name='novaSenha' placeholder="Digite sua nova senha." required>
            <?php if(isset($erroNovaSenha)) {echo '<div class="erro">Senha com no mínimo 6 digitos.</div>';} ?>
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/password.png">
            <input <?php if(isset($erroRedefinirSenha) or isset($erroNovaSenhaRepet)){echo 'class="erroInput"';}?> type="password" name='novaSenhaRepet' placeholder="Digite novamente sua nova senha." required>
            <?php if(isset($erroNovaSenhaRepet)) {echo '<div class="erro">Senha digitada não é a mesma.</div>';} ?>
        </div>
        <button type="submit" class="btn-green">Redefinir senha.</button>
        <a href="index.php">Já lembrou a senha? Volte para o login.</a>
    </form>

</body>

</html>