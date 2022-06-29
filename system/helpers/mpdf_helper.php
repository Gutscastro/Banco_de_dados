<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function mpdf_create($html, $filename = '', $stream = TRUE, $server_root = "", $formato = "A4-P", $orientacao = "P") {
    // include('mpdf60/mpdf.php');
    $CI =& get_instance();

    try {
        ob_clean();
        ini_set("pcre.backtrack_limit", "1000000");

        $mpdf = new \Mpdf\Mpdf();
        // $mpdf = new \mPDF();
        $mpdf->_setPageSize($formato, $orientacao);

        $rodape = mb_convert_encoding($CI->load->view("template/footerRelatorios", NULL, TRUE), 'UTF-8', 'UTF-8');
        $mpdf->SetHTMLFooter($rodape);

        $mpdf->WriteHTML($html);

        if ($stream) {
            /* Abrir no navegador */
            $mpdf->Output($filename, 'I');
        } else {
            /* Salva o PDF no servidor para enviar por email */
            if ($server_root == "" && isset($_SERVER['DOCUMENT_ROOT'])) {
                $server_root = $_SERVER['DOCUMENT_ROOT'];
            }
            $mpdf->Output($server_root . '/assets/pdf/' . $filename . '.pdf', 'F');
        }
    } catch (Exception $e) {
        echo $e;
        exit;
    }
}

function mpdf_create_report($html, $filename = '') {
    // include('mpdf60/mpdf.php');

    try {
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->charset_in = 'windows-1252';
        $mpdf->WriteHTML($html);
        $mpdf->debug = true;
        // $mpdf->Output();
        $mpdf->Output($filename, 'I');
    } catch (Exception $e) {
        echo $e;
        exit;
    }
}

function mpdf_create_clean($html, $filename = '', $stream = TRUE, $server_root = "", $incluir_lib = TRUE) {
    if ($incluir_lib) {
        // include('mpdf60/mpdf.php');
    }


    try {
        $mpdf = new \Mpdf\Mpdf('', '', 0, '', 0, 15, 0, 0, 0, 0);
        $mpdf->WriteHTML($html);
        // $mpdf->Output();

        if ($stream) {
            /* Abrir no navegador */
            $mpdf->Output($filename . '.pdf', 'I');
        } else {
            /* Salva o PDF no servidor para enviar por email */
            if ($server_root == "" && isset($_SERVER['DOCUMENT_ROOT'])) {
                $server_root = $_SERVER['DOCUMENT_ROOT'];
            }
            $mpdf->Output($server_root . '/assets/pdf/' . $filename . '.pdf', 'F');
        }
    } catch (Exception $e) {
        echo $e;
        exit;
    }
}

?>
