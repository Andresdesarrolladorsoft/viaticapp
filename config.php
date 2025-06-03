<?php
// $server_url = "http://localhost:8080";
$server_url = "http://estudiosoftware.rf.gd";
// Permitir acceso desde cualquier origen
header("Access-Control-Allow-Origin: *");

// Permitir métodos específicos (puedes ajustar según necesidad)
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Permitir ciertos headers (ajústalo si usas otros)
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Si es una solicitud OPTIONS (preflight), detenla aquí
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204); // Sin contenido
}
