<?php
require '../../config/config.php';
require '../../config/database.php';
require '../../config/session.php';


$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $con->prepare("SELECT id,R,G,B FROM color WHERE id = $id");
    $sql->execute();
    $color = $sql->fetch(PDO::FETCH_ASSOC);  

}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tienda final</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                            <a href="../Color/gestionColor.php" class="nav-link active">Disponibilidad</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Talla/formTalla.php" class="nav-link active">Dias Accesibles</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Categoria/gestionCategoria.php" class="nav-link active">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Producto/formProducto.php" class="nav-link">Producto</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Producto/formProductoCargado.php" class="nav-link">Publicar</a>
                        </li>
                    </ul>

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-success">
                            <img src="img/Perfil.png" alt="">
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
        <div class="container">
            <form id="editarColorForm" onsubmit="event.preventDefault(); editarColor();">
                <div class="card m-5" style="width: 30rem;">
                    <div class="card-header">
                        Editar Disponibilidad
                    </div>
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="R" class="form-label">Color de Disponibilidad</label>
                            <input type="number" class="form-control" id="R" name="R" required
                                value="<?php echo $color['R']; ?>" placeholder="ingresar tono rojo">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="G" name="G" required
                                value="<?php echo $color['G']; ?>" placeholder="ingresar tono verde">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" id="B" name="B" required
                                value="<?php echo $color['B']; ?>" placeholder="ingresar tono azul">
                            <input type="hidden" id="idColor" name="idColor" value="<?php echo $color['id']; ?>">
                        </div>
                        <button type="submit" class="btn btn-outline-info btn-lg">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../../js/controladorColor.js"></script>
</body>

</html>