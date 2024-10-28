<?php
session_start();
if (empty($_SESSION["cliente"])) {
    header("location: http://localhost/proyectoNahue/login.php");
    exit(); // Asegúrate de salir después de redirigir
}
include("conexion.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar prestamo</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
        <pre style="margin-left: 25%; margin-right: 30%">
 ________  ________  ___       ___  ________  ___  _________  ________  ________          ________  ________  _______   ________  _________  ________  _____ ______   ________     
|\   ____\|\   __  \|\  \     |\  \|\   ____\|\  \|\___   ___\\   __  \|\   __  \        |\   __  \|\   __  \|\  ___ \ |\   ____\|\___   ___\\   __  \|\   _ \  _   \|\   __  \    
\ \  \___|\ \  \|\  \ \  \    \ \  \ \  \___|\ \  \|___ \  \_\ \  \|\  \ \  \|\  \       \ \  \|\  \ \  \|\  \ \   __/|\ \  \___|\|___ \  \_\ \  \|\  \ \  \\\__\ \  \ \  \|\  \   
 \ \_____  \ \  \\\  \ \  \    \ \  \ \  \    \ \  \   \ \  \ \ \   __  \ \   _  _\       \ \   ____\ \   _  _\ \  \_|/_\ \_____  \   \ \  \ \ \   __  \ \  \\|__| \  \ \  \\\  \  
  \|____|\  \ \  \\\  \ \  \____\ \  \ \  \____\ \  \   \ \  \ \ \  \ \  \ \  \\  \|       \ \  \___|\ \  \\  \\ \  \_|\ \|____|\  \   \ \  \ \ \  \ \  \ \  \    \ \  \ \  \\\  \ 
    ____\_\  \ \_______\ \_______\ \__\ \_______\ \__\   \ \__\ \ \__\ \__\ \__\\ _\        \ \__\    \ \__\\ _\\ \_______\____\_\  \   \ \__\ \ \__\ \__\ \__\    \ \__\ \_______\
   |\_________\|_______|\|_______|\|__|\|_______|\|__|    \|__|  \|__|\|__|\|__|\|__|        \|__|     \|__|\|__|\|_______|\_________\   \|__|  \|__|\|__|\|__|     \|__|\|_______|
   \|_________|                                                                                                           \|_________|                                                                                                                \|_________|
        </pre>
        <form action="post">
        <div class="inputDiv">
            <input type="number" name="prestamo" placeholder="INGRESAR PRESTAMO AQUI">
        </div>
        </form>
        <div class="log">
            <label for="exampleLog" class="form-label">¿Regresar?
            <a class="hyper" href="./index.php">Haz clic aquí</a></label> <br>
        </div>




</body>
