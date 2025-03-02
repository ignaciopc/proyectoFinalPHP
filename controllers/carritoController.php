<?php
require_once 'models/producto.php';
class carritoController
{
    public function index()
    {
        // Verificar si existe el carrito en la sesión o en la cookie
        if (!isset($_SESSION['carrito']) && isset($_COOKIE['carrito'])) {
            // Si no existe en sesión, pero sí en la cookie, cargamos el carrito desde la cookie
            $_SESSION['carrito'] = json_decode($_COOKIE['carrito'], true);
        }

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

        // Guardar el carrito en la cookie (durará 30 días)
        setcookie('carrito', json_encode($_SESSION['carrito']), time() + (30 * 86400), "/", "", false, true); // HttpOnly

        // Redirigir a la página del carrito
        header("Location: " . base_url . "carrito/index");
        exit();
    }

    public function delete()
    {
        // Eliminar el carrito de la sesión y de la cookie
        unset($_SESSION["carrito"]);
        setcookie('carrito', '', time() - 3600, "/", "", false, true); // Eliminar la cookie

        header("Location: " . base_url . "carrito/index");
        exit();
    }

    public function deleteEspecifico()
    {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            unset($_SESSION['carrito'][$index]);

            // Guardar la sesión actualizada en la cookie
            setcookie('carrito', json_encode($_SESSION['carrito']), time() + (30 * 86400), "/", "", false, true); // HttpOnly
        }
        header("Location: " . base_url . "carrito/index");
        exit();
    }

    function up()
    {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']++;

            // Guardar la sesión actualizada en la cookie
            setcookie('carrito', json_encode($_SESSION['carrito']), time() + (30 * 86400), "/", "", false, true); // HttpOnly
        }
        header("Location: " . base_url . "carrito/index");
        exit();
    }

    function down()
    {
        if (isset($_GET['index'])) {
            $index = $_GET['index'];
            $_SESSION['carrito'][$index]['unidades']--;

            if ($_SESSION['carrito'][$index]['unidades'] == 0) {
                unset($_SESSION['carrito'][$index]);
            }

            // Guardar la sesión actualizada en la cookie
            setcookie('carrito', json_encode($_SESSION['carrito']), time() + (30 * 86400), "/", "", false, true); // HttpOnly
        }
        header("Location: " . base_url . "carrito/index");
        exit();
    }
}

?>