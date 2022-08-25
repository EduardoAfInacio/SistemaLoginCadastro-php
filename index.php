<?php
require('db/conexaoDb.php');

if (isset($_POST['email']) && isset($_POST['senha']) && !empty($_POST['email']) && !empty($_POST['senha'])){
    $erroLogin='Os dois campos são obrigatórios.';
    $email = limpaDado($_POST['email']);
    $senha = limpaDado($_POST['senha']);
    $senhaCripto = sha1($senha);

    $sql = $pdo->prepare('SELECT * FROM usuarios WHERE email=? AND senha=? LIMIT 1');
    $sql->execute(array($email, $senhaCripto));
    $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    if($usuario){
        if($usuario['status']=='confirmado'){
            $token = uniqid().date('d-m-Y-H-i-s');
            $sql = $pdo->prepare('UPDATE usuarios SET token=? WHERE email=? AND senha=?');
            if($sql->execute(array($token, $email, $senhaCripto))){
                $_SESSION['TOKEN'] = $token;
                header('location: pagRestrita.php');
            }
        }else{
            $erroLogin='Confirme seu cadastro pelo e-mail cadastrado.';
        }
    }else{
        $erroLogin='Algum campo está incorreto.';
    }
}
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>
    <form method="POST">
        <h1>Login</h1>
        <?php if(isset($_GET['resultado']) && $_GET['resultado']=='Usuário cadastrado com sucesso!'){ echo '<div class="cadastroBemSucedido animate__animated animate__wobble">Usuário cadastrado com sucesso!</div>';} ?>
        <?php if(isset($_GET['resultadoRecuperacao']) && $_GET['resultadoRecuperacao']=='Senha redefinida com sucesso!'){ echo '<div class="recuperacaoBemSucedida animate__animated animate__wobble">Senha redefinida com sucesso!</div>';} ?>
        <?php if(isset($erroLogin)){ ?>
            <div class="erroGlobal animate__animated animate__wobble">
            <?php echo $erroLogin; ?>
            </div>
        <?php } ?> 

        <div class="inputGroup">
            <img class='inputIcon' src="img/id-card.png">
            <input type="email" name='email' placeholder="Digite seu e-mail" required>
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/unlock.png">
            <input type="password" name='senha' placeholder="Digite sua senha" required>
        </div>
        <a href="esqueciSenha.php">Esqueceu a senha?</a>
        <button type="submit" class="btn-green">Fazer Login</button>
        <a href="cadastro.php">Não possui cadastro?</a>
    </form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php if(isset($_GET['resultado']) && $_GET['resultado']=='Usuário cadastrado com sucesso!'){?>
    <script>
        setTimeout(() => {
            $('.cadastroBemSucedido').hide();
        }, 3000);
    </script>


<?php } ?>
<?php if(isset($_GET['resultadoRecuperacao']) && $_GET['resultadoRecuperacao']=='Senha redefinida com sucesso!'){?>
    <script>
        setTimeout(() => {
            $('.recuperacaoBemSucedida').hide();
        }, 3000);
    </script>

<?php } ?>
</body>
</html>