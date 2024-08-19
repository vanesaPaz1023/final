<?php
    
    require '../config/database.php';
    require '../config/session.php';

    $sessionActual = Session::getInstance();

    if(isset($_POST['action'])){
        $action = $_POST['action'];
        if($action=='agregar') {
            if( isset($_POST['nombre']) && isset($_POST['estado'])){
                $nombre = $_POST['nombre'];
                $estado = $_POST['estado'];

                $resul = insertarCategoria($nombre,$estado);
                $datos['ok']=true;
            }
            else $datos['ok']= false;  
        }
        else 
            $datos['ok']= false;
    }
    else 
        $datos['ok']= false;
echo json_encode($datos);

function insertarCategoria($nombre, $estado) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();
        $estado= $estado == true ? 1 : 0;
    
        print($estado);
        $sql = $con->prepare("INSERT INTO categoria(nombre,estado) VALUES (?,?)");
        $sql->execute([$nombre, $estado]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar datos: " . $exception->getMessage();
    }
    return $res;
}
?>