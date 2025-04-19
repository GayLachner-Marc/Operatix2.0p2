<?php
function conectar() {
    $host = 'db'; // o 'localhost' si no estás en Docker
    $dbname = 'isla_transfers';
    $user = 'root';          // ← cambia si es distinto
    $pass = 'adminadmin';    // ← cambia si es distinto

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Error en la conexión: " . $e->getMessage());
    }
}
