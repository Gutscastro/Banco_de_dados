<?php
class Ticket_model extends CI_Model{

  public function __construct()
  {
    parent::__construct();
  }


  public function get_tickets()
  {
    //retornar somete que estao disponivel
    $this->db->where('status', 1);
    return $this->db->get("ticket")->result();
  }

  public function finalizar($id_ticket, $data)
  {
    //finalizar um ticket
    $this->db->where('id', $id);
    $this->db->update('ticket', $data);
    return $this->db->get("ticket")->result();
  }

  public function cadastrar($data)
  {
    //cadastrar um novo ticket
    $this->db->insert('ticket', $data);
    return $this->db->get("ticket")->result();
  }

  public function getByUsuarioId($usuarioId)
  {
    //retornar os tickets de um usuario
    $this->db->where('usuario_id', $usuarioId);
    return $this->db->get("ticket")->result();
  }


}
?>