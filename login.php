<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("./conexion.php");

// Verifica si llegaron los datos
if (!isset($_POST['nombre_usuario']) || !isset($_POST['contraseña'])) {
    die("Faltan datos");
}

// Obtener datos del formulario
$nombre_usuario = $_POST['nombre_usuario'];
$contraseña = $_POST['contraseña'];
$estado_activo = 'activo';

// Consulta preparada
$query = "SELECT * FROM usuarios WHERE nombre_usuario=? AND contraseña=? AND estado=?";
$stmt = $mysql->prepare($query);
if (!$stmt) {
    die("Error al preparar la consulta: " . $mysql->error);
}

$stmt->bind_param("sss", $nombre_usuario, $contraseña, $estado_activo);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el usuario
if ($result->num_rows > 0) {
    echo "Inicio de sesión exitoso";
} else {
    echo "Usuario o Contraseña Errados";
}

$stmt->close();
$mysql->close();
