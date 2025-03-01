<?php

class Pedido
{
    private $id;
    private $usuario_id;
    private $provincia;
    private $localidad;
    private $direccion;
    private $coste;
    private $estado;
    private $fecha;
    private $hora;

    private $db;

    public function __construct()
    {
        // Asumiendo que Database es una clase que retorna una conexión PDO
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters y Setters
    public function getId()
    {
        return $this->id;
    }

    public function getUsuario_id()
    {
        return $this->usuario_id;
    }

    public function getProvincia()
    {
        return $this->provincia;
    }

    public function getLocalidad()
    {
        return $this->localidad;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function getCoste()
    {
        return $this->coste;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function getHora()
    {
        return $this->hora;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsuario_id($usuario_id)
    {
        $this->usuario_id = $usuario_id;
    }

    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;
    }

    public function setLocalidad($localidad)
    {
        $this->localidad = $localidad;
    }

    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;
    }

    public function setCoste($coste)
    {
        $this->coste = $coste;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    public function setHora($hora)
    {
        $this->hora = $hora;
    }

    // Obtener todos los pedidos
    public function getAll()
    {
        $sql = "SELECT * FROM pedidos ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Obtener un pedido por ID
    public function getOne()
    {
        $sql = "SELECT * FROM pedidos WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Guardamos el resultado de getId() en una variable
        $id = $this->getId();

        // Ahora pasamos la variable $id a bindParam
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }


    // Obtener el último pedido del usuario
    public function getOneByUser()
    {
        $usuario_id = $this->getUsuario_id();

        // Verifica que el ID de usuario no sea nulo o inválido
        if (is_null($usuario_id)) {
            echo "Error: El ID del usuario es nulo.";
            return false;  // Detenemos la ejecución si el ID es inválido
        }

        $sql = "SELECT p.id, p.coste FROM pedidos p WHERE p.usuario_id = :usuario_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);

        // Asegúrate de que se pase un valor válido
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
        $stmt->execute();

        // Usa fetch(PDO::FETCH_OBJ) para devolver un objeto
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        return $resultado;
    }


    // Obtener todos los pedidos de un usuario
    public function getAllByUser()
    {
        // Guardamos el valor en una variable antes de pasarlo a bindParam
        $usuario_id = $this->getUsuario_id();

        // Preparamos la consulta SQL
        $sql = "SELECT * FROM pedidos WHERE usuario_id = :usuario_id ORDER BY id DESC";

        // Preparamos la declaración
        $stmt = $this->db->prepare($sql);

        // Asociamos la variable con el marcador :usuario_id
        $stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);

        // Ejecutamos la consulta
        $stmt->execute();

        // Devolvemos todos los resultados en formato de objeto
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Obtener los productos de un pedido
    public function getProductosByPedido($id)
    {
        $sql = "SELECT pr.*, lp.unidades FROM productos pr "
            . "INNER JOIN lineas_pedidos lp ON pr.id = lp.producto_id "
            . "WHERE lp.pedido_id = :pedido_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':pedido_id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Guardar un nuevo pedido
    public function save()
    {
        $sql = "INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) "
            . "VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, 'confirm', CURDATE(), CURTIME())";
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':usuario_id', $this->getUsuario_id(), PDO::PARAM_INT);
        $stmt->bindParam(':provincia', $this->getProvincia(), PDO::PARAM_STR);
        $stmt->bindParam(':localidad', $this->getLocalidad(), PDO::PARAM_STR);
        $stmt->bindParam(':direccion', $this->getDireccion(), PDO::PARAM_STR);
        $stmt->bindParam(':coste', $this->getCoste(), PDO::PARAM_STR);

        $result = $stmt->execute();
        return $result;
    }

    // Guardar las líneas del pedido (productos)
    public function save_linea()
    {
        // Obtener el ID del último pedido insertado
        $sql = "SELECT LAST_INSERT_ID() as pedido_id";
        $stmt = $this->db->query($sql);
        $pedido_id = $stmt->fetch(PDO::FETCH_OBJ)->pedido_id;

        // Insertar cada producto en la tabla de líneas de pedidos
        foreach ($_SESSION['carrito'] as $elemento) {
            $producto = $elemento['producto'];
            $sql = "INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) "
                . "VALUES (:pedido_id, :producto_id, :unidades)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':pedido_id', $pedido_id, PDO::PARAM_INT);
            $stmt->bindParam(':producto_id', $producto->id, PDO::PARAM_INT);
            $stmt->bindParam(':unidades', $elemento['unidades'], PDO::PARAM_INT);
            $stmt->execute();
        }

        return true;
    }

    // Editar el estado de un pedido
    public function edit()
    {
        $sql = "UPDATE pedidos SET estado = :estado WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':estado', $this->getEstado(), PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->getId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }
}

?>