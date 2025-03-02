<?php
require_once 'models/pedido.php';
require_once 'helpers/emailHelpers.php';


class pedidoController
{
    public function hacer()
    {

        require_once 'views/pedido/hacer.php';

    }
    public function add()
    {
        if (isset($_SESSION['identity'])) {
            // Obtener el id del usuario logueado
            $usuario_id = $_SESSION['identity']->id;

            // Obtener los datos del formulario
            $provincia = isset($_POST['provincia']) ? $_POST['provincia'] : false;
            $localidad = isset($_POST['localidad']) ? $_POST['localidad'] : false;
            $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : false;

            // Obtener el total del carrito
            $stats = Utils::statsCarrito();
            $coste = $stats['total'];

            // Verificar que los campos están completos
            if ($provincia && $localidad && $direccion) {
                // Crear el objeto Pedido y guardar los datos
                $pedido = new pedido();
                $pedido->setUsuario_id($usuario_id);
                $pedido->setProvincia($provincia);
                $pedido->setLocalidad($localidad);
                $pedido->setDireccion($direccion);
                $pedido->setCoste($coste);

                // Guardar el pedido
                $save = $pedido->save();

                // Guardar las líneas del pedido
                $save_linea = $pedido->save_linea();

                // Verificar si se guardó correctamente
                if ($save && $save_linea) {
                    $_SESSION['pedido'] = "complete"; // Pedido completado
                } else {
                    $_SESSION['pedido'] = "failed"; // Fallo al guardar el pedido
                }
            } else {
                $_SESSION['pedido'] = "failed"; // Fallo si no se completaron los campos
            }

            // Redirigir a la página de confirmación
            header("Location:" . base_url . 'pedido/confirmado');
        } else {
            // Redirigir al inicio si el usuario no está logueado
            header("Location:" . base_url);
        }
    }


    public function confirmado()
    {
        if (isset($_SESSION['identity'])) {
            // Obtener la información del usuario que está logueado
            $identity = $_SESSION['identity'];

            // Crear un objeto de la clase Pedido
            $pedido = new Pedido();
            $pedido->setUsuario_id($identity->id);

            // Obtener el último pedido del usuario
            $pedido = $pedido->getOneByUser();

            // Si hay un pedido, obtenemos los productos asociados a ese pedido
            if ($pedido) {
                $pedido_productos = new Pedido();
                $productos = $pedido_productos->getProductosByPedido($pedido->id);

                // Construir array con los detalles del pedido
                $detallesPedido = [
                    'productos' => [],
                    'total' => $pedido->coste
                ];

                foreach ($productos as $producto) {
                    $detallesPedido['productos'][] = [
                        'nombre' => $producto->nombre,
                        'cantidad' => $producto->unidades,
                        'precio' => $producto->precio
                    ];
                }

                // Enviar el correo de confirmación
                $resultadoCorreo = enviarCorreoPedido($identity->email, $identity->nombre, $detallesPedido);

                if ($resultadoCorreo === true) {
                    echo "Pedido realizado con éxito. Te hemos enviado un correo.";
                } else {
                    echo "Error al enviar el correo: " . $resultadoCorreo;
                }
            }
        }

        // Cargar la vista
        require_once 'views/pedido/confirmado.php';
    }

    public function misPedidos()
    {
        // Verificar si el usuario está autenticado
        Utils::isIdentity();

        // Obtener el ID del usuario desde la sesión
        $usuario_id = $_SESSION['identity']->id;

        // Crear una instancia de la clase Pedido
        $pedido = new Pedido();

        // Establecer el usuario_id
        $pedido->setUsuario_id($usuario_id);

        // Obtener todos los pedidos del usuario
        $pedidos = $pedido->getAllByUser();

        // Incluir la vista de los pedidos
        require_once 'views/pedido/misPedidos.php';
    }

    public function detalle()
    {
        // Verificar si el usuario está autenticado
        Utils::isIdentity();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Sacar el pedido con el ID proporcionado
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedidoDetails = $pedido->getOne();

            // Sacar los productos del pedido
            $pedido_productos = new Pedido();
            $productos = $pedido_productos->getProductosByPedido($id);

            // Pasar los datos a la vista
            require_once 'views/pedido/detalle.php';
        } else {
            // Si no hay un ID en la URL, redirigir al listado de pedidos
            header('Location:' . base_url . 'pedido/mis_pedidos');
        }
    }

    public function gestion()
    {
        // Verificar si el usuario tiene permisos de admin
        Utils::isAdmin();

        // Variable para controlar la vista
        $gestion = true;

        // Obtener todos los pedidos
        $pedido = new Pedido();
        $pedidos = $pedido->getAll();

        // Cargar la vista de los pedidos
        require_once 'views/pedido/misPedidos.php';
    }

    public function estado()
    {
        Utils::isAdmin();
        if (isset($_POST['pedido_id']) && isset($_POST['estado'])) {
            // Recoger datos form
            $id = $_POST['pedido_id'];
            $estado = $_POST['estado'];

            // Upadate del pedido
            $pedido = new Pedido();
            $pedido->setId($id);
            $pedido->setEstado($estado);
            $pedido->edit();

            header("Location:" . base_url . 'pedido/detalle&id=' . $id);
        } else {
            header("Location:" . base_url);
        }
    }




}
?>