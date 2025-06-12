<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("./conexion.php");
$mysql->set_charset("utf8");

$nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
$contraseña = trim($_POST['contraseña'] ?? '');
$estado_activo = 'activo';

file_put_contents("debug.log", "Usuario: $nombre_usuario | Contraseña: $contraseña\n", FILE_APPEND);

$query = "SELECT * FROM usuarios WHERE nombre_usuario=? AND contraseña=? AND estado=?";
$stmt = $mysql->prepare($query);

if (!$stmt) {
    die("Error en prepare: " . $mysql->error);
}

$stmt->bind_param("sss", $nombre_usuario, $contraseña, $estado_activo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "Inicio de sesión exitoso";
} else {
    echo "Usuario o Contraseña Errados";