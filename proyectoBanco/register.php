<?php
if (isset($_POST['email'], $_POST['pswd'], $_POST['pswdConfirm'], $_POST['nombre'], $_POST['apellido'], $_POST['telefono'], $_POST['DNI'])) {
    // Validar que los campos no estén vacíos
    if (!empty($_POST['email']) && !empty($_POST['pswd']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['telefono']) && !empty($_POST['DNI'])) {
        
        // Comprobar si las contraseñas coinciden
        if ($_POST['pswd'] === $_POST['pswdConfirm']) {
            // Conectar a la base de datos
            include("conexion.php");
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            
            try {
                // Escapar el DNI
                $DNI = mysqli_real_escape_string($link, $_POST['DNI']);
                $stmt = $link->prepare("SELECT id_cliente FROM cliente WHERE DNI = ?");
                $stmt->bind_param("s", $DNI);
                $stmt->execute();
                $result = $stmt->get_result();

                // Comprobar si el DNI ya está en uso
                if ($result->num_rows === 0) {
                    // Escapar y hashear la contraseña
                    $email = mysqli_real_escape_string($link, $_POST['email']);
                    $password = md5($_POST['pswd']);
                    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
                    $apellido = mysqli_real_escape_string($link, $_POST['apellido']);
                    $telefono = mysqli_real_escape_string($link, $_POST['telefono']);
                    
                    // Insertar el nuevo usuario
                    $insertQuery = "INSERT INTO cliente (email, contrasena, nombre, apellido, telefono, DNI, id_cajaDeAhorro) VALUES (?, ?, ?, ?, ?, ?, NULL)";
                    $insertStmt = $link->prepare($insertQuery);
                    $insertStmt->bind_param("ssssss", $email, $password, $nombre, $apellido, $telefono, $DNI);
                    $insertStmt->execute();

                    // Obtener el ID del nuevo cliente
                    $lastId = $link->insert_id;

                    // Crear la cuenta de ahorros
                    $insertSavingsQuery = "INSERT INTO cajaDeAhorros (id_cliente, saldo) VALUES (?, 1)";
                    $insertSavingsStmt = $link->prepare($insertSavingsQuery);
                    $insertSavingsStmt->bind_param("i", $lastId);
                    $insertSavingsStmt->execute();

                    // Obtener el ID de la nueva caja de ahorros
                    $lastSavingsId = $link->insert_id;

                    // Actualizar el cliente con el ID de la caja de ahorros
                    $updateQuery = "UPDATE cliente SET id_cajaDeAhorro = ? WHERE id_cliente = ?";
                    $updateStmt = $link->prepare($updateQuery);
                    $updateStmt->bind_param("ii", $lastSavingsId, $lastId);
                    $updateStmt->execute();

                    echo "<p>¡Registro exitoso!</p>";
                } else {
                    echo "<p>Error de registro, el DNI ya tiene una cuenta.</p>";
                }
            } catch (Exception $e) {
                echo "<p>Error al registrar: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p>Error de registro, las contraseñas no coinciden.</p>";
        }
    } else {
        echo "<p>Error de registro, por favor llena todos los campos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
</head>
<body>
    <!-- Form to register -->
    <form method="post">
        <pre>
 ________  _______   ________  ___  ________  _________  _______   ________     
|\   __  \|\  ___ \ |\   ____\|\  \|\   ____\|\___   ___\\  ___ \ |\   __  \    
\ \  \|\  \ \   __/|\ \  \___|\ \  \ \  \___|\|___ \  \_\ \   __/|\ \  \|\  \   
 \ \   _  _\ \  \_|/_\ \  \  __\ \  \ \_____  \   \ \  \ \ \  \_|/_\ \   _  _\  
  \ \  \\  \\ \  \_|\ \ \  \|\  \ \  \|____|\  \   \ \  \ \ \  \_|\ \ \  \\  \| 
   \ \__\\ _\\ \_______\ \_______\ \__\____\_\  \   \ \__\ \ \_______\ \__\\ _\ 
    \|__|\|__|\|_______|\|_______|\|__|\_________\   \|__|  \|_______|\|__|\|__|
                                      \|_________|
        </pre>
        <br>

        <label for="nombre" class="form-label">Name</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="text" name="nombre" placeholder="Name here">
        </div>
        
        <p>---------</p>

        <label for="surname" class="form-label">Surname</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="text" name="apellido" placeholder="Surname here">
        </div>
        
        <p>---------</p>

        <label for="telefono" class="form-label">Phone</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="tel" pattern="[1]{2} [0-9]{4}-[0-9]{4}" name="telefono" placeholder="Phone here (11 1234-5678)" minlength="12" maxlength="12">
        </div>
        
        <p>---------</p>

        <label for="DNI" class="form-label">DNI</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="number" name="DNI" placeholder="DNI here" min="10000000" maxlength="99999999">
        </div>
        
        <p>---------</p>

        <label for="exampleInputEmail1" class="form-label">Email address</label> 
        <br>
        <div class="inputDiv">
            <p>-></p><input type="email" name="email" aria-describedby="emailHelp" placeholder="Email here">
        </div>
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else (but the blackmarket). <br>
        <p>---------</p>

        <label class="form-label">Password</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="password" name="pswd" minlength="10" maxlength="15" placeholder="Password here">
        </div>
        <label for="exampleInputPassword1" class="form-label">Confirm password</label> <br>
        <div class="inputDiv">
            <p>-></p><input type="password" name="pswdConfirm" placeholder="Confirm password here">
        </div>
        
        <p>---------</p>

        <button type="submit" class="btn">
            <pre>____________
|            |\
 |   SUBMIT   |\ 
|____________|\
\\\\\\\\\\\\\\\
            </pre>
        </button>
        <p>---------</p>

        <div class="log">
            <label for="exampleLog" class="form-label">Already have an account?
            <a class="hyper" href="./login.php">Click Here</a></label> <br>
        </div>
        
    </form>

    <script src="main.js"></script>
</body>
<style>
@font-face {
    font-family: 'IBM';
    src: url("./assets/font/Px437_IBM_VGA_8x16.ttf");
    font-weight: normal;
    font-style: normal;
}

body {
    background-color: #212226;
    font-family: 'IBM'; 
    color: #41FF00;
}

input {
    background-color: #212226;
    border: 0px;
    color: #41FF00;
    outline: none;
    margin-left: 10px;
}

input:focus {
    border: 0px black solid !important;
    outline: none;
}

.inputDiv {
    display: flex;
    padding: 0;
}

button {
    background-color: #212226;
    color: #41FF00;
    border: 0px;
}
</style>
</html>
