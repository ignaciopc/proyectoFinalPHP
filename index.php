<?php
session_start();
require_once 'autoload.php';
require_once 'views/layouts/header.php';
require_once 'views/layouts/sidebar.php';

if(isset($_GET['controller'])){
    $nombre_controlador = $_GET['controller'].'Controller';
	$archivo_controlador = 'controllers/' . $nombre_controlador . '.php';

		if(class_exists($nombre_controlador)){  
		$controlador = new $nombre_controlador();
        if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
            $action = $_GET['action'];
            $controlador->$action();
        }else{
            echo 'La página que buscas no existe';
        }
    }else{
        echo 'Error: El controlador no existe';
    }
} else {
    echo 'Error: No se ha especificado un controlador';
}

require_once 'views/layouts/footer.php';
?>


