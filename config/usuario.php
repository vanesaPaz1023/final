<?php
    include_once 'config/database.php';

    class Usuario extends Database{
        private $id;
        private $cedula;
        private $nombre;
        private $telefono;
        private $rol;
        private $passwordMd5;
        private $correo;

    public function __construct(){

    }
    public function isUsuario($cor,$pass){
        $passwordMd5 = md5($pass);

        // $db = new Database();
        $con = $this->conectar();

        $res = $con->prepare("SELECT * FROM cuenta WHERE correo= ? AND password = ?");
        
        $res->execute([$cor,$pass]);
        if($res->rowCount())
            return true;
        else 
            return false;
    }
    public function setUsuario($cor){
        $con = $this->conectar();
        $sql = $con->prepare("SELECT persona.id as id,persona.cedula as cedula,persona.nombre as nombre,persona.telefono as telefono, cuenta.correo as correo, rol.nombre as rol
        from persona inner join cuenta on persona.cuentaId = cuenta.id inner join rol on rol.id = cuenta.rolId where cuenta.correo = ?");

        
        $sql->execute([$cor]);
        $res = $sql ->fetch(PDO::FETCH_ASSOC);   

        $this->id=$res['id'];
        $this->cedula=$res['cedula'];
        $this->nombre=$res['nombre'];
        $this->telefono=$res['telefono'];
        $this->rol=$res['rol'];
        $this->correo=$res['correo'];
    }
    public function getCedula(){
        return $this->cedula;
    }
    public function getNombre(){
        return $this->nombre;
    }
    public function getId(){
        return $this->id;
    }
    public function getTelefono(){
        return $this->telefono;
    }
    public function getRol(){
        return $this->rol;
    }
    public function getPassword(){
        return $this->password;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function getUsuario(){
        return $this;
    }
}
?>