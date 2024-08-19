<?php
  include_once 'config/config.php';
  include_once 'config/usuario.php';
  require 'config/session.php';
  include_once 'config/database.php';

  $sessionActual = Session::getInstance();
  $usuario = new Usuario();

  if (isset($_POST['nombre_user']) && isset($_POST['contrasena_user'])){
    
    $usarioForm = $_POST['nombre_user'];
    $passwordForm= $_POST['contrasena_user'];
  
    if($usuario->isUsuario($usarioForm,$passwordForm)){   

      $usuario->setUsuario($usarioForm);
      $sessionActual->setUsuario($usuario->getUsuario());

      if($sessionActual->getUsuario()['rol'] === "Administrador")
        header('Location:administrador.php'); 
      else
        header('Location:home.php');
    }
    else{
      $err="tus Credenciales estan incorrectas";
    }
  }
  else if ($sessionActual->getUsuario()!=null){
      header('Location:home.php');
  }
  else{
    header('Location:');
  }

?>


<!DOCTYPE html>
<html>
<head>
  <title>Página de inicio de sesión</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <!-- Formulario de inicio de sesión -->
        <form action="" method="POST">
          <?php
              if (isset($err)){
                echo $err;
              }
          ?>
          <h2 class="mt-5 mb-4">Iniciar sesión</h2>
          <!-- Campo de entrada para el nombre de usuario -->
          <div class="form-group">
            <input type="text" class="form-control" name="nombre_user" placeholder="Corre electronico" required>
          </div>
          <!-- Campo de entrada para la contraseña -->
          <div class="form-group">
            <input type="password" class="form-control" name="contrasena_user" placeholder="Contraseña" required>
          </div>
          <!-- Botón para enviar el formulario -->
          <button type="submit" class="btn btn-outline-info" name="login">Iniciar sesión</button>
        </form>
        <!-- Enlace para redirigir al formulario de registro -->
        <p class="mt-3">¿No tienes una cuenta? <a href="login/registro.html" class="text-info">Regístrate aquí</a></p>
      </div>
    </div>
  </div>
  

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
