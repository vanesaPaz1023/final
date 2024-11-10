<?php
require '../../config/config.php';
require '../../config/database.php';
require '../../config/session.php';


$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT * FROM Categoria WHERE estado = 1");
$sql->execute(); 
$categorias = $sql->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

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
    WHERE p.id= $id
");
$sql->execute(); 
$producto = $sql->fetch(PDO::FETCH_ASSOC);

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
                            <a href="#" class="nav-link active">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Color/formColor.php" class="nav-link">Disponibilidad</a>
                        </li>
                        <li class="nav-item">
                            <a href="../Talla/formTalla.php" class="nav-link">Dias accesibles</a>
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
        <div class="container">
            <form id="editarProductoForm" enctype="multipart/form-data"
                onsubmit="event.preventDefault(); editarProducto();">
                <div class="card m-5" style="width: 30rem;">
                    <div class="card-header">Editar Producto</div>
                    <div class="p-3">
                        <div class="mb-3">
                            <label for="imagen" class="form-label">Imagen del producto</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept=".jpeg">
                        </div>
                        <div class=" mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                value="<?php echo $producto['nombre']; ?>" placeholder="Ingrese el nombre del producto">
                            <input type="hidden" id="id" name="id" value="<?php echo $producto['id']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="descripcion" name="descripcion" required
                                value="<?php echo $producto['descripcion']; ?>"
                                placeholder="Ingrese la descripción del producto">
                        </div>
                        <div class="mb-3">
                            <label for="unidad" class="form-label">Unidad</label>
                            <input type="number" class="form-control" id="unidad" name="unidad" required min="0"
                                value="<?php echo $producto['unidad']; ?>" placeholder="Ingrese la unidad del producto">
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="precio" name="precio" required min="0"
                                step="0.01" value="<?php echo $producto['precio']; ?>"
                                placeholder="Ingrese el precio del producto">
                        </div>
                        <div class="mb-3">
                            <label for="categoria" class="form-label">Categoría</label>
                            <select class="form-control" id="categoria" name="categoria" required>
                                <option value="">Seleccione una categoría</option>
                                <?php foreach ($categorias as $row) { ?>
                                <option value="<?php echo $row['id']; ?>"
                                    <?php echo ($row['id'] == $producto['idCategoria']) ? 'selected' : ''; ?>>
                                    <?php echo $row['nombre']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label for="estado">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="0" <?php if($producto['estado'] == 0) echo 'selected'; ?>>Inactivo
                                    </option>
                                    <option value="1" <?php if($producto['estado'] == 1) echo 'selected'; ?>>Activo
                                    </option>
                                </select>
                            </div>
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
    <script src="../../js/controladorProducto.js"></script>
</body>

</html>