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
    <title>Realizar pagos</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
        <pre style="margin-left: 25%; margin-right: 30%">
 ________  _______   ________  ___       ___  ________  ________  ________          ________  ________  ________  ________  ________      
|\   __  \|\  ___ \ |\   __  \|\  \     |\  \|\_____  \|\   __  \|\   __  \        |\   __  \|\   __  \|\   ____\|\   __  \|\   ____\     
\ \  \|\  \ \   __/|\ \  \|\  \ \  \    \ \  \\|___/  /\ \  \|\  \ \  \|\  \       \ \  \|\  \ \  \|\  \ \  \___|\ \  \|\  \ \  \___|_    
 \ \   _  _\ \  \_|/_\ \   __  \ \  \    \ \  \   /  / /\ \   __  \ \   _  _\       \ \   ____\ \   __  \ \  \  __\ \  \\\  \ \_____  \   
  \ \  \\  \\ \  \_|\ \ \  \ \  \ \  \____\ \  \ /  /_/__\ \  \ \  \ \  \\  \|       \ \  \___|\ \  \ \  \ \  \|\  \ \  \\\  \|____|\  \  
   \ \__\\ _\\ \_______\ \__\ \__\ \_______\ \__\\________\ \__\ \__\ \__\\ _\        \ \__\    \ \__\ \__\ \_______\ \_______\____\_\  \ 
    \|__|\|__|\|_______|\|__|\|__|\|_______|\|__|\|_______|\|__|\|__|\|__|\|__|        \|__|     \|__|\|__|\|_______|\|_______|\_________\
                                                                                                                              \|_________|
        </pre>
        
        <form action="" method="POST">
            <div class="inputDiv">
                <input type="text" name="dniDestino" placeholder="INGRESAR DNI DEL DESTINATARIO" required>
            </div>
            <div class="inputDiv">
                <input type="number" name="pagoRestar" placeholder="INGRESAR PAGO AQUI" required>
            </di>
            <button type="submit">Realizar Pago</button>
        </form>

        <div class="log">
            <label for="exampleLog" class="form-label">¿Regresar?
            <a class="hyper" href="./index.php">Haz clic aquí</a></label> <br>
        </div>



</body>
