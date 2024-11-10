<?php
require 'config/session.php';
require 'config/database.php';

$sessionActual = Session::getInstance();


$db = new Database();
$con = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

// if($id == '' || $token == ''){
if($id == ''){
    echo 'Erroor al procesar la peticion';
    exit;
}
else{

    $token_tmp = hash_hmac('sha1',$id,$sessionActual->getKeyToken());
    // if ( $token == $token_tmp){
        
        
        $sql = $con->prepare("select count(id) from producto where id=? And estado = 1");
        $sql->execute([$id]);

        if($sql-> fetchColumn()>0){
            $sql = $con->prepare("select producto.id as id,producto.nombre as nombre,producto.descripcion as descripcion,producto.precio as precio,categoria.nombre as categoria from producto inner join categoria on producto.categoriaId=categoria.id where producto.id = ? And producto.estado = 1");
            $sql->execute([$id]);
            $res = $sql ->fetch(PDO::FETCH_ASSOC);

            $nombre = $res['nombre'];
            $descripcion = $res['descripcion'];
            $precio = number_format($res['precio'],2,'.',',');
            $categoria = $res['categoria'];
            $img = "img/productos/".$id.".jpeg";

            $sql = $con->prepare("SELECT distinct(t.id) as id,t.nombre as nombre FROM productotalla as pt inner join talla as t on pt.tallaid=t.id inner join producto as p on p.id= pt.productoid where p.id = ?");
            $sql->execute([$id]);
            $res2 = $sql ->fetchall(PDO::FETCH_ASSOC);

            if (!file_exists($img)){
                $img= "img/productos/no-img.png";
            }
        }

    // }
    else{
        echo 'Erroor al procesar la peticion';
        exit; 
    }

}

// $sql = $con->prepare("select producto.id as id,producto.nombre as nombre,producto.precio as precio,categoria.nombre as categoria from producto inner join categoria on producto.categoriaId=categoria.id where producto.estado = 1");
// $sql->execute();
// $res = $sql ->fetchall(PDO::FETCH_ASSOC);

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
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="HomeCliente.php" class="navbar-brand">
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
            <div class="row p-5">
                <div class="col-md-6 order-md-1">
                    <img src="<?php echo $img; ?>">
                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>
                    <h2><?php echo "Precio ". $sessionActual->getMoneda(). $precio; ?></h2>
                    <p class="lead">
                        <?php echo "Precio ". $descripcion; ?>
                    </p>
                    <div class="form-group">
                        <labe l for="talla">Selecciona los dias accesibles</label>
                            <select class="form-control" id="talla" name="talla"
                                onchange="mostrarColores(<?php echo $id; ?>)">
                                <option value="0" selected disabled hidden>Seleccionar dia </option>
                                <?php foreach($res2 as $row) {?>
                                <option value=' <?php echo $row["id"] ?>'> <?php echo $row["nombre"] ?></option>
                                <?php }?>
                            </select>
                    </div>   
                    <div class="form-group p-4" id="color">

                    </div>

                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group me-2" role="group" aria-label="First group" id="color">
                        </div>
                    </div>

                    <div class="d-grid gap-3 col-5 mx-auto">
                        <button class="btn btn-outline-info" type="button"
                            onclick="addItemProducto(<?php echo $id; ?>)">Agregar al carrito ya</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="js/Controlador.js"></script>
</body>