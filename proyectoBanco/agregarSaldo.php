<?php
session_start();
if (empty($_SESSION["cliente"])) {
    header("location: http://localhost/proyectoNahue/login.php");
    exit(); // Asegúrate de salir después de redirigir
}
include("conexion.php");

// Procesar el formulario si se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_cajaDeAhorro = $_POST['id_cajaDeAhorro'];
    $saldoNuevo = $_POST['saldoNuevo'];

    // Obtener el saldo actual de la caja de ahorro
    $query = "SELECT saldo FROM cajaDeAhorros WHERE id_cajaDeAhorro = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_cajaDeAhorro);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $saldoActual = $row['saldo'];

    // Calcular el nuevo saldo
    $nuevoSaldo = $saldoActual + $saldoNuevo;

    // Actualizar el saldo en la base de datos
    $updateQuery = "UPDATE cajaDeAhorros SET saldo = ? WHERE id_cajaDeAhorro = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param("di", $nuevoSaldo, $id_cajaDeAhorro);
    if ($updateStmt->execute()) {
        // Insertar en el historial
        $historialQuery = "INSERT INTO historial (saldoInicio, saldoFinal, ingreso_egreso, fecha, id_cajaDeAhorro) VALUES (?, ?, TRUE, CURDATE(), ?)";
        $historialStmt = $conn->prepare($historialQuery);
        $historialStmt->bind_param("ddi", $saldoActual, $nuevoSaldo, $id_cajaDeAhorro);
        $historialStmt->execute();

        echo "<p>Saldo agregado exitosamente.</p>";
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
        <pre style="margin-left: 25%; margin-right: 30%">
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
            <div class="inputDiv">
                <input type="hidden" name="id_cajaDeAhorro" value="<?php echo $_SESSION['id_cajaDeAhorro']; ?>">
                <input type="number" name="saldoNuevo" placeholder="INGRESAR SALDO AQUI" required>
            </div>
            <button type="submit">Agregar Saldo</button>
        </form>
        <div class="log">
            <label for="exampleLog" class="form-label">¿Regresar?
            <a class="hyper" href="./index.php">Haz clic aquí</a></label> <br>
        </div>
        

        
</body>