<?php
require_once 'config/database.php';
require_once 'config/session.php';
require_once 'config/usuario.php';


$sessionActual = Session::getInstance();

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT 
p.id as id,
p.nombre as nombre,
p.precio as precio,
c.nombre as categoria 
from productotalla pt 
INNER JOIN producto p 
ON pt.productoId = p.id
inner join categoria c
ON c.id = p.categoriaId
where p.estado = 1 AND p.unidad !=0");
$sql->execute();
$res = $sql ->fetchall(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIGMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="css/estilos.css" rel="stylesheet">
    <script src="js/Controlador.js"></script>
</head>

<body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <strong>SIGMA</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader"
                    aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarHeader">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

                    <a href="GestionCarrito.php" class="btn btn-info"><i class="bi bi-cart4 text-white"></i>
                        <span id="num_cart"
                            class="badge bg-danger"><?php if ( $sessionActual->getNumCart() != 0 )echo $sessionActual->getNumCart() ; else echo ''; ?></span>
                    </a>

                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-info">
                            <img src="img/Perfil.png" alt="">
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Tipo: ". $sessionActual->getUsuario()['rol'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "Cedula: ". $sessionActual->getUsuario()['cedula'] ?></a></li>
                            <li><a class="dropdown-item text-center"
                                    href="#"><?php echo "nombre: ". $sessionActual->getUsuario()['nombre'] ?></a></li>
                            <li><a class="dropdown-item text-center" href="config/cerrarSesion.php"><img
                                        src="img/candado.png" alt="">Cerrar Sesion</a></li>
                        </ul>
                    </li>

                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row m-5 row-cols-1 row-cols-sm-1 row-cols-md-2  d-flex justify-content-center">
                <form metho class="d-flex justify-content-center align-items-center" role="search">
                    <label for="Search" class="m-2"> <strong>Categoria</strong> </label>
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="Search">
                </form>
            </div>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 d-flex justify-content-center"
                id="conte-productos">
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
                                    <a href="detalle.php?id=<?php echo $id; ?>" class="btn btn-outline-info">Comprar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
        </div>
    </main>

    <footer class="bg-info text-white pt-4 mt-5">
        <div class="container">
            <div class="row">
                <!-- Información de la Empresa -->
                <div class="col-md-4">
                    <h5>Sobre Nosotros</h5>
                    <p>
                        Somos una empresa dedicada a la digitalización,
                        especializada en transformar tus procesos y optimizar
                        tu negocio. Ofrecemos soluciones innovadoras 
                        y personalizadas para que aproveches al máximo la tecnología.
                        Nuestro compromiso es garantizar una experiencia excepcional 
                        en cada etapa de tu transición digital.
                    </p>
                </div>

                <!-- Enlaces de Navegación -->
                <div class="col-md-4">
                    <h5>Enlaces Útiles</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-white">Política de Privacidad</a></li>
                        <li><a href="#" class="text-white">Preguntas Frecuentes</a></li>
                        <li><a href="#" class="text-white">Contáctanos</a></li>
                    </ul>
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-4">
                    <h5>Síguenos</h5>
                    <a href="#" class="text-white mr-2"><i class="fab fa-facebook-f"></i>En Facebook /SigmaSystem</a><br>
                    <a href="#" class="text-white mr-2"><i class="fab fa-twitter"></i>En Twitter @SigmaSys</a><br>
                    <a href="#" class="text-white mr-2"><i class="fab fa-instagram"></i>En Instagram @SigmaSt</a><br>
                    <a href="#" class="text-white mr-2"><i class="fab fa-linkedin"></i>En Linkedin /En/SigmaSistema</a>
                </div>
            </div>

            <hr class="bg-light">

            <!-- Derechos reservados -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mb-0">&copy; 2024 Tu Empresa. Todos los derechos reservados.</p>
                </div>
            </div>
        </div>
    </footer>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/Controlador.js"></script>
</body>

</html>