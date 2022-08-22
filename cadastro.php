<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Login</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <form action="">
        <h1>Cadastro</h1>
        <div class="inputGroup">
            <img class='inputIcon' src="img/social-media.png">
            <input type="text" placeholder="Digite seu nome completo">
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/pass.png">
            <input type="text" placeholder="Digite seu email">
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/web-browser.png">
            <input type="password" placeholder="Digite sua senha">
        </div>
        <div class="inputGroup">
            <img class='inputIcon' src="img/password.png">
            <input type="password" placeholder="Digite sua senha novamente.">
        </div>
        <div class="inputGroup">
            <input type="checkbox" id="termos" name="termos" value="ok">
            <label for="termos">Você concorda com a <a href="#" class="link">política de privacidade</a> e os <a href="#" class="link">termos de uso?</a></label>
        </div>
        <button type="submit" class="btn-green">Realizar cadastro</button>
        <a href="login.html">Já possuo uma conta.</a>
    </form>
    
</body>
</html>