<?php
class categoria
{
    private $id;
    private $nombre;
    private $db;


    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }


    public function getAll()
    {
        $sql = "SELECT * FROM categorias ORDER BY id DESC";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener los resultados como un array asociativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Manejar el error
            echo "Error al obtener categorías: " . $e->getMessage();
            return false;
        }
    }


    public function save()
    {
        $sql = "INSERT INTO categorias (nombre) 
        VALUES (:nombre)";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar los parámetros con los valores de las propiedades de la clase
            $stmt->bindParam(':nombre', $this->nombre);
            // Ejecutar la consulta
            $stmt->execute();

            return true; // Si la inserción fue exitosa
        } catch (PDOException $e) {
            // Si ocurre un error, mostrarlo
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; // Si hubo un error
        }
    }
}
?>