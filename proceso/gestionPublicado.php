<?php
require '../config/database.php';
require '../config/session.php';

if(isset($_POST['action'])){
    $action = $_POST['action'];
    if($action === 'agregar') {
        if (isset($_POST['producto'], $_POST['talla'], $_POST['color'], $_POST['unidad'])) {
            $producto = $_POST['producto'];
            $talla = $_POST['talla'];
            $color = $_POST['color'];
            $unidad = $_POST['unidad'];

            $resul = insertar($producto, $talla, $color, $unidad);
            if ($resul) {
                $datos['ok'] = true;
            } else {
                $datos['message'] = "Error al insertar los datos en la base de datos.";
            }
        } else {
            $datos['message'] = "Datos incompletos.";
        }
    }
    else if($action === 'editar') {
        if (isset($_POST['producto'], $_POST['talla'], $_POST['color'], $_POST['unidad'],$_POST['id'])) {
            $producto = $_POST['producto'];
            $talla = $_POST['talla'];
            $color = $_POST['color'];
            $unidad = $_POST['unidad'];
            $id = $_POST['id'];

            $resul = editar($id,$producto, $talla, $color, $unidad);
            if ($resul) {
                $datos['ok'] = true;
            } else {
                $datos['message'] = "Error al insertar los datos en la base de datos.";
            }
        } else {
            $datos['message'] = "Datos incompletos.";
        }
    } else {
        $datos['message'] = "Acción no válida.";
    }
} else {
    $datos['message'] = "No se ha enviado ninguna acción.";
}

echo json_encode($datos);

function insertar($producto, $talla, $color, $unidad) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        // Inserta los datos usando una consulta preparada
        $sql = $con->prepare("INSERT INTO productotalla (productoId, tallaId, ColorId, unidad) VALUES (?, ?, ?, ?)");
        $res = $sql->execute([$producto, $talla, $color, $unidad]);
    } catch (PDOException $exception) {
        // Si hay un error, se puede registrar o manejar como se necesite
        error_log("Error al insertar los datos: " . $exception->getMessage()); // Registra el error
    }
    return $res;
}

function editar($id, $producto, $talla, $color, $unidad) {
    try {
        $db = new Database();
        $con = $db->conectar();
        $sql = $con->prepare("UPDATE productotalla SET productoId = ?, tallaId = ?, colorId = ?, unidad = ? WHERE id = ?");
        
        return $sql->execute([$producto, $talla, $color, $unidad, $id]);
    } catch (PDOException $exception) {
        error_log("Error al editar los datos: " . $exception->getMessage());
        return false;
    }
}
?>