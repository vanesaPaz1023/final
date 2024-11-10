<?php
    require '../config/database.php';

    $db = new Database();
    $con = $db->conectar();

    $valor = isset($_POST['valor']) ? $_POST['valor'] : null;

    if ($valor !== null) {
        $sql = $con->prepare("SELECT 
            p.id as id, 
            p.nombre as nombre, 
            p.precio as precio, 
            c.nombre as categoria
            FROM productotalla pt 
            INNER JOIN producto p ON pt.productoId = p.id
            INNER JOIN categoria c ON p.categoriaId = c.id
            WHERE p.estado = 1 
            AND p.unidad != 0 
            AND c.nombre LIKE CONCAT('%', ?, '%')");
        $sql->execute([$valor]);
        $resul = $sql->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $resul = null;
    }

    $datos = [];

    if ($resul !== null && count($resul) > 0) {
        $datos['ok'] = true;
        $datos['resul'] = $resul;
    } else {
        $datos['ok'] = false;
    }

    echo json_encode($datos);
?>