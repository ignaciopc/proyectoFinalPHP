<?php

// Incluir el autoloader de Composer para cargar las dependencias

namespace lib;

use PDO;
use PDOException;
use PDOStatement;

class BaseDatos{

    private string $servidor;
    private string $usuario;
    private string $contrasena;
    private string $nombre;

    private PDO $conexion;
    private PDOStatement $resultado;

    // Constructor de la base de datos

    public function __construct(){
    
        try{

            $this->servidor = DB_HOST;
            $this->usuario = DB_USER;
            $this->contrasena = DB_PASSWORD;
            $this->nombre = DB_NAME;

            $this->conexion = new PDO("mysql:host=$this->servidor;dbname=$this->nombre", $this->usuario, $this->contrasena);

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        }catch(PDOException $e){

            echo $e->getMessage();

        }
    
    }

}
?>