<?php
require('db/conexaoDb.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'db/PHPMailer/src/Exception.php';
require 'db/PHPMailer/src/PHPMailer.php';
require 'db/PHPMailer/src/SMTP.php';

if(isset($_POST['email']) && !empty($_POST['email'])){
    $email = limpaDado($_POST['email']);
    $status ='confirmado';
    $sql = $pdo->prepare('SELECT * FROM usuarios WHERE email=? AND status=? LIMIT 1');
    $sql->execute(array($email,$status));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        $nome = $usuario['nome'];
        $codRecuperacao = sha1(uniqid());
        $sql = $pdo->prepare('UPDATE usuarios SET recupera_senha=? WHERE email=?');
        if($sql->execute(array($codRecuperacao, $email))){
            $mail = new PHPMailer(true);
            try{
                $mail->setFrom('sistema@emailsistema.com', 'Sistema de login');
                $mail->addAddress($email,$nome); 
        
                $mail->isHTML(true);                                 
                $mail->Subject = 'Recuperação de senha.';
                $mail->Body = '<h1>Redefina sua senha clicando no botão abaixo:</h1><br><br><a style="background:green; color=white; padding:10px; border-radius:10px; text-decoration:none;" href="https:sistema.com.br/redefinirSenha.php?codRecuperacao='.$codRecuperacao.'">Recuperar senha.';
                //MUDE INFORMAÇÕES PARA AS DE SEU SITE ONDE O SISTEMA ESTÁ HOSPEDADO CASO O MODO SEJA PÚBLICO
                // --->>  https:sistema.com.br
                // --->>  sistema@emailsistema.com
                $mail->send();
                header('location:emailRecuperaEnviado.html');
            }catch(Exception $e){
                $erroEsqueci = 'Erro ao enviar o e-mail.';
            }
        }
    }else{
        $erroEsqueci = 'Email não encontrado';
    }
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
        <h1>Recuperar senha</h1>
        <?php if (isset($erroEsqueci)) { ?>
            <div class="erroGlobal animate__animated animate__wobble">
                <?php echo $erroEsqueci; ?>
            </div>
        <?php } ?>

        <div class="inputGroup">
            <img class='inputIcon' src="img/id-card.png">
            <input type="email" name='email' placeholder="Digite seu e-mail cadastrado." required>
        </div>
        <button type="submit" class="btn-green">Enviar e-mail</button>
        <a href="index.php">Já lembrou a senha? Volte para o login.</a>
    </form>

</body>

</html>