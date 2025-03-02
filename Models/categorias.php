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


    public function getOne()
    {
        $sql = "SELECT * FROM categorias WHERE id = :id";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar el parámetro :id
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

            // Ejecutar la consulta
            $stmt->execute();

            // Obtener el resultado como un objeto
            return $stmt->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Manejar el error
            echo "Error al obtener categoría: " . $e->getMessage();
            return false;
        }
    }
    // Actualizar el nombre de una categoría
    public function update()
    {
        $sql = "UPDATE categorias SET nombre = :nombre WHERE id = :id";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmt->execute();
            return true; // La categoría fue actualizada
        } catch (PDOException $e) {
            echo "Error al actualizar la categoría: " . $e->getMessage();
            return false;
        }
    }

    // Eliminar una categoría
    public function delete()
    {
        try {
            // Primero eliminar los productos que pertenecen a esta categoría
            $sqlProductos = "DELETE FROM productos WHERE categoria_id = :id";
            $stmtProductos = $this->db->prepare($sqlProductos);
            $stmtProductos->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmtProductos->execute();
    
            // Luego eliminar la categoría
            $sqlCategoria = "DELETE FROM categorias WHERE id = :id";
            $stmtCategoria = $this->db->prepare($sqlCategoria);
            $stmtCategoria->bindParam(':id', $this->id, PDO::PARAM_INT);
            $stmtCategoria->execute();
    
            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar la categoría: " . $e->getMessage();
            return false;
        }
    }
    


}
?>