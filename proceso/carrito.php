<?php
require_once '../config/session.php';

$sessionActual = Session::getInstance();

if (isset($_POST['id']) ) {
    
    $id = $_POST['id'];
    // $token = $_POST['token'];


    // Genera el token temporal
    // $token_tmp = hash_hmac('sha1', $id, $sessionActual->getKeyToken());

    // if ($token == $token_tmp) {
        // Manejo del carrito
        if ($sessionActual->getProductoItemCantidad($id) !== null) {
            $sessionActual->setProductoCantidadMasUno($id);
        } else {
            $sessionActual->setProductoCantidadIgualUno($id);
        }

        $datos['numero'] = count($sessionActual->getProducto());
        $datos['ok'] = true;
    // } else {
    //     $datos['ok'] = false;
    // }
} else {
    $datos['ok'] = false;
}

echo json_encode($datos);

?>