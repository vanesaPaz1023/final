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
    $sql = $con->prepare("DELETE FROM productotalla WHERE id=$id");
    $sql->execute(); 
    header("Location: gestionPublicado.php");
    
}

$sql = $con->prepare("SELECT 
    pt.id as id,
    pt.unidad as unidad,
    t.nombre as tNombre,
    c.R as R,
    c.G as G,
    c.B as B,
    p.nombre as pNombre,
    p.id as pId
    FROM productotalla pt 
    INNER JOIN producto p ON pt.productoId= p.id 
    INNER JOIN talla t ON t.id = pt.tallaId 
    INNER JOIN color c ON c.id = pt.colorId WHERE p.estado= 1");
$sql->execute(); 
$publicacion = $sql->fetchAll(PDO::FETCH_ASSOC);
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
                            <a href="../../form/Producto/gestionProducto.php" class="nav-link">Producto</a>
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
            <h2>Gestión de Publicaciones</h2>
            <a href="crearPublicado.php" class="btn btn-success mb-3">Agregar publicacion</a>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Dias Accesibles</th>
                        <th>Disponibilidad</th>
                        <th>Unidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($publicacion as $row) { 
                        $rgb = "rgb(" . $row['R'] . ", " . $row['G'] . ", " . $row['B'] . ")";
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['pNombre']; ?></td>
                        <td><?php echo $row['tNombre']?></td>
                        <td style="background-color: <?php echo $rgb; ?>; width: 100px; height: 40px;">
                        <td><?php echo $row['unidad']?></td>
                        <td>
                            <a href="editarPublicado.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-primary">Editar</a>
                            <a href="gestionPublicado.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta Publicacion?');">Eliminar</a>
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
</body>

</html>