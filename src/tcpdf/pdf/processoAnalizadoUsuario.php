<?php
require_once('tcpdf_include.php');
$mes = array('1' => 'Janeiro','2' => 'Fevereiro','3' => 'Marco','4' => 'Abril','5' => 'Maio','6' => 'Junho','7' => 'Julho','8' => 'Agosto','9' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' => 'Dezembro');
$hoje = date("d/m/Y")." às ".date("H:i:s");

$post_funcLogin    = filter_input(INPUT_POST,"funcLogin", FILTER_SANITIZE_STRING);
$post_funcNome     = filter_input(INPUT_POST,"funcNome", FILTER_SANITIZE_STRING);
$post_prossTotal   = filter_input(INPUT_POST,"prossTotal", FILTER_VALIDATE_INT);
$post_prossInterval= filter_input(INPUT_POST,"prossInterval", FILTER_SANITIZE_STRING);
$post_prossList    = $_POST["prossList"];
$post_prossCols    = $_POST["prossCols"];

$tmp = base64_decode($post_prossList);
$post_prossList = unserialize($tmp);

$tmp = base64_decode($post_prossCols);
$post_prossCols = unserialize($tmp);


if(count($post_prossList)>0) {

    $a = "\nUsuário: [" . trim($post_funcLogin) . "] " . $post_funcNome . "\n";
    $a .= "Intervalo: " . $post_prossInterval . " | " . $post_prossTotal . " registros";

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
    $pdf->SetTitle('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
    $pdf->SetSubject('DISTRIBUIDOR AUTOMATICO DE PROCESSO');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "RELATÓRIO DE PROCESSOS ANALISADOS POR USUÁRIO", $a);
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }

// ---------------------------------------------------------
    $pdf->AddPage();
    $pdf->SetFont('times', '', 10);
    $pdf->Text(248, 22, $hoje);
    $pdf->setY(29);
    $table = '<table cellspacing="0" cellpadding="5" style="font-family: verdana, arial, helvetica, sans-serif; font-size: 10px">
                <thead>
                    <tr style="text-align: center; background-color: #737373;color: white;font-weight: bold;">
                        <th style="text-align: center; width: 8%">Protocolo</th>
                        <th style="text-align: center; width: 5%">AND</th>
                        <th style="text-align: center; width: 5%">ORI</th>
                        <th style="text-align: center; width: 52%">Nome da Empresa</th>
                        <th style="text-align: center; width: 15%">Data Processo</th>
                        <th style="text-align: center; width: 15%">Data Destino</th>
                    </tr>
                </thead>
            <tbody>';

    foreach ($post_prossList as $dados) {
        $table .= '<tr style="margin-bottom: 99px;">
                <td style="text-align: center; width: 8%">' . $dados->NR_PROTOCOLO . '</td>
                <td style="text-align: center; width: 5%">' . $dados->SQ_ANDAMENTO . '</td>
                <td style="text-align: center; width: 5%">' . $dados->SI_SECAO_ORIGEM . '</td>
                <td style="width: 52%">' . utf8_encode($dados->NO_EMPRESARIAL) . '</td>
                <td style="text-align: center; width: 15%">' . $dados->DT_ANDAMENTO . ' ' . $dados->HORA_ANDAMENTO . '</td>
                <td style="text-align: center; width: 15%">' . $dados->DT_DESTINO2 . ' ' . $dados->HR_DESTINO2 . '</td>
            </tr>';
    }
    $table .= "</tbody></table>";
    $pdf->writeHTML($table, true, false, true, false, '');
### IMPRIME
    $pdf->Output('ProcessosAnalizadosPorUsuario.pdf', 'D');
}else{
    echo "<script>alert('Sem ".utf8_decode('informações')." para gerar o PDF');window.close();</script>";

}