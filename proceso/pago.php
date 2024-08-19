<?php
    
    require '../config/database.php';
    require '../config/session.php';

    $sessionActual = Session::getInstance();
    if(isset($_POST['ncuenta'])){
        $ncuenta = $_POST['ncuenta'];
        if (!empty($ncuenta) && is_numeric($ncuenta)){
            if ($sessionActual->getProducto()!== null){
                $numFact= UltimoNumFactura();

                foreach ($sessionActual->getProducto() as $idProd => $cantidad) {
                    reducirCantidadItem($idProd,$cantidad);
                    agregarProductoDetalleItem($idProd,$cantidad,$numFact);
                    eliminar($idProd);
                }
                $datos['ok']= true;
            }
            else{
                $datos['ok']= false;
            }
        }
        else{
            $datos['ok']= false;
        }
    }
    else{
        $datos['ok']= false;
    }
    
echo json_encode($datos);

function reducirCantidadItem($id,$cantidad){
    $res = false;
    if ($id >0 && $cantidad > 0 && is_numeric($cantidad)){
        
        $db = new Database();
        $con = $db->conectar();

        $sql = $con->prepare("UPDATE producto SET unidad = unidad - ? WHERE id = ?");
        $sql->execute([$cantidad, $id]);

        $res= true;
    }
    return $res;
}
function agregarProductoDetalleItem($id, $unidad, $numFact) {
    $db = new Database();
    $con = $db->conectar();
    
    $sql = $con->prepare("
        INSERT INTO detalle (nombre, unidad, precio, productoid, facturaid)
        SELECT nombre, :cantidad, precio, id, :numFact
        FROM producto
        WHERE id = :id
    ");
    
    $sql->execute([
        ':cantidad' => $unidad,
        ':numFact' => $numFact,
        ':id' => $id
    ]);
}
function UltimoNumFactura(){
    $db = new Database();
    $con = $db->conectar();
    if(!isset($_SESSION['usuario']['id'])){
        exit;
    }
    $personaId= $_SESSION['usuario']['id'];
    $sql = $con->prepare("INSERT INTO factura (personaId) VALUES (?)");
    $sql->execute([$personaId]);

    $sql = $con->prepare("SELECT max(id) as conteo from factura");
    $sql->execute();

    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result['conteo'];
}
function eliminar($id){
    if(isset($_SESSION['carrito']['producto'][$id])){
        unset($_SESSION['carrito']['producto'][$id]);
        return true;
    }
    else
        return false;
}
?>