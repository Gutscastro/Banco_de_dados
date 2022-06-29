<?php

defined("BASEPATH") or exit("No direct script access allowed");

use chriskacerguis\RestServer\RestController;

class Usuarios extends RestController
{
    private $usuario_id_logado;
    private $usuario_logado;


    public function __construct()
    {
        parent::__construct();
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token");
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");

        $this->load->model('usuarioModel', 'usuarioModel', TRUE);
    }

    public function index_options()
    {
        $this->response(NULL, 200);
    }


    public function usuario_options()
    {
        $this->response(NULL, 200);
    }

    public function usuario_post()
    {
        $usuario_id_logado = $this->post('usuario_id_logado');
        if(!$usuario_id_logado) {
            $this->response(array('error' => 'Usuário não logado'), 404);
        }
        //Colocar qual perfil_id pode cadastrar usuário
        if($usuario_id_logado != 1) {
            $this->response(array('error' => 'Usuário não tem perfil de administrador'), 404);
        }

        $usuario = [
            "nome" => $this->post('nome'),
            "email" => $this->post('email'),
            "senha" => $this->post('senha'),
        ];


        $usuario_id = $this->usuarioModel->cadastrar($usuario);
        
        $this->response($usuario_id, 200);
    }

    public function  usuario_put($id) {
        $usuario_id_logado = $this->usuario_id_logado;
        if(!$usuario_id_logado) {
            $this->response(array('error' => 'Usuário não logado'), 404);
        }
         //Colocar qual perfil_id pode cadastrar usuário
         if(!$this->usuario_logado->perfil_id !== 1) {
            $this->response(array('error' => 'Usuário não tem perfil de administrador'), 404);
        }

        $usuario = [
            "nome" => $this->put('nome'),
            "email" => $this->put('email'),
            "senha" => $this->put('senha'),
        ];

        $this->usuarioModel->atualizar($id, $usuario);
        $this->response(array('success' => 'Usuário atualizado'), 200);
    }

   
}
