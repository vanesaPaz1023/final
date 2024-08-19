<?php
    class Session{
        private static $instance = null;
        private $num_cart;
        private $KEY_TOKEN;
        private $MONEDA;
        
        private function __construct(){
            session_start();
            $this->num_cart = 0;
            $this->MONEDA = "$";
            $this->KEY_TOKEN = "BAI.wed-456*}";

            if (isset($_SESSION['carrito']['producto'])){
                $this->num_cart = count($_SESSION['carrito']['producto']);
            }
        }
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function getNumCart(){
            $this->num_cart;
        }
        public function getKeyToken(){
            $this->KEY_TOKEN;
        }
        public function getMoneda(){
            $this->MONEDA;
        }

        public function getSessionVariable($key) {
            return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
        public function setSessionVariable($key, $value) {
            $_SESSION[$key] = $value;
        }
        public function setUsuario($usu) {
            $this->setSessionVariable('usuario', [
                'id' => $usu->getId(),
                'nombre' => $usu->getNombre(),
                'telefono' => $usu->getTelefono(),
                'correo' => $usu->getCorreo(),
                'cedula' => $usu->getCedula(),
                'rol' => $usu->getRol()
            ]);
        }
        public function getUsuario() {
            return $this->getSessionVariable('usuario');
        }
        public function getCarrito(){
            return $this->getSessionVariable('carrito');
        }
        public function getProducto(){
            return isset($_SESSION['carrito']['producto']) ? $_SESSION['carrito']['producto'] : null;
        }
        public function getProductoItemCantidad($key){
            return isset($_SESSION['carrito']['producto'][$key]) ? $_SESSION['carrito']['producto'][$key] : null;
        }
        public function setProductoCantidadMasUno($key){
            return $_SESSION['carrito']['producto'][$key]+=1;
        }
        public function setProductoCantidadIgualUno($key){
            return $_SESSION['carrito']['producto'][$key]=1;
        }
        public function cerrarSession(){
            session_unset();
            session_destroy();
        }
    }

?>