<?php

// Asegúrate de incluir el autoload de Composer para usar la librería Dotenv
require_once __DIR__ . '/../vendor/autoload.php';  // Ajusta la ruta si es necesario

use Dotenv\Dotenv;

class Database
{
    private static $instance = null;
    private $pdo;

    // Constructor privado para evitar instanciación directa
    function __construct()
    {
        // Cargar el archivo .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Ruta a la raíz del proyecto
        $dotenv->load(); // Carga las variables de entorno

        try {
            // Usar las variables de entorno cargadas para la conexión
            $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8';
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            // Crear la instancia de PDO con los datos de .env
            $this->pdo = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);

        } catch (PDOException $e) {
            // Manejar el error si no se puede conectar a la base de datos
            die("Error al conectar a la base de datos: " . $e->getMessage());
        }
    }

    // Método estático para obtener la instancia única de la clase
    public static function getInstance()
    {
        if (self::$instance === null) {
            // Si no existe la instancia, la creamos
            self::$instance = new Database();
        }
        return self::$instance; // Devolvemos la instancia única
    }

    // Método para obtener la conexión PDO
    public function getConnection()
    {
        return $this->pdo;
    }

    // Evitar clonación de la instancia (patrón Singleton)
    private function __clone() {}
}
?>
