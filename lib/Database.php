<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // Configuración de la conexión PDO
            $dsn = 'mysql:host=localhost;dbname=tienda_master;charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            // Crear una instancia de PDO
            $this->pdo = new PDO($dsn, 'root', '', $options);
        } catch (PDOException $e) {
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }


    public function getConnection() {
        return $this->pdo;
    }
}
?>