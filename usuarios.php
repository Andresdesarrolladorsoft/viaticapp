<?php
// usuarios.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=UTF-8');

require_once("./conexion.php");
file_put_contents("usuarios_debug.log", date('[Y-m-d H:i:s] ') . json_encode($_POST) . "\n", FILE_APPEND);

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["status" => "error", "mensaje" => "Método no permitido"]);
    exit;
}

$accion = $_POST['accion'] ?? '';

switch ($accion) {
    case 'crear':
        $stmt = $mysql->prepare("INSERT INTO usuarios (nombre, apellido, correo, contraseña, id_perfil, direccion, telefono, identificacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssisss",
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['correo'],
            $_POST['contraseña'],
            $_POST['id_perfil'],
            $_POST['direccion'],
            $_POST['telefono'],
            $_POST['identificacion']
        );
        if ($stmt->execute()) {
            echo json_encode(["status" => "ok", "mensaje" => "Usuario dado de alta"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $stmt->error]);
        }
        $stmt->close();
        break;

    case 'listar':
        $estado = $_POST['estado'] ?? 'activo';
        $query = "SELECT * FROM usuarios WHERE estado = ?";
        $stmt = $mysql->prepare($query);
        $stmt->bind_param("s", $estado);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuarios = $result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["status" => "ok", "data" => $usuarios]);
        break;

    case 'ver':
        $id = $_POST['id_usuario'];
        $stmt = $mysql->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
        echo json_encode(["status" => "ok", "data" => $usuario]);
        break;

    case 'editar':
        $stmt = $mysql->prepare("UPDATE usuarios SET nombre=?, apellido=?, correo=?, contraseña=?, id_perfil=?, estado=?, direccion=?, telefono=?, identificacion=? WHERE id_usuario=?");
        $stmt->bind_param("ssssissssi",
            $_POST['nombre'],
            $_POST['apellido'],
            $_POST['correo'],
            $_POST['contraseña'],
            $_POST['id_perfil'],
            $_POST['estado'],
            $_POST['direccion'],
            $_POST['telefono'],
            $_POST['identificacion'],
            $_POST['id_usuario']
        );
        if ($stmt->execute()) {
            echo json_encode(["status" => "ok", "mensaje" => "Usuario actualizado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $stmt->error]);
        }
        $stmt->close();
        break;

    case 'eliminar':
        $stmt = $mysql->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        $stmt->bind_param("i", $_POST['id_usuario']);
        if ($stmt->execute()) {
            echo json_encode(["status" => "ok", "mensaje" => "Usuario eliminado"]);
        } else {
            echo json_encode(["status" => "error", "mensaje" => $stmt->error]);
        }
        $stmt->close();
        break;

    default:
        echo json_encode(["status" => "error", "mensaje" => "Acción no válida"]);
        break;
}

$mysql->close();