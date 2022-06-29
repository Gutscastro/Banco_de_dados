<?php
class Ticket extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    user_verify_session();

    $this->load->model("ticket_model");
    $this->load->helper("swal_helper");
    $this->load->helper("authentication_helper");
  }

  // 1 - Admin
  // 2 - Cliente
  // 3 - tecnico
  // 1 - aberto
  // 2 - andamento
  // 3 - finalizado

  public $get_categories;
  public $get_products;
  public $user_auth;
  public $v_data;

  public function ticket_options()
  {
    $this->response(NULL, 200);
  }

  public function ticket_get()
  {
    //Pegar todos os tickets disponivel
    try {
      $tickets = $this->ticket_model->get_tickets();
      $this->response($tickets, 200);
    } catch (Exception $e) {
      $this->response(array('error' => $e->getMessage()), 404);
    }
  }

  public function ticket_post()
  {
    //Cadastrar um novo ticket
    try {
      $ticket = $this->ticket_model->cadastrar($this->post());
      $this->response($ticket, 200);
    } catch (Exception $e) {
      $this->response(array('error' => $e->getMessage()), 404);
    }
  }

  public function finalizar_ticket_options()
  {
    $this->response(NULL, 200);
  }

  public function finalizar_ticket_post($id_ticket, $descricao_atendimento = NULL)
  {
    try {
      $user_id = $this->user_auth->user_id;
      //Finalizar somente o admin e cliente(apos validação do tecnico)
      ($user_id != 2 || $user_id != 1) ? $this->response(array('error' => 'Usuário não tem permissão para finalizar o ticket'), 404) : $this->response(array('error' => 'Usuário não tem permissão para finalizar o ticket'), 404);

      $ticket = verificar_ticket($id_ticket, $user_id);

      $data = [
        "status" => 3,
        "descricao_atendimento" => $descricao_atendimento ?? NULL,
      ];

      $ticket = $this->ticket_model->finalizar($id_ticket, $data);
      $this->response($ticket, 200);
    } catch (Exception $e) {
      $this->response(array('error' => $e->getMessage()), 404);
    }
  }

  private function verificar_ticket($id_ticket, $user_id)
  {
    //Verificar se o ticket existe
    $ticket = $this->ticket_model->get_ticket($id_ticket);
    if (!$ticket) {
      $this->response(array('error' => 'Ticket não existe'), 404);
    }

    //Verificar se o ticket está aberto
    if ($user_id != 1 || $user_id != 2 && $ticket->status != 1 || $ticket->status != 2) {
      $this->response(array('error' => 'Não foi possivel completar a operação'), 500);
    }

    return $ticket;
  }
}
