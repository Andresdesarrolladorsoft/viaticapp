<?php
// Datos de conexión a la base de datos
$localhost = "sql204.infinityfree.com";
$bdb = "if0_38550746_viaticaap";
$user = "if0_38550746";
$pass = "qhXTYNHkjJA";

$mysql = new mysqli($localhost, $user, $pass, $bdb);

if ($mysql->connect_error) {
    die("Error en la conexión" . $mysql->connect_error);
}
