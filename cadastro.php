<?php
require('db/conexaoDb.php');

if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['senhaRepet'])){
    if(empty($_POST['nome']) or empty($_POST['email']) or empty($_POST['senha']) or empty($_POST['senhaRepet'])){
        $erroGlobal='Todos os campos são obrigatórios.';
    }else{
        $nome = limpaDado($_POST['nome']);
        $email = limpaDado($_POST['email']);
        $senha = limpaDado($_POST['senha']);
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
            //checar banco e inserir no mesmo logo após...
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
        <button type="submit" class="btn-green">Realizar cadastro</button>
        <a href="index.php">Já possuo uma conta.</a>
    </form>

</body>

</html>