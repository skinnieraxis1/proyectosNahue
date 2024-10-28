<?php  
    session_start();
    if($_SESSION["cliente"] == ""){
        header("location: http://localhost/proyectoBanco/login.php");
    }
    include("conexion.php");
    /*
    #cerrar sesion despues de 30 segundos sin actividad
    $timeout_duration = 30;
    if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration) {
        session_unset(); 
        session_destroy();   
        echo "Sesión cerrada por inactividad.";
        }
    }*/

// Actualizar el tiempo de la última actividad
$_SESSION['LAST_ACTIVITY'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User data</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
        <pre style="margin-left: 25%; margin-right: 30%">
 ________  ________        ___  ________          ________  _______           ________  ___  ___  ________  ________  ________  ________     
|\   ____\|\   __  \      |\  \|\   __  \        |\   ___ \|\  ___ \         |\   __  \|\  \|\  \|\   __  \|\   __  \|\   __  \|\   __  \    
\ \  \___|\ \  \|\  \     \ \  \ \  \|\  \       \ \  \_|\ \ \   __/|        \ \  \|\  \ \  \\\  \ \  \|\  \ \  \|\  \ \  \|\  \ \  \|\  \   
 \ \  \    \ \   __  \  __ \ \  \ \   __  \       \ \  \ \\ \ \  \_|/__       \ \   __  \ \   __  \ \  \\\  \ \   _  _\ \   _  _\ \  \\\  \  
  \ \  \____\ \  \ \  \|\  \\_\  \ \  \ \  \       \ \  \_\\ \ \  \_|\ \       \ \  \ \  \ \  \ \  \ \  \\\  \ \  \\  \\ \  \\  \\ \  \\\  \ 
   \ \_______\ \__\ \__\ \________\ \__\ \__\       \ \_______\ \_______\       \ \__\ \__\ \__\ \__\ \_______\ \__\\ _\\ \__\\ _\\ \_______\
    \|_______|\|__|\|__|\|________|\|__|\|__|        \|_______|\|_______|        \|__|\|__|\|__|\|__|\|_______|\|__|\|__|\|__|\|__|\|_______|
        </pre>
        <div class="usuario">
            <button onclick="location.href='./agregarSaldo.php'"></button>
            <button onclick="location.href='./agregarSaldo.php'"></button>
            <button onclick="location.href='./agregarSaldo.php'"></button>
            <button onclick="location.href='./agregarSaldo.php'"></button>
        </div>
</body>

<script>

</script>

<style>

@font-face {
    font-family: 'IBM';
    src: url("./assets/font/Px437_IBM_VGA_8x16.ttf");
    font-weight: normal;
    font-style: normal;
}

body{
    background-color: #212226 ;
    font-family: 'IBM' ; 
    color: #41FF00;
}

input{
    background-color: #212226;
    border: 0px;
    color: #41FF00;
    outline: none;
    outline-offset: none;
    margin-left: 10px;
}

input:focus{
    border: 0px black solid !important;
    outline: none;
    outline-offset: none;
}

.inputDiv{
    display:flex;
    padding: 0% 0%;
}

.usuario{
    font-size: 20px;
}
</style>
</html>