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
        <div class="buttonDiv">
            <button onclick="location.href='./agregarSaldo.php'">Ingresar Saldo</button>
            <button onclick="location.href='./agregarSaldo.php'">Ver saldo</button>
            <button onclick="location.href='./agregarSaldo.php'">Pedir prestamo</button>
            <button onclick="location.href='./agregarSaldo.php'">Realizar pago</button>
        </div>
        <div class='usuario'>
            <?php
                
                $stmt = $link->prepare("SELECT id_cajaDeAhorro FROM cajadeahorros WHERE id_cliente = ?");
                $stmt->bind_param("s", $_SESSION['cliente']);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $stmtC = $link->prepare("SELECT saldoInicio, saldoFinal, ingreso_egreso, fecha FROM historial WHERE id_cajaDeAhorro = ?");
                    $stmtC->bind_param("s", $row['id_cajaDeAhorro']);
                    $stmtC->execute();
                    $resultC = $stmtC->get_result();
                    if ($resultC->num_rows > 0) {

                        echo "<pre>";
                        echo "+------------+------------------------------------------------------------+\n";
                        echo "|   ID   |  Saldo Inicial  |  Saldo Final | Tipo de transacción |  Fecha  |\n";
                        echo "+------------+------------------------------------------------------------+\n";
    
                        // Print each user's details
                        while ($row = $result->fetch_assoc()) {
                            printf("|   %-4s |  %-62s |\n", $row['saldoInicio'], $row['saldoFinal']);
                        }
    
                        echo "+----+---------------------------------------------------------------------+\n";
                        echo "</pre>"; 
                    } else {
                        echo "No users found.<br>";
                    }
                }
                $link->close();
            ?>
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