<?php
require_once("./conexion.php");
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $mysql;

    // Capturar datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $identificaciondoc = $_POST['identificaciondoc'] ?? null;
    $tipoIdentificacion = $_POST['tipoIdentificacion'] ?? null;
    $departamento = $_POST['departamento'] ?? null;
    $monto = $_POST['monto'] ?? null;
    $motivo = $_POST['motivo'] ?? null;

    // Validación básica de datos
    if (!$nombre || !$identificaciondoc || !$tipoIdentificacion || !$departamento || !$monto || !$motivo) {
        //http_response_code(400);
        echo json_encode(["error" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Insertar datos en la tabla de solicitudes
    $query = "INSERT INTO solicitud (nombre, identificaciondoc, tipoIdentificacion, departamento, monto, motivo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssss", $nombre, $identificaciondoc, $tipoIdentificacion, $departamento, $monto, $motivo);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            //http_response_code(201);
            echo json_encode(["message" => "Solicitud creada exitosamente"]);
        } else {
            //http_response_code(500);
            echo json_encode(["error" => "Error al guardar la solicitud: " . $stmt->error]);
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        //http_response_code(500);
        echo json_encode(["error" => "Error en la preparación de la consulta: " . $mysql->error]);
    }

    // Cerrar la conexión a la base de datos
    $mysql->close();
} else {
    //http_response_code(405);
    echo json_encode(["error" => "Método no permitido."]);
}




/*
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar la acción a realizar


    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];

        // Ejecutar la acción correspondiente
        switch ($accion) {
            case "crear":
                // Función para crear una solicitud
                crearSolicitud();
                break;
            default:
                echo "Acción no válida";
        }
    } else {
        echo "No se proporcionó ninguna acción";
    }
}
function crearSolicitud()
{
    global $mysql;
    //error_log("isrequest: " . $_POST . " \n",3, "error.log"); IMPRIMIR DATOS
    // error_log("data: " . print_r($_POST, true) . " \n",3, "error.log"); 
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $identificacion = $_POST['identificacion'];
    $tipo_documento = $_POST['tipo_documento'];
    $departamento = $_POST['departamento'];
    $monto = $_POST['monto'];
    $motivo = $_POST['motivo'];



    // Insertar datos en la tabla de usuarios
    $query = "INSERT INTO solicitudes_viaticos (nombre, identificacion, tipo_documento, departamento, monto, motivo) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $mysql->prepare($query);

    if ($stmt) {


        $stmt->bind_param("ssssss", $nombre, $identificacion, $tipo_documento, $departamento, $monto, $motivo);
        //print_r($query);

        if ($stmt->execute()) {
            echo json_encode(["Solicitud creada exitosamente"]);
        } else {
            echo json_encode(["Error al guardar"]);
        }
    }



    // Cerrar la conexión a la base de datos
    $stmt->close();
    $mysql->close();
}
*/
