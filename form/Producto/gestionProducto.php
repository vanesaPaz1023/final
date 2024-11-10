<?php
require '../../config/config.php';
require '../../config/database.php';
require '../../config/session.php';

$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

// Lógica para eliminar una categoría
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = $con->prepare("SELECT COUNT(*) AS count FROM detalle WHERE productoId = $id");
    $sql->execute();
    $detalle = $sql->fetch(PDO::FETCH_ASSOC);

    $sql = $con->prepare("SELECT COUNT(*) AS count FROM productotalla WHERE productoId = $id");
    $sql->execute();
    $productoTalla = $sql->fetch(PDO::FETCH_ASSOC);
    
    
    if ($detalle['count'] > 0 || $productoTalla['count']) {
        $alerta = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                   <strong>Nota</strong> No se puede eliminar producto devido a las relacionada que tiene
                   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                   </div>";    
    }
    else{
        $alerta="";
        $sql = $con->prepare("DELETE FROM producto WHERE id=$id");
        $sql->execute(); 

        $imagen = '../../img/productos/'.$id.'.jpeg';
        if (file_exists($imagen)) {
            unlink($imagen);
        }
        header("Location: gestionProducto.php");
    }
}

$sql = $con->prepare("
    SELECT 
    p.nombre as nombre,
    p.descripcion as descripcion,
    p.unidad as unidad,
    p.precio as precio,
    p. estado as estado,
    p.id as id, 
    c.id as idCategoria,
    c.nombre as nomCategoria 
    FROM 
    producto p INNER JOIN categoria c 
    ON p.categoriaId = c.id
");
$sql->execute(); 
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <div class="navbar navbar-expand-lg navbar-dark bg-personalizado">
            <div class="container">
                <a class="navbar-brand" href="../../HomeAdmin.php">
                    <img src="../../img/logo.jpg" class="logo" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a href="../../form/Talla/gestionTalla.php" class="nav-link">Dias Accesibles</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Color/gestionColor.php" class="nav-link">Disponibilidad</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Categoria/gestionCategoria.php" class="nav-link">Categoria</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Producto/gestionPublicado.php" class="nav-link">Publicar</a>
                        </li>
                    </ul>

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-success">
                            <img src="../../img/Perfil.png" alt="">
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Tipo: ". $sessionActual->getUsuario()['rol'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Cedula: ". $sessionActual->getUsuario()['cedula'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "nombre: ". $sessionActual->getUsuario()['nombre'] ?></a></li>
                            <li><a class="dropdown-item text-center" href="../../config/cerrarSesion.php"><img
                                        src="../../img/candado.png" alt="">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container mt-5">
            <h2>Gestión de Productos</h2>
            <a href="crearProducto.php" class="btn btn-success mb-3">Agregar Producto</a>
            <?php 
                if (isset($alerta) && !empty($alerta)) {
                    echo $alerta;
                    $alerta="";
                }
            
            ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Unidad</th>
                        <th>Precio</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($productos as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['unidad']; ?></td>
                        <td><?php echo $row['precio']; ?></td>
                        <td><?php echo $row['nomCategoria']; ?></td>
                        <td><?php echo $row['estado'] ? 'Activo' : 'Inactivo'; ?></td>
                        <td>
                            <a href="editarProducto.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Editar</a>
                            <a href="gestionProducto.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta categoría?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../../js/controladorCategoria.js"></script>
</body>

</html>