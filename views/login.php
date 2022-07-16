<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar Sesion</title>
</head>

<?php 
    include_once '../helpers/session_helper.php';
?>

<body>
    <div class="login-container">
        <div class="image-container">
            <img src="icons/logo.png" width="300" height="150px">
            <img src="icons/CsLogo.png" width="170" height="150px">
            <p>Tasti es un intermediario para reunir a estudiantes de Ciencia de la Computación: si un estudiante tiene dificultades para aprender sobre un tema específico puede postearlo en nuestro foro y si otro estudiante tiene conocimientos de ese tema
                puede hacerle un reforzamiento por medio de una conferencia enlace meet, además de permitir a otros estudiantes con dudas similares permitir unirse a la presente explicación.</p>
        </div>
        <div class="login-info-container">
            <h1 class="title">Iniciar Sesión</h1>
            <?php flash('login') ?>
            <form class="inputs-container" method="post" action="../controllers/usuario.php">
                <input type="hidden" name="type" value="login">
                <input class="input" name="email" type="text" placeholder="Ingresar correo institucional">
                <input class="input" type="password" name="usersPwd" placeholder="Ingresar contraseña">
                <button class="btn" type="submit" name="submit">Iniciar Sesión</button>
                <p>¿No tienes cuenta?<a class="a" href="signup.php">Registrate</a></p>
                <img src="icons/login.svg" width="300" height="400px">
            </form>
        </div>
    </div>

</body>

</html>