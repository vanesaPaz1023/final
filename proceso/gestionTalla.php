<?php
require '../config/database.php';
require '../config/session.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action=='agregar') {
        if (isset($_POST['nombre']) && isset($_POST['unidad'])) {
            $nombre = $_POST['nombre'];
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;  // Puede ser null
            $unidad = $_POST['unidad'];

            $resul = insertarTalla($nombre, $descripcion, $unidad);
            $datos['ok']=true;
        }
        else $datos['ok']= false;  
    }
    else if($action=='editar') {
        if (isset($_POST['nombre']) && isset($_POST['unidad']) && isset($_POST['id'])) {
            $nombre = $_POST['nombre'];
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;  // Puede ser null
            $unidad = $_POST['unidad'];
            $id = $_POST['id'];

            $resul = editarTalla($nombre, $descripcion, $unidad,$id);
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

function insertarTalla($nombre, $descripcion, $unidad) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        // Inserta los datos usando una consulta preparada
        $sql = $con->prepare("INSERT INTO talla (nombre, descripcion, unidad) VALUES (?, ?, ?)");
        $sql->execute([$nombre, $descripcion, $unidad]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar los datos: " . $exception->getMessage();
    }
    return $res;
}
function editarTalla($nombre, $descripcion, $unidad, $id) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        // Inserta los datos usando una consulta preparada
        $sql = $con->prepare("UPDATE talla SET nombre=?, descripcion=?, unidad=?  WHERE id=?");
        $sql->execute([$nombre, $descripcion, $unidad,$id]);
        $res = true;
    } catch (PDOException $exception) {
        echo "Error al insertar los datos: " . $exception->getMessage();
    }
    return $res;
}
?>