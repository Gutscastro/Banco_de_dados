<?php

defined("BASEPATH") or exit("No direct script access allowed");

use chriskacerguis\RestServer\RestController;

class Tecnico extends RestController
{
    private $usuario_id_logado;
    private $usuario_logado;


    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token");
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");

        $this->load->model('usuarios/usuarioModel', 'usuarioModel', TRUE);
        $this->load->model('Ticket_model', 'ticketModel', TRUE);
    }

    public function index_options()
    {
        $this->response(NULL, 200);
    }

    public function index_get($usuario_id = null)
    {
        //Buscar todos os tickets abertos
        try {
          if(!verificar_permisao($usuario_id)){
            $this->response(array('error' => 'Usuário não tem permissão'), 404);
          }
            $tickets = $this->ticketModel->get_tickets();
            $this->response($tickets, 200);
        } catch (Exception $e) {
            $this->response(array('error' => $e->getMessage()), 404);
        }
        
    }

    public function index_put($id_ticket) {
      try {
        if(!verificar_permisao($usuario_id)){
          $this->response(array('error' => 'Usuário não tem permissão'), 404);
        }
        $ticket = $this->ticketModel->atualizar_ticket($id_ticket, $this->put());
        $this->response($ticket, 200);
      } catch (Exception $e) {
        $this->response(array('error' => $e->getMessage()), 404);
      }
    }

    public function verificar_permisao($usuario_id)
    {
        $usuario_id_logado = $this->usuario_id_logado;
        if(!$usuario_id_logado) {
            $this->response(array('error' => 'Usuário não logado'), 404);
        }
        //Colocar qual perfil_id pode cadastrar usuário
        if(!$this->usuario_logado->perfil_id !== 1 || !$this->usuario_logado->perfil_id !== 2) {
            $this->response(array('error' => 'Usuário não tem acesso'), 404);
        }

        return true;
    }

   
   
}
