<?php

require_once "models/categorias.php";
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
}
?>