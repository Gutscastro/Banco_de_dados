<?php

class UsuarioModel extends CI_Model {

    private $tbl_usuario = 'usuario';

    function __construct() {
        parent::__construct();
    }

   public function cadastrar($data) {
        $this->db->insert($this->tbl_usuario, $data);
        return $this->db->insert_id();
    }

}

?>
