<?php
    require '../config/database.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cor = $_POST['correo_user'];
        $pas = $_POST['contrasena_user'];

        if(!isUsuario($cor,$pas)){
            if(agregarRegistro($_POST['cedula_user'],$_POST['nombre_user'],
                   $_POST['telefono_user'],$cor,$pas)){

                header('Location:../index.php'); // Reemplaza con la URL correcta
                exit(); // Asegúrate de salir después de redirigir
            }
            else echo "Problemas el la insecion";
        }
        else{
            echo "Usuario no existe";
            $err="tus Credenciales estan incorrectas";
        }   
    }

    function isUsuario($cor,$pass){
        $passwordMd5 = md5($pass);

        $db = new Database();
        $con = $db->conectar();

        $res = $con->prepare("SELECT * FROM cuenta WHERE correo= ? AND password = ?");
        
        $res->execute([$cor,$pass]);
        if($res->rowCount())
            return true;
        else 
            return false;
    }
    function agregarRegistro(){
        $ban = false;
        if (isset($_POST['cedula_user']) && 
            isset($_POST['nombre_user']) &&
            isset($_POST['telefono_user']) &&
            isset($_POST['correo_user']) &&
            isset($_POST['contrasena_user'])){
  
            $ced = $_POST['cedula_user'];
            $nom = $_POST['nombre_user'];
            $tel = $_POST['telefono_user'];
            $cor = $_POST['correo_user'];
            $pas = $_POST['contrasena_user'];

            $db = new Database();
            $con = $db->conectar();  

            try {
                $con->beginTransaction();
                $stmt1 = $con->prepare("INSERT INTO cuenta (correo,password,rolId) VALUES (?,?,?)");
                $stmt1->execute([$cor, $pas,2]);
                $persona_id= $con->lastInsertId(); // Obtener el ID del usuario insertado

                $stmt2 = $con->prepare("INSERT INTO persona (cedula, nombre,telefono,cuentaid) VALUES (?,?,?,?)");
                $stmt2->execute([$ced, $nom,$tel,$persona_id]);

                $con->commit();
                $ban = true;
            } catch (Exception $e) {
                // Revertir la transacción si ocurre un error
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }
        }
        return $ban;   
}

?>