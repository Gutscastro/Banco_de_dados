<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('execute_request')) {
    function execute_request($metodo, $servico, $dados = null, $base_url = true) {

        $CI = & get_instance();

        $ch = curl_init();
        $CI = & get_instance();        
        
        $baseUrl = ($base_url ? $CI->config->item('base_url') : "") . $servico;

        if ($metodo == METODO_GET && $dados) {
            $baseUrl .= '/' . $dados;
        } else if ($metodo == METODO_POST) {
            $dados = json_encode($dados);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        } else if ($metodo == METODO_DELETE) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            $baseUrl .= '/' . $dados;
        } else if ($metodo == METODO_PUT) {
            $dados = json_encode($dados);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        }

        //tempo maximo de requizição
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        $headers = array(
            'Accept: application/json',
            'Content-Type: application/json',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $retorno["codigo"] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $retorno["dados"] = $response;
        return (Object) $retorno;
    }
}