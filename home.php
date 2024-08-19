<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'config/usuario.php';


$sessionActual = Session::getInstance();

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT producto.id as id,producto.nombre as nombre,producto.precio as precio,categoria.nombre as categoria 
                    from producto inner join categoria on producto.categoriaId=categoria.id where producto.estado = 1 AND producto.unidad !=0");
$sql->execute();
$res = $sql ->fetchall(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tienda final</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="css/estilos.css" rel="stylesheet">
        <script src="js/Controlador.js"></script> 
    </head>
    <body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <strong>Trabajo final</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
                            <a href="#" class="nav-link active">Catalogo</a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">Contacto</a>
                        </li> -->
                    </ul>

                    <a href="GestionCarrito.php" class="btn btn-info"><i class="bi bi-cart4 text-white"></i> 
                        <span id="num_cart" class="badge bg-danger"><?php if ( $sessionActual->getNumCart() != 0 )echo $sessionActual->getNumCart() ; else echo ''; ?></span>
                    </a>

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-info">
                            <img src="img/Perfil.png"alt="">
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "Tipo: ". $sessionActual->getUsuario()['rol'] ?></a></li>
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "Cedula: ". $sessionActual->getUsuario()['cedula'] ?></a></li>
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "nombre: ". $sessionActual->getUsuario()['nombre'] ?></a></li>
                            <li><a class="dropdown-item text-center" href="config/cerrarSesion.php"><img src="img/candado.png" alt="">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row m-5 row-cols-1 row-cols-sm-1 row-cols-md-1 ">
                    <form  metho class="d-flex justify-content-center align-items-center" role="search">
                        <label for="Search" class="m-2"> <strong>Categoria</strong> </label>                  
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="Search">
                        
                        <!-- <button class="btn btn-outline-success" type="submit">Search</button>  -->
                         <!-- <a href="proceso/filtro.php?valor=zapato">buscar</a> -->
                    </form>  
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3" id="conte-productos">
                <?php foreach($res as $row) {?>
                    <div class="col">
                        <div class="card">
                            <?php
                                $id = $row['id'];
                                $nombre = $row['nombre'];
                                $precio = number_format($row['precio'],2,'.',',');
                                $categoria = $row['categoria'];
                                $img = "img/productos/".$id.".jpeg";

                                if (!file_exists($img)){
                                    $img= "img/productos/no-img.png";
                                }
                            ?>
                            <img src="<?php echo $img; ?> " class="d-block w-100" style="height:18rem;"> 
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $nombre; ?></h4>
                                <h5 class="card-title"><?php echo $categoria; ?></h5>
                                <p class="card-text"><?php echo $sessionActual->getMoneda() . $precio; ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="detalle.php?id=<?php echo $id; ?>" class="btn btn-outline-info">Detalles</a>
                                    </div>
                                    <!-- <a href="proceso/carrito.php?id=<?php echo $id; ?>&token=<?php echo hash_hmac('sha1',$id,$sessionActual->getKeyToken()); ?>">Add2</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }?>
            </div>
        </div>
    </main>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>                        
    <script src="js/Controlador.js"></script>
</body>
</html>