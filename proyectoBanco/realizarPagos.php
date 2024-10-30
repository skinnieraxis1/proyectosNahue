<?php
session_start();
if (empty($_SESSION["cliente"])) {
    header("location: http://localhost/proyectoNahue/login.php");
    exit();
}
include("conexion.php");

// Obtener el saldo del cliente actual
$stmt = $link->prepare("SELECT saldo FROM cajaDeAhorros WHERE id_cliente = ?");
$stmt->bind_param("i", $_SESSION['cliente']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $saldoActual = $row['saldo'];
} else {
    echo "No se encontró saldo.";
    exit();
}

$stmt->close();

// Procesar la transferencia si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dniDestino = $_POST['dni'];
    $montoTransferencia = $_POST['monto'];

    // Validar que el monto sea válido
    if ($montoTransferencia <= 0 || $montoTransferencia > $saldoActual) {
        echo "Monto de transferencia inválido.";
        exit();
    }

    // Obtener el id_cliente y saldo del cliente destino usando el DNI
    $stmt = $link->prepare("
        SELECT c.id_cliente, ca.saldo 
        FROM cliente AS c 
        JOIN cajaDeAhorros AS ca ON c.id_cliente = ca.id_cliente 
        WHERE c.DNI = ?");
    $stmt->bind_param("s", $dniDestino);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rowDestino = $result->fetch_assoc();
        $idClienteDestino = $rowDestino['id_cliente'];
        $saldoDestino = $rowDestino['saldo'];

        // Realizar la transferencia
        $nuevoSaldoOrigen = $saldoActual - $montoTransferencia;
        $nuevoSaldoDestino = $saldoDestino + $montoTransferencia;

        // Actualizar el saldo del cliente actual
        $stmt = $link->prepare("UPDATE cajaDeAhorros SET saldo = ? WHERE id_cliente = ?");
        $stmt->bind_param("di", $nuevoSaldoOrigen, $_SESSION['cliente']);
        $stmt->execute();

        // Actualizar el saldo del cliente destino
        $stmt = $link->prepare("UPDATE cajaDeAhorros SET saldo = ? WHERE id_cliente = ?");
        $stmt->bind_param("di", $nuevoSaldoDestino, $idClienteDestino);
        $stmt->execute();

        echo "Transferencia realizada con éxito.";
    } else {
        echo "No se encontró un cliente con ese DNI.";
    }

    $stmt->close();
}
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
        <pre>
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
            <label for="dni">DNI del cliente destino:</label>
            <input type="text" name="dni" required>
        </div>
            <br>
            <div class="inputDiv">
            <label for="monto">Monto a transferir:</label>
            <input type="number" name="monto" min="0" required>
            </div>
            <br>
            <button type="submit" style="margin-left:12px;">Realizar Pago</button>
            <p>Tu saldo actual: <?php echo $saldoActual; ?></p>
        </form>
        <br>
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