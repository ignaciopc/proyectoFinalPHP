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
    header('Location:' . base_url . 'categoria/index');

  }


  public function ver()
  {
    if (isset($_GET['id'])) {
      $categoria = new categoria();
      $categoria->setId($_GET['id']);
      $categoria = $categoria->getOne();

      $productos = new Producto();
      $productos->setCategoria_id($_GET['id']);
      $productos = $productos->getAllCategory();

    }
    require_once 'views/categorias/ver.php';
  }

  public function editar()
  {
    // Verifica que el usuario sea administrador
    Utils::isAdmin();

    // Verifica que se haya pasado un ID válido
    if (isset($_GET['id'])) {
      $categoria = new Categoria();
      $categoria->setId($_GET['id']);

      // Obtener los datos de la categoría a editar
      $categoria = $categoria->getOne();

      // Mostrar la vista de edición
      require_once 'views/categorias/editar.php';
    } else {
      // Si no se pasa un id válido, redirige al listado de categorías
      header('Location: ' . base_url . 'categoria/index');
    }
  }

  // Actualizar categoría
  public function update()
  {
    Utils::isAdmin(); // Verifica si el usuario es administrador

    if (isset($_POST['id']) && isset($_POST['nombre'])) {
      $categoria = new Categoria();
      $categoria->setId($_POST['id']);
      $categoria->setNombre($_POST['nombre']);
      $categoria->update(); // Actualizar la categoría

      $_SESSION['categoria'] = 'updated'; // Confirmación de éxito
    } else {
      $_SESSION['categoria'] = 'failed'; // Error si no se completó el formulario correctamente
    }

    header('Location: ' . base_url . 'categoria/index'); // Redirigir a la lista de categorías
  }

  // Eliminar categoría
  public function eliminar()
  {
      Utils::isAdmin(); // Verifica que el usuario es administrador
  
      if (isset($_GET['id'])) {
          $categoria = new Categoria();
          $categoria->setId($_GET['id']);
  
          $eliminado = $categoria->delete();
          if ($eliminado) {
              $_SESSION['mensaje'] = "Categoría eliminada correctamente.";
          } else {
              $_SESSION['error'] = "No se pudo eliminar la categoría.";
          }
      }
      
      header("Location: " . base_url . "categoria/index");
      exit();
  }
  

}
?>