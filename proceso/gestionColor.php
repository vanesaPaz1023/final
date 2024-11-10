<?php
require '../config/database.php';
require '../config/session.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action=='agregar') {
        if( isset($_POST['R']) && isset($_POST['G']) &&  isset($_POST['B'])){
            $R = $_POST['R'];
            $G = $_POST['G'];
            $B = $_POST['B'];

            $resul = insertarColor($R,$G,$B);
            $datos['ok']=true;
        }
        else $datos['ok']= false;  
    }
    else if($action=='editar') {
        if(isset($_POST['id']) && isset($_POST['R']) && isset($_POST['G']) && isset($_POST['B'])){
            $R = $_POST['R'];
            $G = $_POST['G'];
            $B = $_POST['B'];
            $id = $_POST['id'];

            $resul = editarColor($R,$G,$B,$id);
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

function insertarColor($R,$G,$B) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();
    
        $sql = $con->prepare("INSERT INTO color (R, G, B) VALUES (?,?,?)");
        $sql->execute([$R,$G,$B]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar datos: " . $exception->getMessage();
    }
    return $res;
}
function editarColor($R,$G,$B,$id) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();
    
        $sql = $con->prepare("UPDATE color SET R=?, g=?, B=? WHERE id = ?");
        $sql->execute([$R,$G,$B,$id]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar datos: " . $exception->getMessage();
    }
    return $res;
}
?>