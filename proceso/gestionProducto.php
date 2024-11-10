<?php
header('Content-Type: application/json');
require '../config/database.php';
require '../config/session.php';

$datos = ['ok' => false]; // Inicializar la respuesta

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action === 'agregar') {
        if (isset($_POST['nombre'], $_POST['unidad'], $_POST['precio'], $_POST['categoria'])) {
            $nombre = $_POST['nombre'];
            $unidad = $_POST['unidad'];
            $precio = $_POST['precio'];
            $categoria = $_POST['categoria'];
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
            $imagen = isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK ? $_FILES['imagen'] : null;
            $resul = insertarProducto($imagen,$nombre, $descripcion, $unidad, $precio, $categoria);
            $datos['ok'] = $resul;
            if (!$resul) {
                $datos['mensaje'] = 'Error al insertar el producto.';
            }
        } else {
            $datos['mensaje'] = 'Faltan campos requeridos.';
        }
    } elseif ($action === 'editar') {
        if (isset($_POST['nombre'], $_POST['unidad'], $_POST['precio'], $_POST['categoria'],$_POST['estado'], $_POST['id'])) {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $unidad = $_POST['unidad'];
            $precio = $_POST['precio'];
            $categoria = $_POST['categoria'];
            $estado = $_POST['estado'];
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : null;
            $imagen = isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK ? $_FILES['imagen'] : null;
            
            $resul = editarProducto($id, $imagen, $nombre, $descripcion, $unidad, $precio, $categoria,$estado);
            $datos['ok'] = $resul;
            if (!$resul) {
                $datos['mensaje'] = 'Error al editar el producto.';
            }
        } else {
            $datos['mensaje'] = 'Faltan campos requeridos.';
        }
    } else {
        $datos['mensaje'] = 'Acción no reconocida.';
    }
} else {
    $datos['mensaje'] = 'No se recibió ninguna acción.';
}

echo json_encode($datos);

function insertarProducto($imagen, $nombre, $descripcion, $unidad, $precio, $categoria) {
    $res = false;
    $id = null; // Inicializamos el ID como null
    try {
        $db = new Database();
        $con = $db->conectar();
        
        // Insertar el producto en la base de datos
        $sql = $con->prepare("INSERT INTO producto (nombre, descripcion, unidad, precio, categoriaId) VALUES (?,?,?,?,?)");
        $sql->execute([$nombre, $descripcion, $unidad, $precio, $categoria]);
        $id = $con->lastInsertId(); // Obtener el ID del producto insertado
        
        $res = true; // La inserción fue exitosa
        
        if ($imagen) {
            // Obtener detalles del archivo
            $imagenTmpPath = $imagen['tmp_name'];
            $imagenNombre = $imagen['name'];
            $imagenExt = strtolower(pathinfo($imagenNombre, PATHINFO_EXTENSION));
            $extensionesPermitidas = ['jpeg'];

            // Validar la extensión del archivo
            if (in_array($imagenExt, $extensionesPermitidas)) {
                $directorioSubida = '../img/productos/';
                
                // Generar un nombre único para la imagen basado en el ID del producto
                $nuevoNombreImagen = $id . '.' . $imagenExt;
                $rutaDestino = $directorioSubida . $nuevoNombreImagen;

                // Mover la imagen a la carpeta de destino
                if (move_uploaded_file($imagenTmpPath, $rutaDestino)) {
                    error_log("Imagen subida correctamente a: " . $rutaDestino);
                } else {
                    error_log("Error al mover la imagen.");
                }
            } else {
                error_log("Formato de imagen no permitido.");
            }
        }
    } catch (PDOException $exception) {
        error_log("Error al insertar datos: " . $exception->getMessage()); 
        $res = false; // Si hay un error, marcamos $res como false
    }
    
    // Devolver un arreglo con el resultado de la operación y el ID del producto
    return $res;
}


function editarProducto($id, $imagen, $nombre, $descripcion, $unidad, $precio, $categoria, $estado) {
    $res = false;
    try {
        $db = new Database();
        $con = $db->conectar();

        if ($imagen) {
            // Obtener detalles del archivo
            $imagenTmpPath = $imagen['tmp_name'];
            $imagenNombre = $imagen['name'];
            $imagenExt = strtolower(pathinfo($imagenNombre, PATHINFO_EXTENSION));
            $extensionesPermitidas = ['jpeg'];

            // Validar extensión del archivo
            if (in_array($imagenExt, $extensionesPermitidas)) {
                $directorioSubida = '../img/productos/';
                
                // Generar un nombre único para la imagen basado en el ID del producto
                $nuevoNombreImagen = $id . '.' . $imagenExt;
                $rutaDestino = $directorioSubida . $nuevoNombreImagen;

                // Mover la imagen a la carpeta de destino
                if (move_uploaded_file($imagenTmpPath, $rutaDestino)) {
                    // Actualizar el producto en la base de datos
                    $sql = $con->prepare("UPDATE producto SET nombre=?, descripcion=?, unidad=?, precio=?, categoriaId=?, estado=? WHERE id = ?");
                    $sql->execute([$nombre, $descripcion, $unidad, $precio, $categoria, $estado, $id]);
                    $res = true;
                } else {
                    error_log("Error al subir la imagen.");
                }
            } else {
                error_log("Formato de imagen no permitido.");
            }
        } else {
            // Actualizar sin imagen
            $sql = $con->prepare("UPDATE producto SET nombre=?, descripcion=?, unidad=?, precio=?, categoriaId=?, estado=? WHERE id = ?");
            $sql->execute([$nombre, $descripcion, $unidad, $precio, $categoria, $estado, $id]);
            $res = true;
        }
        
    } catch (PDOException $exception) {
        error_log("Error al actualizar datos: " . $exception->getMessage());
    }
    
    return $res;
}