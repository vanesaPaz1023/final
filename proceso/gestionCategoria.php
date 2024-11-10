<?php
    
    require '../config/database.php';
    require '../config/session.php';

    if(isset($_POST['action'])){
        $action = $_POST['action'];
        if($action=='agregar') {
            if( isset($_POST['nombre'])){
                $nombre = $_POST['nombre'];

                $resul = insertarCategoria($nombre);
                $datos['ok']=true;
            }
            else $datos['ok']= false;  
        }
        else if($action=='editar'){
            if( isset($_POST['nombre']) && isset($_POST['id']) && isset($_POST['estado'])){
            $nombre = $_POST['nombre'];
            $id = $_POST['id'];
            $estado = $_POST['estado'];
            
            $resul = editarCategoria($id,$nombre,$estado);
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

function insertarCategoria($nombre) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        $sql = $con->prepare("INSERT INTO categoria(nombre) VALUES (?)");
        $sql->execute([$nombre]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar datos: " . $exception->getMessage();
    }
    return $res;
}
function editarCategoria($id,$nombre,$estado) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        $sql = $con->prepare("UPDATE categoria SET nombre = ?, estado = ?  WHERE id = ?");
        $sql->execute([$nombre,$estado,$id]);
        $res = true;

        
    } catch (PDOException $exception) {
        echo "Error al insertar datos: " . $exception->getMessage();
    }
    return $res;
}
?>