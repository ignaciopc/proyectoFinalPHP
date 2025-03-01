<?php

require_once "models/categorias.php";
require_once "models/producto.php";
class categoriaController
{
  public function index()
  {
    $categoria = new categoria();
    $categorias = $categoria->getAll();
    require_once "views/categorias/cat.php";
  }



  public function crear()
  {
    Utils::isAdmin();
    echo"asdadadad";
    require_once 'views/categorias/crear.php';
  }


  public function save()
  {
    Utils::isAdmin();
    if (isset($_POST) && isset($_POST['nombre'])) {
      $categoria = new categoria();
      $categoria->setNombre($_POST['nombre']);
      $categoria->save();
    }
    header( 'Location:' . base_url . 'categoria/index');

  }


  public function ver(){
    if (isset($_GET['id'])) {
      $categoria = new categoria();
        $categoria->setId($_GET['id']);
        $categoria =$categoria->getOne();

        $productos = new Producto();
        $productos->setCategoria_id($_GET['id']);
        $productos = $productos->getAllCategory();

    }
    require_once 'views/categorias/ver.php';
  }
}
?>