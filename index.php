<?php
session_start();
require_once 'autoload.php';
require_once 'lib/Database.php';
require_once 'config/parameters.php';
require_once 'helpers/utils.php';
require_once 'views/layouts/header.php';
require_once 'views/layouts/sidebar.php';


$db = new Database();
function show_error(){
    $error = new errorController();
    $error->index();
}

if(isset($_GET['controller'])){
    //Sí existe el controlador haga:
   $nombre_controlador = $_GET['controller'].'Controller';
}elseif(!isset ($_GET['controller']) && !isset ($_GET['action'])){
    //Sí no existe el controlador y la acción, debe cargar el controlador default
    // configurado en el .htaccess 
    $nombre_controlador = controller_default;
}else{
    // Sino existe el error, llame la función de errores
    show_error();
    exit();
}

if(isset($nombre_controlador) && class_exists($nombre_controlador)){

    //Creo un nuevo objeto de la clase controladora
    $controlador = new $nombre_controlador();
    // Invocando los métodos automáticamente
    if(isset($_GET['action']) && method_exists($controlador, $_GET['action'])){
        $action = $_GET['action'];
        $controlador->$action();
    }elseif(!isset ($_GET['controller']) && !isset ($_GET['action'])){
    //Sí no existe el controlador y la acción, debe cargar el controlador default
    // configurado en el .htaccess 
        $action_default = action_default;
        $controlador->$action_default();
    }else{
        show_error();
    }
}else{
    show_error();
       
}

require_once 'views/layouts/footer.php';
?>