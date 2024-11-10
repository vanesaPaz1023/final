<?php
require '../../config/config.php';
require '../../config/database.php';
require '../../config/session.php';


$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = $con->prepare("SELECT id,nombre,estado FROM categoria WHERE id = $id");
    $sql->execute();
    $categoria = $sql->fetch(PDO::FETCH_ASSOC);  

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
                            <a href="../../form/Color/formColor.php" class="nav-link">Color</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Talla/formTalla.php" class="nav-link">Talla</a>
                        </li>
                        <li class="nav-item">
                            <a href="gestionCategoria.php" class="nav-link">Categoria</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Producto/formProducto.php" class="nav-link">Producto</a>
                        </li>
                        <li class="nav-item">
                            <a href="../../form/Producto/formProductoCargado.php" class="nav-link">Publicar</a>
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
                                        src="../img/candado.png" alt="">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <form id="categoriaForm" onsubmit="event.preventDefault(); editarCategoria();">
                <div class="card m-5" style="width: 30rem;">
                    <div class="card-header">
                        Agregar Categoría
                    </div>
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="catNombre" class="form-label">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="catNombre" name="catNombre"
                                value="<?php echo $categoria['nombre']; ?>" required aria-describedby="nombreHelp"
                                required placeholder="Ingrese el nombre de la categoría">
                            <input type="hidden" id="idCategoria" name="idCategoria"
                                value="<?php echo $categoria['id']; ?>">
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="0" <?php if($categoria['estado'] == 0) echo 'selected'; ?>>Inactivo
                                    </option>
                                    <option value="1" <?php if($categoria['estado'] == 1) echo 'selected'; ?>>Activo
                                    </option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" id="btnCategoria" class="btn btn-outline-info btn-lg">Actualizar</button>
                    </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="../../js/controladorCategoria.js"></script>
</body>

</html>