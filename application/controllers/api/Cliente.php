<?php

defined("BASEPATH") or exit("No direct script access allowed");

use chriskacerguis\RestServer\RestController;

class Cliente extends RestController
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

    public function index_get($usuario_id){
        //Buscar todos os tickets abertos
        try {
          if(!verificar_permisao($usuario_id)){
            $this->response(array('error' => 'Usuário não tem permissão'), 404);
          }
            $tickets = $this->ticketModel->getByUsuarioId($usuario_id);
            $this->response($tickets, 200);
        } catch (Exception $e) {
            $this->response(array('error' => $e->getMessage()), 404);
        }
        
    }

    public function index_post()
    {
        try {
          //deve verificar se ja existe uma conta com o email informado senão tiver criar uma
          // somente Cliente pode se cadastrar
          $usuario_id_logado = $this->post('usuario_id_logado');
          if(!$usuario_id_logado) {
              $this->response(array('error' => 'Usuário não logado'), 404);
          }
          //Colocar qual perfil_id pode cadastrar usuário
          if($usuario_id_logado != 2) {
              $this->response(array('error' => 'Usuário não tem perfil de administrador'), 404);
          }

          $usuario = [
              "nome" => $this->post('nome'),
              "email" => $this->post('email'),
              "cpf" => $this->post('cpf'),
              "telefone" => $this->post('telefone'),
              "email_alternativo" => $this->post('email_alternativo'),
              "senha" => $this->post('senha'),
          ];

          $usuario_id = $this->usuarioModel->cadastrar($usuario);
          $this->response($usuario_id, 200);
        }catch (Exception $e) {
            $this->response(array('error' => $e->getMessage()), 404);
        }
        
    }

    public function abrir_ticket_options()
    {
        $this->response(NULL, 200);
    }

    public function abrir_ticket_post()
    {
        $usuario_id_logado = $this->usuario_id_logado;
        if(!$usuario_id_logado) {
            $this->response(array('error' => 'Usuário não logado'), 404);
        }
        //Colocar qual perfil_id pode cadastrar usuário
        if(!$this->usuario_logado->perfil_id !== 1) {
            $this->response(array('error' => 'Usuário não tem perfil de administrador'), 404);
        }

        $ticket = [
            "titulo" => $this->post('titulo'),
            "descricao" => $this->post('descricao'),
            "status" => 1,
            "usuario_id" => $usuario_id_logado,
        ];

        $ticket_id = $this->ticketModel->cadastrar_ticket($ticket);
        
        $this->response($ticket_id, 200);
    }

    public function finalizar_ticket_options()
    {
        $this->response(NULL, 200);
    }

    public function finalizar_ticket_post($id)
    {
        $usuario_id_logado = $this->usuario_id_logado;
        if(!$usuario_id_logado) {
            $this->response(array('error' => 'Usuário não logado'), 404);
        }
        //Colocar qual perfil_id pode cadastrar usuário
        if(!$this->usuario_logado->perfil_id !== 1) {
            $this->response(array('error' => 'Usuário não tem perfil de administrador'), 404);
        }

        $ticket = [
            "status" => 3,
            "descricao_cliente" => $this->post('descricao_cliente'),
        ];

        $ticket_id = $this->ticketModel->finalizar($id, $ticket);
        
        $this->response($ticket_id, 200);
    }
   
}
