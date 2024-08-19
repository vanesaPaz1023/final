<?php
    require '../config/database.php';

    $db = new Database();
    $con = $db->conectar();

    $valor = isset($_POST['valor']) ? $_POST['valor'] : null;

    if ($valor !== null) {
        $sql = $con->prepare("
            SELECT producto.id as id, producto.nombre as nombre, producto.precio as precio, categoria.nombre as categoria
            FROM producto 
            INNER JOIN categoria ON producto.categoriaId = categoria.id
            WHERE producto.estado = 1 AND producto.unidad != 0 AND categoria.nombre LIKE CONCAT('%', ?, '%')");
        $sql->execute([$valor]);
        $resul = $sql ->fetchall(PDO::FETCH_ASSOC);
    } 
    else {
        $resul = null;
        $datos['ok']= false;
    }
    if ($resul !== null && count($resul) > 0) {
        $datos['ok']= true;
        $datos['resul']= $resul;
    } 
    else 
        $datos['ok']= false;

    echo json_encode($datos);
?>