<?php
require 'config/config.php';
require 'config/database.php';
require 'config/session.php';


$sessionActual = Session::getInstance();
$db = new Database();
$con = $db->conectar();

$productos = $sessionActual->getProducto();
$listCarrito = array();

if ($productos!= null){
    foreach ($productos as $idProd => $cantidad){
        $sql = $con->prepare("SELECT producto.id as id,producto.nombre as nombre,producto.precio as precio,producto.unidad as unidad,$cantidad as cantidad,categoria.nombre as categoria from producto inner join categoria on producto.categoriaId=categoria.id WHERE producto.estado = 1 AND producto.id=? AND producto.unidad !=0 ");
        $sql->execute([$idProd]);
        $listCarrito[]= $sql ->fetch(PDO::FETCH_ASSOC);
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tienda final</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="css/estilos.css" rel="stylesheet">
    </head>
    <body>
    <header data-bs-theme="dark">
        <div class="navbar navbar-expand-lg navbar-dark bg-info">
            <div class="container">
                <a href="index.php" class="navbar-brand">
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
                    <li class="nav-item dropdown d-flex">
                        <a class="nav-link dropdown-toggle text-center text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $sessionActual->getUsuario()['correo'] ?>
                        </a>
                        <ul class="dropdown-menu text-center bg-primary">
                            <img src="img/Perfil.png"alt="">
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "Tipo: ". $sessionActual->getUsuario()['rol'] ?></a></li>
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "Cedula: ". $sessionActual->getUsuario()['cedula'] ?></a></li>
                            <li><a class="dropdown-item text-center"  href="#"><?php echo "nombre: ". $sessionActual->getUsuario()['nombre'] ?></a></li>
                            <li><a class="dropdown-item text-center" href="config/cerrarSesion.php">Cerrar Sesion</a></li>
                        </ul>
                    </li>
                  
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="row p-5">
                <div class="col-md-8">
                    <div class="table-response">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Sub total</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($listCarrito==null){
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista Vacia</b></td></tr>';
                                }
                                else{
                                    $total = 0;
                                    foreach($listCarrito as $productos){
                                        $_id = $productos['id'];
                                        $nombre = $productos['nombre'];
                                        $precio = $productos['precio'];
                                        $unidad = $productos['unidad'];
                                        $cantidad = $productos['cantidad'];
                                        $subtotal = $cantidad * $precio;
                                        $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo $nombre; ?></td>
                                    <td><?php echo $sessionActual->getMoneda(). number_format($precio,2,'.',','); ?></td>
                                    <td><input type="number" min="1" max= "<?php echo $unidad; ?>" value="<?php echo $cantidad; ?>" 
                                        size="5" id="cant_<?php echo $_id; ?>" onchange="editarCantidadItem(this.value,<?php echo $_id; ?>)"> </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]"><?php echo $sessionActual->getMoneda(). number_format($subtotal,2,'.',','); ?></div>
                                    </td>
                                    <td>
                                        <a href="#" id="eliminar" class="btn btn-danger btn-sm" data-bs-id = "<?php echo $_id; ?>"
                                        data-bs-toggle="modal" data-bs-target="#eliminarModal">Eliminar</a>
                                    </td>
                                </tr>
                                    
                                <?php } ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <p class="h3" id="total"><?php echo $sessionActual->getMoneda() . number_format($total,2,'.',','); ?></p>
                                    </td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <div class="alert alert-warning alert-dismissible fade show d-none"  id="mens" role="alert">
                            <strong>Nota</strong>!</strong> !! Numero de cuenta es requerido!!.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <h3 class="text-center"> <strong>Proceso De Pago</strong></h3>
                        <div id="qrcode" class="d-flex justify-content-center">
                            <?php if($sessionActual->getProducto() !=null && count($sessionActual->getProducto()) > 0 ){ ?>
                                <img src="https://api.qrserver.com/v1/create-qr-code/?data='<?php echo $sessionActual->getNumCart(); ?>'&amp;size=100x100" alt="" title="" />
                            <?php  } else {?>
                                <img src="" alt=""  title="" />
                            <?php  }  ?>  
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Cedula</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1"  readonly  value="<?php echo $sessionActual->getUsuario()['cedula']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" readonly  value="<?php echo $sessionActual->getUsuario()['nombre']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">telefono</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" readonly  value="<?php echo $sessionActual->getUsuario()['telefono']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="ncuenta" class="form-label">Numero de cuenta</label>
                        <input type="email" class="form-control"placeholder="Ingrese Numero de cuenta" name="ncuenta" id="ncuenta">
                    </div>
                    <div class="mb-3 text-center">
                            <button class="btn btn-outline-info btn-lg" onclick="registrarPago()"> Realiza tu Pagar</button>
                    </div>    
                </div> 
            </div>

        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eliminarModalLabel">Eliminar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Esta seguro de eliminar el producto?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button id="btn-eliminar" type="button" class="btn btn-danger" onclick="EliminarItem()">Eliminar</button>
            </div>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                El campo numero de cuenta es requerido
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Cerrar</button>
            </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>                        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/Controlador.js"></script> 
</body>
</html>