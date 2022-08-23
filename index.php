<?php
require('db/conexaoDb.php');
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
    <form action="">
        <h1>Login</h1>
        <?php if(isset($_GET['resultado']) && $_GET['resultado']=='Usuário cadastrado com sucesso!'){ echo '<div class="cadastroBemSucedido animate__animated animate__wobble">Usuário cadastrado com sucesso!</div>';} ?>
        <div class="inputGroup">
            <img class='inputIcon' src="img/id-card.png">
            <input type="email" placeholder="Digite seu e-mail">
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/unlock.png">
            <input type="password" placeholder="Digite sua senha">
        </div>
        <button type="submit" class="btn-green">Fazer Login</button>
        <a href="cadastro.php">Não possui cadastro? Clique aqui.</a>
    </form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<?php if(isset($_GET['resultado']) && $_GET['resultado']=='Usuário cadastrado com sucesso!'){?>
    <script>
        setTimeout(() => {
            $('.cadastroBemSucedido').hide();
        }, 3000);
    </script>

<?php } ?>
</body>
</html>