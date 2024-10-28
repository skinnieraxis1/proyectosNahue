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
    <title>Consultar Saldo</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
    <pre style="margin-left: 25%; margin-right: 30%">
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
    // Obtener el saldo del cliente
    $stmt = $link->prepare("SELECT saldo FROM cajadeahorro WHERE id_cliente = ?");
    $stmt->bind_param("i", $_SESSION['cliente']);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró un saldo
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['saldo']; // Mostrar el saldo
    } else {
        echo "No se encontró saldo."; // Mensaje si no hay saldo
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
