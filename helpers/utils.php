<?php

class Utils
{
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

    public static function isAdmin()
    {

        if (!isset($_SESSION["admin"])) {
            header("Location:" . base_url);
        } else {
            return true;
        }
    }

    public static function showCategorias()
    {
        require_once 'models/categorias.php';
        $categoria = new Categoria();
        $categorias = $categoria->getAll();
        return $categorias;
    }


    public static function statsCarrito()
    {
        // Inicializar las variables para contar y calcular el total
        $stats = array(
            'count' => 0,
            'total' => 0
        );

        // Comprobar si el carrito existe en la sesión
        if (isset($_SESSION['carrito'])) {
            $stats['count'] = count($_SESSION['carrito']); // Contar el número de productos en el carrito

            // Recorrer los productos en el carrito y calcular el total
            foreach ($_SESSION['carrito'] as $elemento) {
                $producto = $elemento['producto']; // Obtener el objeto producto
                $stats['total'] += $producto->precio * $elemento['unidades']; // Sumar el total
            }
        }

        return $stats; // Devolver los datos del carrito
    }

}



?>