<?php

use PHPMailer\PHPMailer\PHPMailer;

require('db/conexaoDb.php');

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['senhaRepet'])){
    if(empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['senhaRepet'])){
        $erroGlobal='Todos os campos são obrigatórios.';
    }else{
        $nome = limpaDado($_POST['nome']);
        $email = limpaDado($_POST['email']);
        $senha = limpaDado($_POST['senha']);
        $senhaCripto = sha1($senha); 
        $senhaRepet = limpaDado($_POST['senhaRepet']);
        $check = limpaDado($_POST['check']);

        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $erroNome = "Permitido apenas letras e espaços.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erroEmail = "E-mail inválido.";
        }

        if(strlen($senha) < 6){
            $erroSenha = "A senha deve conter no mínimo 6 caracteres.";
        }

        if($senha !== $senhaRepet){
            $erroSenhaRepet = "A senhas digitadas não são iguais.";
        }

        if($check!=='ok') {
            $erroCheck = "Aceite os termos de uso.";
        }

        if(!isset($erroNome) && !isset($erroEmail) && !isset($erroSenha) && !isset($erroSenhaRepet) && !isset($erroCheck)){
            $sql = $pdo->prepare("SELECT * FROM usuarios WHERE email=? LIMIT 1");
            $sql->execute(array($email));
            $usuario = $sql->fetch();
            if(!$usuario){
                $recupera_senha = '';
                $token = '';
                $codConfirmacao = uniqid();
                $status = 'novo';
                $dataCadastro = date('d/m/Y');
                $sql = $pdo->prepare("INSERT INTO usuarios VALUES(null, ?,?,?,?,?,?,?,?)");
                if($sql->execute(array($nome,$email,$senhaCripto,$recupera_senha,$token,$codConfirmacao,$status,$dataCadastro))){
                    if($modo=='local'){
                        header('location: index.php?resultado=Usuário cadastrado com sucesso!');
                        //APÓS CADASTRAR EM MODO LOCAL, É NECESSÁRIO TROCAR MANUALMENTE O STATUS PARA CONFIRMADO NO BANCO DE DADOS PARA REALIZAR O LOGIN POSTERIORMENTE.
                    }
                    if($modo=='publico'){
                        $email == new PHPMailer(true);
                        try{
                            $mail->setFrom('sistema@emailsistema.com', 'Sistema de login');
                            $mail->addAddress($email,$nome); 

                            $mail->isHTML(true);                                 
                            $mail->Subject = 'Confirmação de cadastro.';
                            $mail->Body = '<h1>Confirme seu email cadastrado abaixo:</h1><br><br><a style="background:green; color=white; padding:10px; border-radius:10px; text-decoration:none;" href="https:sistema.com.br/confirmacao.php?codConfirmacao='.$codConfirmacao.'">Confirmar E-mail';
                            //MUDE INFORMAÇÕES PARA AS DE SEU SITE ONDE O SISTEMA ESTÁ HOSPEDADO CASO O MODO SEJA PÚBLICO
                            // --->>  https:sistema.com.br
                            // --->>  sistema@emailsistema.com

                            $mail->send();
                            header('location: cadastrado.html');

                        }catch (Exception $e){
                            echo "Houve um problema ao enviar o email de confirmação: {$mail->ErrorInfo}";
                        }
                    }
                }
            }else{
                $erroGlobal = 'Já existe um cadastro com esse e-mail.';
            }
        }
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <title>Sistema de Login</title>
</head>

<body>
    <form method="POST">
        <h1>Cadastro</h1>
        <?php if(isset($erroGlobal)){ ?>
            <div class="erroGlobal animate__animated animate__wobble">
            <?php echo $erroGlobal; ?>
            </div>
        <?php } ?> 
        <div class="inputGroup">
            <img class='inputIcon' src="img/social-media.png">
            <input <?php if(isset($erroGlobal) or isset($erroNome)){echo 'class="erroInput"';} ?> name='nome' type="text" placeholder="Digite seu nome completo" required <?php if(isset($_POST['nome'])){echo "value='".$_POST['nome']."'";} ?>>
            <?php if(isset($erroNome)) {echo '<div class="erro">Insira um nome correto.</div>';} ?>
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/pass.png">
            <input <?php if(isset($erroGlobal) or isset($erroEmail)){echo 'class="erroInput"';} ?> name='email' type="text" placeholder="Digite seu email" required <?php if(isset($_POST['email'])){echo "value='".$_POST['email']."'";} ?>>
            <?php if(isset($erroEmail)) {echo '<div class="erro">Insira um e-mail correto.</div>';} ?>
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/web-browser.png">
            <input <?php if(isset($erroGlobal) or isset($erroSenha)){echo 'class="erroInput"';} ?> name="senha" type="password" placeholder="Digite sua senha" required <?php if(isset($_POST['senha'])){echo "value='".$_POST['senha']."'";} ?>>
            <?php if(isset($erroSenha)) {echo '<div class="erro">Insira uma senha válida.</div>';} ?>
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/password.png">
            <input <?php if(isset($erroGlobal) or isset($erroSenhaRepet)){echo 'class="erroInput"';} ?> name="senhaRepet" type="password" placeholder="Digite sua senha novamente." required <?php if(isset($_POST['senhaRepet'])){echo "value='".$_POST['senhaRepet']."'";} ?>>
            <?php if(isset($erroSenhaRepet)) {echo '<div class="erro">A senha não é a mesma.</div>';} ?>
        </div>
        <div <?php if(isset($erroGlobal) or isset($erroCheck)){echo 'class="inputGroup erroInput"';}else{echo 'class="inputGroup"';}?>>
            <input type="checkbox" name="check" id="check" name="termos" value="ok" required>
            <label for="termos">Você concorda com a <a href="#" class="link">política de privacidade</a> e os <a
                    href="#" class="link">termos de uso?</a></label>
        </div>
        <button type="submit" class="btn-green">Finalizar cadastro</button>
        <a href="index.php">Já possuo uma conta.</a>
    </form>

</body>

</html>