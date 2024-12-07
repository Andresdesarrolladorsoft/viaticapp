<?php
require_once("./conexion.php");
header('Content-Type: application/json; charset=utf-8');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    global $mysql;

    // Capturar datos del formulario
    $id_referencia = $_POST['id_referencia'] ?? null;
    $estado = $_POST['estado'] ?? null;


    // Validación básica de datos
    /*if (!$id_referencia || !$estado) {
        //http_response_code(400);
        echo json_encode(["error" => "Todos los campos son obligatorios."]);
        exit;
    }*/

    // Insertar datos en la tabla de solicitudes
    $query = "INSERT INTO aprobacion (id_referencia, estado) VALUES (?,?)";
    $stmt = $mysql->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ss", $id_referencia, $estado);

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
                // Función para crear una aprobacion
                crearAprobacion();
                break;
            default:
                echo "Acción no válida";
        }
    } else {
        echo "No se proporcionó ninguna acción";
    }
}
function crearAprobacion()
{
    global $mysql;
    //error_log("isrequest: " . $_POST . " \n",3, "error.log"); IMPRIMIR DATOS
    // error_log("data: " . print_r($_POST, true) . " \n",3, "error.log"); 
    // Obtener datos del formulario
    $estado = $_POST['estado'];
    



    // Insertar datos en la tabla de usuarios
    $query = "INSERT INTO aprobacion (estado) VALUES (?)";
    $stmt = $mysql->prepare($query);

    if ($stmt) {


        $stmt->bind_param("s", $nombre);
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