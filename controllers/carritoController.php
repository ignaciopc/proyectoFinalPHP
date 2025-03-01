<?php
require_once 'models/producto.php';
class carritoController
{
    public function index()
    {
        // Asegurarse de que la sesión 'carrito' está inicializada
        require_once 'views/carrito/index.php';
    }

    public function add()
    {
        if (isset($_GET['id'])) {
            $producto_id = $_GET['id'];
        } else {
            // Si no existe el ID, redirigir al home
            header('Location: ' . base_url);
            exit();
        }

        // Verificar si ya existe el carrito en la sesión
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = []; // Si no está inicializado, lo inicializamos
        }

        $counter = 0;

        // Recorrer los productos del carrito
        foreach ($_SESSION['carrito'] as $indice => $elemento) {
            // Si el producto ya está en el carrito, incrementar la cantidad
            if ($elemento['id_producto'] == $producto_id) {
                $_SESSION['carrito'][$indice]['unidades']++;
                $counter++;
            }
        }

        // Si el producto no está en el carrito, añadirlo
        if (!isset($counter) || $counter == 0) {
            // Crear objeto producto
            $producto = new Producto();
            $producto->setId($producto_id);

            // Obtener los datos del producto
            $producto = $producto->getOne();

            // Verificar si se obtuvo correctamente el producto
            if (is_object($producto)) {
                // Agregar producto al carrito
                $_SESSION['carrito'][] = array(
                    "id_producto" => $producto->id,
                    "precio" => $producto->precio,
                    "unidades" => 1,
                    "producto" => $producto
                );
            }
        }

        // Redirigir a la página del carrito
        header("Location: " . base_url . "carrito/index");
        exit();
    }

    public function delete()
    {
        unset($_SESSION["carrito"]);
        header("Location:" . base_url . "carrito/index");
    }

}
?>