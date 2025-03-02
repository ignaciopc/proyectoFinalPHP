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
		// Verificar si se han recibido datos por POST
		if (isset($_POST)) {
			// Asignar los valores del formulario a variables locales
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$password = isset($_POST['password']) ? $_POST['password'] : false;

			// Inicializar un array para guardar los errores
			$errores = [];

			// Validación de nombre (campo obligatorio)
			if (empty($nombre)) {
				$errores[] = "El nombre es obligatorio.";
			}

			// Validación de apellidos (campo obligatorio)
			if (empty($apellidos)) {
				$errores[] = "Los apellidos son obligatorios.";
			}

			// Validación de correo electrónico (campo obligatorio y formato válido)
			if (empty($email)) {
				$errores[] = "El correo electrónico es obligatorio.";
			} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errores[] = "El correo electrónico no tiene un formato válido.";
			}

			// Validación de la contraseña (campo obligatorio y longitud mínima de 6 caracteres)
			if (empty($password)) {
				$errores[] = "La contraseña es obligatoria.";
			} elseif (strlen($password) < 6) {
				$errores[] = "La contraseña debe tener al menos 6 caracteres.";
			}

			// Si existen errores, redirigir al formulario con los mensajes de error
			if (count($errores) > 0) {
				$_SESSION['register'] = 'failed';  // Indicamos que la operación falló
				$_SESSION['errores'] = $errores;  // Guardamos los errores en la sesión
				header("Location: " . base_url . "/usuario/registro"); // Redirigimos al formulario
				exit; // Aseguramos que no se ejecute más código después de la redirección
			}

			// Si no hay errores, continuamos con la creación del usuario
			$usuario = new Usuario();
			$usuario->setNombre($nombre);
			$usuario->setApellidos($apellidos);
			$usuario->setEmail($email);
			$usuario->setPassword($password);  // Se debe realizar un hash de la contraseña antes de guardarla

			// Guardar el usuario en la base de datos
			$save = $usuario->save();

			// Comprobar si se ha guardado correctamente
			if ($save) {
				$_SESSION["register"] = "complete";  // Registro exitoso
			} else {
				$_SESSION["register"] = "failed";  // Si no se guardó, mostramos un fallo
			}
		} else {
			$_SESSION["register"] = "failed";  // Si no se envió el formulario
		}

		// Redirigir al formulario de registro
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
				// Si la autenticación fue exitosa, guardamos la sesión
				$_SESSION['identity'] = $identity;

				// Si el usuario es administrador, se guarda en sesión
				if ($identity->rol == 'admin') {
					$_SESSION['admin'] = true;
				}

				// Crear una cookie que dure 30 días
				// En este caso, almacenaremos el email del usuario, pero puedes cambiarlo por el ID o cualquier otro dato
				setcookie('usuario', $identity->email, time() + (30 * 86400), "/", "", false, true); // HttpOnly

			} else {
				// Si el login falla, mostramos un mensaje de error
				$_SESSION['error_login'] = 'Identificación fallida !!';
			}
		}

		// Redirigir a la página principal o a la página de inicio
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
				header("Location:" . base_url . "usuario/modificar"); // Redirigir al perfil
			} else {
				$_SESSION["update_error"] = ["Error al actualizar los datos."];
				header("Location:" . base_url . "usuario/modificar"); // Redirigir de nuevo al formulario de modificación
			}
		} else {
			$_SESSION["update_error"] = ["Error al procesar la solicitud."];
			header("Location:" . base_url . "usuario/modificar"); // Redirigir de nuevo al formulario de modificación
		}
	}

	public function gestionarUsuarios()
	{
		Utils::isAdmin();  // Verificar si es admin

		$usuario = new Usuario();
		$usuarios = $usuario->getAll();  // Obtener todos los usuarios

		require_once 'views/usuario/gestion.php';  // Vista para listar usuarios
	}

	public function editarUsuario()
	{
		Utils::isAdmin();  // Verificar si es admin

		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$usuario = new Usuario();
			$usuario->setId($id);

			// Obtener los datos del usuario a editar
			$userData = $usuario->getOne();
			if ($userData) {
				require_once 'views/usuario/editar.php';  // Vista para editar usuario
			} else {
				header('Location: ' . base_url . 'usuario/gestion');
			}
		} else {
			header('Location: ' . base_url . 'usuario/gestion');
		}
	}

	// Función para actualizar los datos de un usuario
	public function actualizarUsuario()
	{
		Utils::isAdmin();  // Verificar si es admin

		if (isset($_POST['id'])) {
			$id = $_POST['id'];
			$nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
			$apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
			$email = isset($_POST['email']) ? $_POST['email'] : false;
			$rol = isset($_POST['rol']) ? $_POST['rol'] : false;

			// Verificar si los datos son válidos
			if ($nombre && $apellidos && $email && $rol) {
				// Crear la instancia del modelo
				$usuario = new Usuario();
				$usuario->setId($id);
				$usuario->setNombre($nombre);
				$usuario->setApellidos($apellidos);
				$usuario->setEmail($email);
				$usuario->setRol($rol);  // Actualizar el rol también

				// Actualizar el usuario en la base de datos
				$update = $usuario->update();

				if ($update) {
					$_SESSION['usuario'] = 'complete';
				} else {
					$_SESSION['usuario'] = 'failed';
				}
			} else {
				$_SESSION['usuario'] = 'failed';
			}
		}

		// Redirigir a la gestión de usuarios
		header('Location: ' . base_url . 'usuario/gestionarUsuarios');
	}

	// Función para eliminar un usuario
	public function eliminarUsuario()
	{
		Utils::isAdmin();  // Verificar si es admin

		if (isset($_GET['id'])) {
			$id = $_GET['id'];

			$usuario = new Usuario();
			$usuario->setId($id);
			$delete = $usuario->delete();

			if ($delete) {
				$_SESSION['delete'] = 'complete';
			} else {
				$_SESSION['delete'] = 'failed';
			}
		}

		// Redirigir a la gestión de usuarios
		header('Location: ' . base_url . 'usuario/gestionarUsuarios');
	}
}
?>