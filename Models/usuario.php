<?php

class usuario
{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;

    private $db;


    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }
    // Getter y Setter para $id
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter y Setter para $nombre
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    // Getter y Setter para $apellidos
    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    // Getter y Setter para $email
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    // Getter y Setter para $password
    public function getPassword()
    {
        return password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 4]);
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    // Getter y Setter para $rol
    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    // Getter y Setter para $imagen


    public function save()
    {
        // Aplicar el hash a la contraseña
        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);

        // Consulta SQL con placeholders
        $sql = "INSERT INTO usuarios (nombre, apellidos, email, password, rol, imagen) 
                VALUES (:nombre, :apellidos, :email, :password, 'user', :imagen)";

        try {
            // Preparar la consulta
            $stmt = $this->db->prepare($sql);

            // Enlazar los parámetros con los valores de las propiedades de la clase
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':apellidos', $this->apellidos);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $hashedPassword);  // Usar la contraseña hasheada

            // Si no tienes imagen, usa NULL o un valor por defecto
            $imagen = $this->imagen ?? NULL;
            $stmt->bindParam(':imagen', $imagen);

            // Ejecutar la consulta
            $stmt->execute();

            return true; // Si la inserción fue exitosa
        } catch (PDOException $e) {
            // Si ocurre un error, mostrarlo
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; // Si hubo un error
        }
    }




    public function login()
    {
        $result = false;
        $email = $this->email;
        $password = $this->password;

        try {
            // Preparar la consulta con PDO
            $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $stmt->execute();

            // Comprobar si hay un usuario con ese email
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_OBJ);

                // Verificar la contraseña
                if (password_verify($password, $usuario->password)) {
                    $result = $usuario;
                }
            }
        } catch (PDOException $e) {
            echo "Error en el login: " . $e->getMessage();
        }

        return $result;
    }

    public function update()
    {
        $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':rol', $this->rol); 
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function getAll()
    {
        // Consulta SQL para obtener todos los usuarios
        $sql = "SELECT id, nombre, apellidos, email, rol FROM usuarios"; // Puedes ajustar los campos según tus necesidades
        $stmt = $this->db->prepare($sql);

        // Ejecutamos la consulta
        $stmt->execute();

        // Fetch all users and return them as an associative array or objects
        return $stmt->fetchAll(PDO::FETCH_OBJ); // Retorna los resultados como un array de objetos
    }

    public function getOne()
    {
        // Consulta SQL para obtener un usuario por ID
        $sql = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";

        // Preparar la consulta
        $stmt = $this->db->prepare($sql);

        // Enlazar el parámetro ID
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se encontró el usuario y devolver los resultados
        if ($stmt->rowCount() > 0) {
            // Retorna el usuario como un objeto
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        // Si no se encuentra el usuario, retorna null
        return null;
    }

    public function delete()
    {
        // Primero eliminar las líneas de pedido relacionadas
        $sqlLineasPedido = "DELETE FROM lineas_pedidos WHERE pedido_id IN (SELECT id FROM pedidos WHERE usuario_id = :id)";
        $stmtLineasPedido = $this->db->prepare($sqlLineasPedido);
        $stmtLineasPedido->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmtLineasPedido->execute();

        // Luego eliminar los pedidos relacionados con el usuario
        $sqlPedidos = "DELETE FROM pedidos WHERE usuario_id = :id";
        $stmtPedidos = $this->db->prepare($sqlPedidos);
        $stmtPedidos->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmtPedidos->execute();

        // Finalmente eliminar el usuario
        $sqlUsuario = "DELETE FROM usuarios WHERE id = :id";
        $stmtUsuario = $this->db->prepare($sqlUsuario);
        $stmtUsuario->bindParam(':id', $this->id, PDO::PARAM_INT);

        return $stmtUsuario->execute();
    }


}

?>