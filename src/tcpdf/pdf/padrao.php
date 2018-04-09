<?php

/* ## CAMPOS DE POSTAGEM ##
 * requerente
 * empresa
 * nire
 * telefone
 * informacoes
 * item
 *  - itemsimplificada
 *  - itemsimplificadatext
 *  - itemespecifica
 *  - itemespecificaoutros
 * atos
 * folhas
 */

$post_requirente            = filter_input(INPUT_POST,'requerente',FILTER_SANITIZE_STRING);
$post_nomeEmpresa           = filter_input(INPUT_POST,'empresa',FILTER_SANITIZE_STRING);
$post_nire                  = filter_input(INPUT_POST,'nire',FILTER_SANITIZE_STRING);
$post_telefone              = filter_input(INPUT_POST,'telefone',FILTER_SANITIZE_STRING);
$post_informacoes           = filter_input(INPUT_POST,'informacoes',FILTER_SANITIZE_STRING);
$post_item                  = filter_input(INPUT_POST,'item',FILTER_VALIDATE_INT);
$post_itemsimplificada      = filter_input(INPUT_POST,'itemsimplificada',FILTER_SANITIZE_STRING);
$post_itemsimplificadatext  = filter_input(INPUT_POST,'itemsimplificadatext',FILTER_SANITIZE_STRING);
$post_itemespecifica        = filter_input(INPUT_POST,'itemespecifica',FILTER_SANITIZE_STRING);
$post_itemespecificaoutros  = filter_input(INPUT_POST,'itemespecificaoutros',FILTER_SANITIZE_STRING);
$post_qntAtos               = filter_input(INPUT_POST,'atos',FILTER_VALIDATE_INT);
$post_qntFollhas            = filter_input(INPUT_POST,'folhas',FILTER_VALIDATE_INT);

$arrayCertidoes = array(
    610 => "Inteiro Teor - cópia reprografada, certificada, de ato arquivado.",
    604 => "Simplificada - extrato de informações atualizadas, constantes de atos arquivados",
    605 => "Certidão Específica - relato dos elementos constantes de atos arquivados que o requerente pretende ver certificados.",
    801 => "Pedido de relatórios do cadastro de empresas.",
    701 => "Autenticação de Livros, conjunto de folhas encadernadas, sob forma de Livros ou conjunto",
    702 => "Autenticação de conjuntos de folhas soltas ou fichas",
    703 => "Autenticação de microfichas 'COM'"
);

switch($post_item)
{
    case 801: $post_tipoRequerimento = "PEDIDO:";break;
    case 701: $post_tipoRequerimento = "RELATORIO:"; break;
    case 702: $post_tipoRequerimento = "RELATORIO:"; break;
    case 703: $post_tipoRequerimento = "RELATORIO:"; break;
    default: $post_tipoRequerimento = "CERTIDAO:"; break;
}

require_once('tcpdf_include.php');

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
$pdf->SetTitle('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
$pdf->SetSubject('REQUERIMENTO PADRAO');
#$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
#$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
$pdf->SetFont('times', '', 11);
$pdf->AddPage();

### INICIO

$pdf->MultiCell(70,30,"Nire da Empresa",1,"C",0,1,15,45,0,0,0,1,0,"T");
$pdf->SetFont('times', 'B', 14);
$pdf->MultiCell(70,30,$post_nire,1,"C",0,3,15,45,1,0,0,1,30,"M");
$pdf->setX(90);
$pdf->SetFont('times', '', 11);
$pdf->Cell(0, 30, 'Uso da Junta Comercial', 1, 3, 'C', 0, '', 0,false,"D","B");
$pdf->Text(92,46,"N° do Protocolo");

### REQUERIMENTO
$pdf->SetFont('times', 'B', 14);
$pdf->Text(15,78,"REQUERIMENTO PADRAO");
$pdf->SetFont('times', '', 11);
$pdf->setX(15);
$pdf->setY(85);
$pdf->Cell(0, 50, '', 1, 1, 'C', 0, '', 1);
$pdf->Text(17,87,"Ilmo. Sr. Presidente da Junta Comercial do Estado de Mato Grosso do Sul");
$pdf->Text(20,99,$post_requirente);
$pdf->Line(17, 105, 190, 105);
$pdf->Text(18,106,"Nome do Requirente");
$pdf->Text(18,118,"Vem requerer a Vossa Senhoria o deferimento nesta Junta do(s) ato(s) abaixo indicado(s).");
$pdf->SetFont('times', 'B', 11);
$pdf->Text(18,125,"NOME DA EMPRESA:");
$pdf->SetFont('times', '', 11);
$pdf->Text(60,125,$post_nomeEmpresa);
$pdf->setY(135);

### ATOS
$pdf->Cell(0, 100, '', 1, 1, 'C', 0, '', 0);
$pdf->SetFont('times', 'B', 11);
$pdf->Text(18,138,"ATOS:");
$pdf->Text(18,145,$post_tipoRequerimento);
$pdf->SetFont('times', '', 11);
$pdf->setX(90);
$pdf->setY(150);
$pdf->SetFont('times', '', 11);
$y = $pdf->getY();
//MultiCell($w, $h, $txt, $border=0, $align='J', $fill=false, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0, $valign='T', $fitcell=false) {
$pdf->MultiCell(90,0,$arrayCertidoes[$post_item],0,"L",0,1,20,$y+12,1,0,1,1,10,"M");
$post_item == 605 ? $pdf->MultiCell(90,0,$post_itemespecifica,0,"L",0,1,25,$y+28,1,0,1,1,10,"M"): null;
$post_item == 605 ? $pdf->MultiCell(90,0,$post_itemespecificaoutros,0,"L",0,1,25,$y+33,1,0,1,1,10,"M"): null;
$post_item == 604 ? $pdf->MultiCell(90,0,$post_itemsimplificada,0,"L",0,1,25,$y+28,1,0,1,1,10,"M"):null;
$post_item == 604 ? $pdf->MultiCell(90,0,$post_itemsimplificadatext,0,"L",0,1,25,$y+33,1,0,1,1,10,"M"):null;
$pdf->MultiCell(20,10,"CÓDIGO",1,"C",0,3,115,$y,1,0,0,1,10,"M");
$pdf->MultiCell(20,10,$post_item,0,"C",0,3,115,$y+12);
$pdf->MultiCell(25,10,"QNT. ATOS",1,"C",0,10,135,$y,1,0,0,1,10,"M");
$pdf->MultiCell(25,2,$post_qntAtos,0,"C",0,10,135,$y+12);
$pdf->MultiCell(30,10,"QNT. FOLHAS OU TERMOS",1,"C",0,10,160,$y);
$pdf->MultiCell(30,10,$post_qntFollhas,0,"C",0,10,160,$y+12);

$pdf->SetFont('times', 'B', 11);
$pdf->Text(18,200,"Assinatura:");
$pdf->Line(40, 204, 150, 204);
$pdf->SetFont('times', 'B', 11);
$pdf->Text(18,208,"Telefone:");
$pdf->SetFont('times', '', 11);
$pdf->Text(35   ,208,$post_telefone);
$pdf->setY(235);

### INFORMAÇÕES
$pdf->Cell(0, 35, '', 1, 1, 'C', 0, '', 3);
$pdf->SetFont('times', 'B', 11);
$pdf->Text(18,238,"Informações Complementares:");
$pdf->SetFont('times', '', 11);
$pdf->MultiCell(170,0,$post_informacoes,0,"L",0,1,18,245,1,0,1,1,10,"M");

### IMPRIME
$pdf->Output('RequerimentoPadrao.pdf', 'D');
