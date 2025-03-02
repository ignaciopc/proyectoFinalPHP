<?php

require_once 'models/producto.php';
class productoController
{
    public function index()
    {

        require_once "views/productos/destacados.php";
    }


    public function gestion()
    {

        $productos = new Producto();
        $productos = $productos->getAll();
        require_once "views/productos/gestion.php";
    }


    public function crear()
    {
        Utils::isAdmin();

        require_once 'views/productos/crear.php';
    }

    public function save()
    {
        // Verifica si el usuario tiene privilegios de administrador
        Utils::isAdmin();

        if (isset($_POST)) {
            // Obtén los valores del formulario
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : false;
            $precio = isset($_POST['precio']) ? $_POST['precio'] : false;
            $stock = isset($_POST['stock']) ? $_POST['stock'] : false;
            $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : false;

            // Verifica si todos los campos son válidos
            if ($nombre && $descripcion && $precio && $stock && $categoria) {
                $producto = new Producto();
                $producto->setNombre($nombre);
                $producto->setDescripcion($descripcion);
                $producto->setPrecio($precio);
                $producto->setStock($stock);
                $producto->setCategoria_id($categoria);

                // Asigna la oferta (puede ser 0 o 1 según el formulario)
                $producto->setOferta(0);  // Cambiar según sea necesario, por ejemplo si hay un checkbox para oferta

                // Asigna la fecha actual
                $producto->setFecha(date('Y-m-d H:i:s'));

                // Manejo de la imagen
                if (isset($_FILES['imagen'])) {
                    $file = $_FILES['imagen'];
                    $filename = $file['name'];
                    $mimetype = $file['type'];

                    if ($mimetype == "image/jpg" || $mimetype == 'image/jpeg' || $mimetype == 'image/png' || $mimetype == 'image/gif') {

                        if (!is_dir('uploads/images')) {
                            mkdir('uploads/images', 0777, true);
                        }

                        $producto->setImagen($filename);
                        move_uploaded_file($file['tmp_name'], 'uploads/images/' . $filename);
                    }
                }

                // Guardar el producto
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $producto->setId($id);
                    $save = $producto->edit();
                } else {
                    $save = $producto->save();
                }
                if ($save) {
                    $_SESSION['producto'] = "complete";
                } else {
                    $_SESSION['producto'] = "failed";
                }
            } else {
                $_SESSION['producto'] = "failed";
            }
        } else {
            $_SESSION['producto'] = "failed";
        }

        // Redirigir a la gestión de productos
        header('Location: ' . base_url . 'producto/gestion');
        exit;
    }

    public function eliminar()
    {
        Utils::isAdmin();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $producto = new Producto();
            $producto->setId($id);
            $delete = $producto->delete();

            if ($delete) {
                $_SESSION['delete'] = 'complete';
            } else {
                $_SESSION['delete'] = 'failed';

            }

        }
        header('Location: ' . base_url . 'producto/gestion');
    }
    public function editar()
    {
        Utils::isAdmin();

        if (isset($_GET['id'])) {
            $editar = true;

            $producto = new Producto();
            $producto->setId($_GET['id']);

            $prod = $producto->getOne();
            require_once('views/productos/crear.php');

        } else {
            header('Location' . base_url . 'producto/gestion');
        }
    }

    public function ver()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $producto = new Producto();
            $producto->setId($id);

            $product = $producto->getOne();

        }
        require_once 'views/productos/ver.php';
    }

}
?>