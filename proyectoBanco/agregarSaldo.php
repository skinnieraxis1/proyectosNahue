<?php
session_start();
if (empty($_SESSION["cliente"])) {
    header("Location: http://localhost/proyectoNahue/login.php");
    exit();
}
include("conexion.php");

if (isset($_POST['saldoNuevo'])) {
    $saldoNuevo = $_POST['saldoNuevo'];
    
    $stmt = $link->prepare("SELECT saldo FROM cajaDeAhorros WHERE id_cliente = ?");
    $stmt->bind_param("i", $_SESSION["cliente"]);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $row = $result->fetch_assoc();
    $saldoActual = $row['saldo'];

    // Update balance
    $updateQuery = "UPDATE cajaDeAhorros SET saldo = (saldo + ?) WHERE id_cliente = ?";
    $updateStmt = $link->prepare($updateQuery);
    $updateStmt->bind_param("di", $saldoNuevo, $_SESSION["cliente"]);
    
    if ($updateStmt->execute()) {
        // Insert into historial
        $saldoFinal = $saldoActual + $saldoNuevo;
        $queryHist = "INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, id_cajaDeAhorro) VALUES (?, ?, TRUE, CURDATE(), ?)";
        
        // Assuming $id_cajaDeAhorro is defined
        $stmtHist = $link->prepare($queryHist);
        $stmtHist->bind_param("ddi", $saldoActual, $saldoFinal, $id_cajaDeAhorro);

        if ($stmtHist->execute()) {
            echo "<p>Saldo agregado exitosamente.</p>";
        } else {
            echo "<p>Error al registrar el historial.</p>";
        }
    } else {
        echo "<p>Error al agregar saldo.</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Saldo</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
        <pre>
 ________  ________  ________  _______   ________  ________  ________          ________  ________  ___       ________  ________     
|\   __  \|\   ____\|\   __  \|\  ___ \ |\   ____\|\   __  \|\   __  \        |\   ____\|\   __  \|\  \     |\   ___ \|\   __  \    
\ \  \|\  \ \  \___|\ \  \|\  \ \   __/|\ \  \___|\ \  \|\  \ \  \|\  \       \ \  \___|\ \  \|\  \ \  \    \ \  \_|\ \ \  \|\  \   
 \ \   __  \ \  \  __\ \   _  _\ \  \_|/_\ \  \  __\ \   __  \ \   _  _\       \ \_____  \ \   __  \ \  \    \ \  \ \\ \ \  \\\  \  
  \ \  \ \  \ \  \|\  \ \  \\  \\ \  \_|\ \ \  \|\  \ \  \ \  \ \  \\  \|       \|____|\  \ \  \ \  \ \  \____\ \  \_\\ \ \  \\\  \ 
   \ \__\ \__\ \_______\ \__\\ _\\ \_______\ \_______\ \__\ \__\ \__\\ _\         ____\_\  \ \__\ \__\ \_______\ \_______\ \_______\
    \|__|\|__|\|_______|\|__|\|__|\|_______|\|_______|\|__|\|__|\|__|\|__|       |\_________\|__|\|__|\|_______|\|_______|\|_______|
                                                                                 \|_________|
        </pre>
        <form action="" method="POST">
            <?php 
                $stmt = $link->prepare("SELECT saldo FROM cajaDeAhorros WHERE id_cliente = ?");
                $stmt->bind_param("i", $_SESSION['cliente']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "<h3>Saldo actual: ".$row['saldo']."</h3>";
                } else {
                    echo "No se encontró saldo."; 
                }

                $stmt->close();
            ?>
            <div class="inputDiv">
                <input type="int" name="saldoNuevo" placeholder="INGRESAR SALDO AQUI" required>
            </div>
            <br/>
            <button type="submit">Agregar Saldo</button>
        </form>
        <div class="log">
            <label for="exampleLog" class="form-label">¿Regresar?
            <a class="hyper" href="./index.php">Haz clic aquí</a></label> <br>
        </div>
        

        
</body>

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
</html>