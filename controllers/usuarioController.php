<?php

require_once "models/usuario.php";
class usuarioController
{
	public function index()
	{
		echo "Controlador Usuarios, Acción index";
	}
	public function registro()
	{

		require_once "views/usuario/registro.php";
	}
	public function save()
	{
		if (isset($_POST)) {
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;
			// Validación de los campos
			$errores = [];

			// Validar nombre
			if (empty($nombre)) {
				$errores[] = "El nombre es obligatorio.";
			}

			// Validar apellidos
			if (empty($apellidos)) {
				$errores[] = "Los apellidos son obligatorios.";
			}

			// Validar correo electrónico
			if (empty($email)) {
				$errores[] = "El correo electrónico es obligatorio.";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errores[] = "El correo electrónico no tiene un formato válido.";
			}

			// Validar la contraseña
			if (empty($password)) {
				$errores[] = "La contraseña es obligatoria.";
			} elseif (strlen($password) < 6) {
				$errores[] = "La contraseña debe tener al menos 6 caracteres.";
			}

			// Si hay errores, redirigir y mostrar los mensajes
			if (count($errores) > 0) {
				$_SESSION['register'] = 'failed';
				$_SESSION['errores'] = $errores;
				header("Location: " . base_url . "/usuario/registro");
				exit; // Evitar continuar ejecutando el código después de redirigir
			}

			$usuario = new usuario();
			$usuario->setNombre($nombre);
			$usuario->setApellidos($apellidos);
			$usuario->setEmail($email);
			$usuario->setPassword($password);

			$save = $usuario->save();

			if ($save) {
				$_SESSION["register"] = "complete";
			} else {
				$_SESSION["register"] = "failed";


			}
		} else {
			$_SESSION["register"] = "failed";
		}
		header("Location:" . base_url . "usuario/registro");

	}




	public function login()
	{
		if ($_POST) {
			$usuario = new Usuario();
			$usuario->setEmail($_POST['email']);
			$usuario->setPassword($_POST['password']);
			$identity = $usuario->login();

			if ($identity) {
				$_SESSION['identity'] = $identity;
				if ($identity->rol == 'admin') {
					$_SESSION['admin'] = true;
				}
			} else {
				$_SESSION['error_login'] = 'Identificación fallida !!';
			}
		}
		header("Location: " . base_url);
	}


	public function logout()
	{
		if (isset($_SESSION['identity'])) {
			unset($_SESSION['identity']);
			# code...
		}

		if (isset($_SESSION['admin'])) {
			unset($_SESSION['admin']);
			# code...
		}
		header('Location:' . base_url . '');
	}


	public function modificar()
{
    Utils::isIdentity(); // Verificar que el usuario está autenticado

    if (isset($_POST)) {
        $id = $_SESSION['identity']->id;  // ID del usuario autenticado
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
        $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
        $email = isset($_POST['email']) ? trim($_POST['email']) : false;

        // Validaciones
        $errores = [];

        if (empty($nombre)) {
            $errores[] = "El nombre es obligatorio.";
        }

        if (empty($apellidos)) {
            $errores[] = "Los apellidos son obligatorios.";
        }

        if (empty($email)) {
            $errores[] = "El correo electrónico es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El correo electrónico no tiene un formato válido.";
        }

        // Si hay errores, redirigir al formulario con los errores
        if (count($errores) > 0) {
            $_SESSION['update_error'] = $errores;
            require_once 'views/usuario/modificar.php'; // Mostrar la vista con los errores
            exit; // Detener la ejecución del código aquí
        }

        // Si no hay errores, actualizamos los datos
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNombre($nombre);
        $usuario->setApellidos($apellidos);
        $usuario->setEmail($email);

        $save = $usuario->update();

        // Actualizar la sesión y redirigir
        if ($save) {
            $_SESSION['identity']->nombre = $nombre;
            $_SESSION['identity']->apellidos = $apellidos;
            $_SESSION['identity']->email = $email;
            $_SESSION["update_success"] = "Datos actualizados correctamente.";
            header("Location:" . base_url . "usuario/index"); // Redirigir al perfil
        } else {
            $_SESSION["update_error"] = ["Error al actualizar los datos."];
            header("Location:" . base_url . "usuario/modificar"); // Redirigir de nuevo al formulario de modificación
        }
    } else {
        $_SESSION["update_error"] = ["Error al procesar la solicitud."];
        header("Location:" . base_url . "usuario/modificar"); // Redirigir de nuevo al formulario de modificación
    }
}




}
?>