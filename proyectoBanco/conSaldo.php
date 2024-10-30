<?php
session_start();
if (empty($_SESSION["cliente"])) {
    header("location: http://localhost/proyectoNahue/login.php");
    exit(); // Asegúrate de salir después de redirigir
}
include("conexion.php");
?>

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

    .buttonDiv{
        display:flex;
        justify-content: space-between;
        padding: 10svh;
    }

    button{
        background-color: #212226;
        color: #41FF00;
        border: #41FF00 1px solid;
        border-radius: 0px;
        padding: 10px 20px;
        font-family: 'IBM' ; 
    }

</style>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Saldo</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
    <pre>
 ________  ________  ________   ________  ___  ___  ___   _________  ________  ________          ________  ________  ___       ________  ________     
|\   ____\|\   __  \|\   ___  \|\   ____\|\  \|\  \|\  \ |\___   ___\\   __  \|\   __  \        |\   ____\|\   __  \|\  \     |\   ___ \|\   __  \    
\ \  \___|\ \  \|\  \ \  \\ \  \ \  \___|\ \  \\\  \ \  \\|___ \  \_\ \  \|\  \ \  \|\  \       \ \  \___|\ \  \|\  \ \  \    \ \  \_|\ \ \  \|\  \   
 \ \  \    \ \  \\\  \ \  \\ \  \ \_____  \ \  \\\  \ \  \    \ \  \ \ \   __  \ \   _  _\       \ \_____  \ \   __  \ \  \    \ \  \ \\ \ \  \\\  \  
  \ \  \____\ \  \\\  \ \  \\ \  \|____|\  \ \  \\\  \ \  \____\ \  \ \ \  \ \  \ \  \\  \|       \|____|\  \ \  \ \  \ \  \____\ \  \_\\ \ \  \\\  \ 
   \ \_______\ \_______\ \__\\ \__\____\_\  \ \_______\ \_______\ \__\ \ \__\ \__\ \__\\ _\         ____\_\  \ \__\ \__\ \_______\ \_______\ \_______\
    \|_______|\|_______|\|__| \|__|\_________\|_______|\|_______|\|__|  \|__|\|__|\|__|\|__|       |\_________\|__|\|__|\|_______|\|_______|\|_______|
                                  \|_________|                                                     \|_________|
    </pre>

    <h2>Saldo: 
    <?php 
    $stmt = $link->prepare("SELECT saldo FROM cajaDeAhorros WHERE id_cliente = ?");
    $stmt->bind_param("i", $_SESSION['cliente']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['saldo'];
    } else {
        echo "No se encontró saldo."; 
    }

    $stmt->close(); // Cerrar la declaración
    ?>
    </h2>
    <div class="log">
        <label for="exampleLog" class="form-label">¿Regresar?
        <a class="hyper" href="./index.php">Haz clic aquí</a></label> <br>
    </div>
</body>


</html>
