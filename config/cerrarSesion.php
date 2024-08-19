<?php
    include_once 'session.php';

    $sessionActual = Session::getInstance();
    $sessionActual->cerrarSession();
    header('location:../');
?>