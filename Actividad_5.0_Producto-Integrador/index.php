<?php
// Archivo JSON donde se almacenan los usuarios
$usuariosFile = 'usuarios.json';

// Leer los usuarios del archivo JSON
$usuarios = file_exists($usuariosFile) ? json_decode(file_get_contents($usuariosFile), true) : [];

// Validar la acción solicitada
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['accion'])) {
    $accion = $_POST['accion'];

    if ($accion === "iniciar-sesion") {
        // Datos del formulario de inicio de sesión
        $usuario = trim($_POST['usuario']);
        $password = trim($_POST['password']);

        // Verificar si el usuario y contraseña coinciden
        if (isset($usuarios[$usuario]) && $usuarios[$usuario] === $password) {
            // Usuario válido: guardar en cookies
            setcookie("usuario", $usuario, time() + 3600); // 1 hora
            header("Location: integradora.html");
            exit;
        } else {
            echo "<p style='color: red; text-align: center;'>Usuario o contraseña incorrectos</p>";
        }
    } elseif ($accion === "crear-usuario") {
        // Datos del formulario de creación de usuario
        $newUsuario = trim($_POST['new-usuario']);
        $newPassword = trim($_POST['new-password']);

        // Verificar si el usuario ya existe
        if (isset($usuarios[$newUsuario])) {
            echo "<p style='color: red; text-align: center;'>El usuario ya existe. Por favor elige otro nombre.</p>";
        } else {
            // Crear nuevo usuario y guardar en el archivo JSON
            $usuarios[$newUsuario] = $newPassword;
            file_put_contents($usuariosFile, json_encode($usuarios, JSON_PRETTY_PRINT));
            echo "<p style='color: green; text-align: center;'>Usuario creado exitosamente. Ahora puedes iniciar sesión.</p>";
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_COOKIE['usuario'])) {
    // Mostrar mensaje si el usuario ya está conectado
    echo "<p style='color: green; text-align: center;'>Ya has iniciado sesión como {$_COOKIE['usuario']}. <a href='logout.php'>Cerrar sesión</a></p>";
}
?>

