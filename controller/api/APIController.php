<?php 

class APIController {

    public function __construct() {

        $this->model = new lineaPedido();
        
    }


public function usuarios() {
    $data = $this->model->obtenerlineaPedidos();
}

}


?>