<?php


class Producto
{
    private $id;
    private $categoria_id;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;
    private $oferta;
    private $fecha;
    private $imagen;

    private $db;


    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    function getId()
    {
        return $this->id;
    }

    function getCategoria_id()
    {
        return $this->categoria_id;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function getDescripcion()
    {
        return $this->descripcion;
    }

    function getPrecio()
    {
        return $this->precio;
    }

    function getStock()
    {
        return $this->stock;
    }

    function getOferta()
    {
        return $this->oferta;
    }

    function getFecha()
    {
        return $this->fecha;
    }

    function getImagen()
    {
        return $this->imagen;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;
    }

    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    function setStock($stock)
    {
        $this->stock = $stock;
    }

    function setOferta($oferta)
    {
        $this->oferta = $oferta;
    }

    function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM productos ORDER BY id DESC";

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
        // Asigna la fecha actual si no se proporcionó una
        $this->fecha = date('Y-m-d H:i:s');

        // Consulta SQL con placeholders para insertar un producto
        $sql = "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, oferta, fecha, imagen)
                VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :oferta, :fecha, :imagen)";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar los parámetros con los valores de las propiedades de la clase
            $stmt->bindParam(':categoria_id', $this->categoria_id);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':descripcion', $this->descripcion);
            $stmt->bindParam(':precio', $this->precio);
            $stmt->bindParam(':stock', $this->stock);
            $stmt->bindParam(':oferta', $this->oferta);
            $stmt->bindParam(':fecha', $this->fecha);
            $stmt->bindParam(':imagen', $this->imagen);

            // Ejecutar la consulta
            $stmt->execute();

            return true;  // Si la inserción fue exitosa
        } catch (PDOException $e) {
            // Si ocurre un error, mostrarlo
            echo "Error al guardar producto: " . $e->getMessage();
            return false;  // Si hubo un error
        }
    }

    public function edit()
    {
        try {
            // Consulta SQL con placeholders
            $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, categoria_id = :categoria_id";

            // Si se proporciona una imagen, añadir el campo a la consulta
            if ($this->getImagen() != null) {
                $sql .= ", imagen = :imagen";
            }

            // Agregar la condición WHERE para especificar el ID del producto
            $sql .= " WHERE id = :id";

            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar los parámetros
            $stmt->bindParam(':nombre', $this->getNombre());
            $stmt->bindParam(':descripcion', $this->getDescripcion());
            $stmt->bindParam(':precio', $this->getPrecio());
            $stmt->bindParam(':stock', $this->getStock());
            $stmt->bindParam(':categoria_id', $this->getCategoria_id());
            $stmt->bindParam(':id', $this->id);

            // Si hay una imagen, enlazarla también
            if ($this->getImagen() != null) {
                $stmt->bindParam(':imagen', $this->getImagen());
            }

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se ejecutó correctamente
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error, manejarlo
            echo "Error al actualizar producto: " . $e->getMessage();
            return false;
        }
    }

    public function delete()
    {
        try {
            // Consulta SQL con placeholder para el ID
            $sql = "DELETE FROM productos WHERE id = :id";

            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar el parámetro id
            $stmt->bindParam(':id', $this->id);

            // Ejecutar la consulta
            $stmt->execute();

            // Verificar si se eliminó alguna fila
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            // Si ocurre un error, manejarlo
            echo "Error al eliminar producto: " . $e->getMessage();
            return false;
        }
    }



}


?>