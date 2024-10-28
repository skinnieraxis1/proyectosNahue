<?php
session_start(); // Inicia la sesión

if (!isset($_SESSION['captcha'])) {
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    $string_length = 6;
    $ChangeCaptcha = '';
    for ($i = 0; $i < $string_length; $i++) {
        $rnum = rand(0, strlen($chars) - 1);
        $ChangeCaptcha .= $chars[$rnum];
    }
    $_SESSION['captcha'] = $ChangeCaptcha;
}

// Define constantes para los intentos máximos y el tiempo de bloqueo
define('MAX_ATTEMPTS', 5);
define('LOCKOUT_TIME', 3); // Tiempo de bloqueo en segundos (5 minutos)

// Verifica si la sesión de bloqueo está establecida
if (isset($_SESSION['lockout_time']) && time() < $_SESSION['lockout_time']) {
    echo "<p>Demasiados intentos fallidos. Por favor, inténtelo más tarde.</p>";
    exit;
}

// Inicializa intentos si no se ha establecido ya
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

// Login
if (isset($_POST['email'], $_POST['pswd'], $_POST['capt'], $_POST['DNI'])) {
    // Verifica el captcha
    if (trim($_POST['capt']) != trim($_SESSION['captcha'])) {
        echo "<p>Captcha incorrecto. Por favor, inténtelo de nuevo.</p>";
        $_SESSION['attempts']++;
    } else {
        // Conectar a la base de datos
        include("conexion.php");

        // Consulta preparada para prevenir inyecciones SQL
        $stmt = $link->prepare("SELECT id_cliente, email, contrasena, DNI FROM cliente WHERE DNI = ?");
        $stmt->bind_param("s", $_POST['DNI']);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica si se encontró algo
        if ($result->num_rows > 0) {
            $usuario = $result->fetch_assoc();

            // Verifica la contraseña
            if (md5($_POST['pswd']) == $usuario['contrasena'] && $_POST['email'] == $usuario['email']) {
                echo "<p>¡Inicio de sesión exitoso!</p>";
                $_SESSION["cliente"] = $usuario;
                header("Location: http://localhost/proyectoBanco/index.php");
                unset($_SESSION['captcha']); 
                exit;
            } else {
                $_SESSION['attempts']++;
                echo md5($_POST['pswd']);
                echo "<p>a incorrectos. Por favor, inténtelo de nuevo.</p>";
            }
        } else {
            $_SESSION['attempts']++;
            echo "<p>Datos incorrectos. Por favor, inténtelo de nuevo.</p>";
        }

        // Bloqueo después de los intentos máximos
        if ($_SESSION['attempts'] >= MAX_ATTEMPTS) {
            $_SESSION['lockout_time'] = time() + LOCKOUT_TIME; 
            echo "<p>Demasiados intentos fallidos. Por favor, inténtelo más tarde.</p>";
            exit;
        }
        $stmt->close(); // Cierra la declaración
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/style.php">
</head>
<body onLoad="ChangeCaptcha()" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off>

    <!-- Formulario de inicio de sesión -->
    <form method="POST" autocomplete="off">
        <pre>
__/\\\___________________/\\\\\__________/\\\\\\\\\\\\__/\\\\\\\\\\\__/\\\\\_____/\\\_
 _\/\\\_________________/\\\///\\\______/\\\//////////__\/////\\\///__\/\\\\\\___\/\\\_
  _\/\\\_______________/\\\/__\///\\\___/\\\_________________\/\\\_____\/\\\/\\\__\/\\\_
   _\/\\\______________/\\\______\//\\\_\/\\\____/\\\\\\\_____\/\\\_____\/\\\//\\\_\/\\\_
    _\/\\\_____________\/\\\_______\/\\\_\/\\\___\/////\\\_____\/\\\_____\/\\\\//\\\\/\\\_
     _\/\\\_____________\//\\\______/\\\__\/\\\_______\/\\\_____\/\\\_____\/\\\_\//\\\/\\\_
      _\/\\\______________\///\\\__/\\\____\/\\\_______\/\\\_____\/\\\_____\/\\\__\//\\\\\\_
       _\/\\\\\\\\\\\\\\\____\///\\\\\/_____\//\\\\\\\\\\\\/___/\\\\\\\\\\\_\/\\\___\//\\\\\_
        _\///////////////_______\/////________\////////////____\///////////__\///_____\/////__
    </pre>

        <!-- Email -->
        <label for="email" class="form-label">Email address</label> 
        <div class="inputDiv"><p>-></p><input type="email" name="email" maxlength="30" placeholder="Email here" required></div>
        <p>---------</p>

        <!-- DNI -->
        <label for="DNI" class="form-label">DNI</label> 
        <div class="inputDiv"><p>-></p><input name="DNI" type="text" maxlength="8" placeholder="DNI here" required></div>
        <p>---------</p>
        <!-- Password -->
        <label for="exampleInputPassword1" class="form-label">Password</label> 
        <div class="inputDiv"><p>-></p><input name="pswd" type="password" minlength="10" maxlength="15" placeholder="Password here" required></div>
        <p>---------</p>

        <!-- Captcha -->
        <div class="simple_captcha">
            <input type="text" id="randomfield" name="cap" value="<?php echo $_SESSION['captcha']; ?>" readonly>
            <br><br>
            <input id="CaptchaEnter" name="capt" type="text" maxlength="6" placeholder="Captcha here" required/>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn">
            <pre>
____________
|            |\
 |   SUBMIT   |\ 
|____________|\
\\\\\\\\\\\\\\\</pre>
        </button>

        <p>---------</p>

        <!-- Enlace para registrarse -->
        <div class="log">
            <label for="exampleLog" class="form-label">¿No tienes una cuenta aún?
            <a class="hyper" href="./register.php">Haz clic aquí</a></label> <br>
        </div>
    </form>
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

    button {
        background-color: #212226;
        color: #41FF00;
        border: 0px;
    }

    .inputDiv {
        display: flex;
        padding: 0%;
    }
    #randomfield { 
    -webkit-touch-callout: none;
    -webkit-user-select: none;
    -khtml-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    width: 200px;
    color: #41FF00;
    border-color: #41FF00;
    text-align: center;
    border: solid;
    font-size: 40px;
    }
</style>
</html>
