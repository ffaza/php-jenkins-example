<?php
require_once('tcpdf_include.php');
require_once('../../includes/class/Config.php');
Config::setUrlDb();
$mes = array('1' => 'Janeiro','2' => 'Fevereiro','3' => 'Marco','4' => 'Abril','5' => 'Maio','6' => 'Junho','7' => 'Julho','8' => 'Agosto','9' => 'Setembro','10' => 'Outubro','11' => 'Novembro','12' => 'Dezembro');

function lookcUpCity($id)
{
    Config::$db->getData("city",array('where'=>'city_id="'.$id.'"'));
    return Config::$db->fetchArrays();
}
function lookcUpUF($id)
{
    Config::$db->getData("states",array('where'=>'states_id="'.$id.'"'));
    return Config::$db->fetchArrays();
}

$post_nome          = filter_input(INPUT_POST,"nome",FILTER_SANITIZE_STRING);
$post_cpf           = filter_input(INPUT_POST,"cpf",FILTER_SANITIZE_STRING);
$post_telefone      = filter_input(INPUT_POST,"telefone",FILTER_SANITIZE_STRING);
$post_cep           = filter_input(INPUT_POST,"cep",FILTER_SANITIZE_STRING);
$post_uf            = filter_input(INPUT_POST,"uf",FILTER_SANITIZE_STRING);
$post_cidade        = filter_input(INPUT_POST,"cidade");
$post_endereco      = filter_input(INPUT_POST,"endereco",FILTER_SANITIZE_STRING);
$post_bairro        = filter_input(INPUT_POST,"bairro",FILTER_SANITIZE_STRING);
$post_banco         = filter_input(INPUT_POST,"banco",FILTER_SANITIZE_STRING);
$post_agencia       = filter_input(INPUT_POST,"agencia",FILTER_SANITIZE_STRING);
$post_contacorrente = filter_input(INPUT_POST,"contacorrente",FILTER_SANITIZE_STRING);
$post_motivo        = filter_input(INPUT_POST,"motivo",FILTER_SANITIZE_STRING);
$post_anexos        = $_POST["anexo"];
$post_gr            = filter_input(INPUT_POST,"gr",FILTER_SANITIZE_STRING);

//$anexo      = array();
$anexo[0]    = "Documento de Arrecadação - Guia JUCEMS";
$anexo[1]    = "Comprovante de Depósito Bancário";
$anexo[2]    = "Procuração/Autorização";

$data = "Campo Grande, ".date("d")." de ".$mes[date("m")]." de ".date("Y");

$tmp  = lookcUpCity($post_cidade);
$cidade = strtoupper(str_replace("-", " ",$tmp[0]->city_name));

$tmp  = lookcUpUF($post_uf);
$uf = strtoupper(str_replace("-", " ",$tmp[0]->states_acronym));

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
$pdf->SetTitle('JUNTA COMERCIAL DO ESTADO DE MATO GROSSO DO SUL - JUCEMS');
$pdf->SetSubject('REQUERIMENTO PADRAO');
#$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
#$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
#$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
#$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->SetFont('times', 'B', 8);
$pdf->MultiCell(118,30,"",1,"C",0,1,15,12,0,0,0,1,0,"T");
$pdf->Image("images/tcpdf_logo.jpg",17,14,0,22);
$pdf->Text(35,14,"ESTADO DE MATO GROSO DO SUL");
$pdf->MultiCell(87,10,"SECRETARIA DE STADO DE DESNVOLVIMENTO AGRÁRIO, DA PRODUÇÃO, DA INDÚSTRIA, DO COMÉRCIO EDO TURISMO",0,"L",0,1,35,20,0,0,0,1,0,"T");
//$pdf->MultiCell(87,10,"JUNTA COMERCIAL DO ESTADO DE MATO GROSO DO SUL -JUCEMS",0,"L",0,1,35,20,0,0,0,1,0,"T");
$pdf->Text(35,34,"JUNTA COMERCIAL DO ESTADO DE MATO GROSO DO SUL -JUCEMS");
$pdf->SetFont('times', 'B', 14);
$pdf->MultiCell(118,15,"REQUERIMENTO DE RESTIUIÇÃO DE TAXA",1,"C",0,1,15,42,0,0,0,1,15,"M");


$pdf->SetFont('times', '', 11);
$pdf->MultiCell(62,45,"",1,"C",0,1,133,12,0,0,0,1,0,"T");
$pdf->MultiCell(0,215,"",1,"C",0,1,15,57);
$pdf->MultiCell(0,1,"Senhor Presidente da Junta Comercial do Estado de Mato Grosso do Sul,",0,"C",0,1,15,63);
$pdf->SetFont('times', '', 11);
$pdf->Text(18,75,"Nome:");
$pdf->Text(30,75,$post_nome);
$pdf->Text(18,83,"CPF/CNPJ:");
$pdf->Text(37,83,$post_cpf);
$pdf->Text(130,82,"Telefone:");
$pdf->Text(146,82,$post_telefone);
$pdf->Text(18,91,"Endereço (Rua/Avenida):");
$pdf->Text(59,91,$post_endereco);
$pdf->Text(18,99,"Bairo/Vila/Distro:");
$pdf->Text(48,99,$post_bairro);
$pdf->Text(130,99,"Cep:");
$pdf->Text(138,99,$post_cep);
$pdf->Text(18,107,"Cidade:");
$pdf->Text(32,107,$cidade);
$pdf->Text(130,107,"Uf:");
$pdf->Text(138,107,$uf);
$pdf->Text(18,120,"Banco (para restituição):");
$pdf->Text(58,120,$post_banco);
$pdf->Text(100,120,"Agencia:");
$pdf->Text(115,120,$post_agencia);
$pdf->Text(130,120,"Conta Corrente:");
$pdf->Text(156,120,$post_contacorrente);
$pdf->Text(18,130,"GR Utilzada:");
$pdf->Text(40,130,$post_gr);
$pdf->Text(18,140,"vem requer arestiução datxa recolhida pra esta JUCEMS, pelo motivo:");
$pdf->SetFont('times', 'b', 11);
$pdf->Text(25,145," - ".$post_motivo);
$pdf->SetFont('times', '', 11);
$pdf->Text(18,175,"Nestes termos pede e espera defrimento.");
$pdf->MultiCell(0,1,$data,0,"C",0,1,15,195);
$pdf->Line(70,220,140,220);
$pdf->MultiCell(0,1,"Assinatura",0,"C",0,1,15,222);
$pdf->MultiCell(170,27,"Anexos",1,"L",0,1,20,240);

$pos=246;
foreach($post_anexos as $value){
    $pdf->Text(25,$pos,$value);
    $pos = $pos+5;
}

### IMPRIME
$pdf->Output('RequerimentoRestituicaoTaxa.pdf', 'D');
