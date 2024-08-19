<?php
    
    require '../config/database.php';
    require '../config/session.php';

    $sessionActual = Session::getInstance();

    if(isset($_POST['action'])){
        $action = $_POST['action'];
        $id = isset($_POST['id']) ?  $_POST['id'] : 0;

        if($action=='agregar') {
                $cantidad = isset($_POST['cantidad']) ?  $_POST['cantidad'] : 0;    
                $resultado=agregar($id,$cantidad);
                if ($resultado >0)
                    $datos['ok']= true;
                else
                    $datos['ok']= false;
                $datos['sub'] = $sessionActual->getMoneda() . number_format($resultado,2,'.',',');
        }
        else if ($action=='color'){
            
            if(isset($_POST['idT'])){
                $idT= $_POST['idT'];
                $datos['ok']= true; 
                $datos['res']= color($id,$idT);
            }
            else{
                $datos['ok']= false; 
            }
        }
        else if($action=='eliminar')
                $datos['ok']= eliminar($id);
        else
            $datos['ok']= false;     
    }
    else
        $datos['ok']= false;
echo json_encode($datos);

function agregar($id,$cantidad){
    $res = 0;
    if ($id >0 && $cantidad > 0 && is_numeric($cantidad)){
        if(isset($_SESSION['carrito']['producto'][$id])){
            $_SESSION['carrito']['producto'][$id] = $cantidad;

            $db = new Database();
            $con = $db->conectar();

            $sql = $con->prepare("SELECT precio FROM producto WHERE id =? AND estado = 1");
            $sql->execute([$id]);
            $res = $sql ->fetch(PDO::FETCH_ASSOC);

            $precio =$res['precio'];
            $res = $cantidad * $precio;
            return $res;
        }
    }
    else return $res;
}
function color($id,$idT){
    if ($id >0 ){
            $db = new Database();
            $con = $db->conectar();

            $sql = $con->prepare("SELECT c.id, c.r, c.g,c.b FROM 
                                productotalla pt inner join color c on c.id = pt.ColorId 
                                inner join producto p on p.id = pt.productoid 
                                inner join talla t on t.id = pt.tallaid
                                where p.id = ? and t.id= ?");
            $sql->execute([$id,$idT]);
            $res = $sql ->fetchall(PDO::FETCH_ASSOC);
            return $res;
    }
    else return null;
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