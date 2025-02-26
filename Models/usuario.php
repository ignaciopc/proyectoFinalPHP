<?php

class usuario
{
    private $id;
    private $nombre;
    private $apellidos;
    private $email;
    private $password;
    private $rol;
    private $imagen;

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
    public function getImagen()
    {
        return $this->imagen;
    }

    public function setImagen($imagen)
    {
        $this->imagen = $imagen;
    }



    public function save()
    {
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
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':imagen', $this->imagen);

            // Ejecutar la consulta
            $stmt->execute();

            return true; // Si la inserción fue exitosa
        } catch (PDOException $e) {
            // Si ocurre un error, mostrarlo
            echo "Error al guardar usuario: " . $e->getMessage();
            return false; // Si hubo un error
        }
    }


    public function login() {
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
    
}

?>