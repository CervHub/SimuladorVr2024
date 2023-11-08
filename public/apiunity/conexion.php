<?php

$host = 'localhost'; // Cambia esto al nombre o dirección IP de tu servidor PostgreSQL
$port = '5432'; // Cambia esto al puerto de tu servidor PostgreSQL (por defecto, 5432)
$dbname = 'simuladoresvr'; // Cambia esto al nombre de tu base de datos PostgreSQL
$username = 'postgres'; // Cambia esto a tu nombre de usuario de PostgreSQL
$password = 'admin@c3rv'; // Cambia esto a tu contraseña de PostgreSQL


try {
    $db = new PDO("pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password");
    // Establece las opciones de PDO según sea necesario
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    echo "Conexion Exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
