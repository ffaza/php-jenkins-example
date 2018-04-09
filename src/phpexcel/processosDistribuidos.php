<?php
include 'PHPExcel.php';
include 'PHPExcel/Writer/Excel2007.php';

$post_prossTotal   = filter_input(INPUT_POST,"prossTotal", FILTER_VALIDATE_INT);
$post_prossInterval= filter_input(INPUT_POST,"prossInterval", FILTER_SANITIZE_STRING);
$post_prossList    = $_POST["prossList"];
$post_prossCols    = $_POST["prossCols"];

$tmp = base64_decode($post_prossList);
$post_prossList = unserialize($tmp);

if (count ($post_prossList) > 0){

$user = "\nUsuário: [".trim($post_funcLogin)."] ".$post_funcNome."\n";
$intervalo .="Intervalo: ".$post_prossInterval." | ".$post_prossTotal." registros";

$report_title = 'RELATÓRIO DE PROCESSOS DISTRIBUÍDOS';


$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->mergeCells('A1:G1');
$objPHPExcel->getActiveSheet()->SetCellValue('A1',$report_title);
$objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
$objPHPExcel->getActiveSheet()->SetCellValue('A2',$intervalo );
$objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray(array('font'=>array('bold'=>true,'size'=>15)));
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

$row = 5;

$objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,utf8_encode('Funcionario'));
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,utf8_encode('Protocolo'));
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,utf8_encode('Andamento'));
$objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,utf8_encode('Origem'));
$objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,utf8_encode('Empresa'));
$objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,utf8_encode('Data Processo'));
$objPHPExcel->getActiveSheet()->getStyle("A{$row}:F{$row}")->applyFromArray(array('font'=>array('bold'=>true)));
$objPHPExcel->getActiveSheet()->getStyle("B{$row}:F{$row}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$row++;


foreach ($post_prossList as $dados) {
    $objPHPExcel->getActiveSheet()->SetCellValue("A{$row}",$dados->NO_LOGIN);
    $objPHPExcel->getActiveSheet()->SetCellValue("B{$row}",$dados->NR_PROTOCOLO);
    $objPHPExcel->getActiveSheet()->SetCellValue("C{$row}", $dados->SQ_ANDAMENTO);
    $objPHPExcel->getActiveSheet()->SetCellValue("D{$row}", $dados->SI_SECAO_ORIGEM);
    $objPHPExcel->getActiveSheet()->SetCellValue("E{$row}", utf8_encode($dados->NO_EMPRESARIAL));
    $objPHPExcel->getActiveSheet()->SetCellValue("F{$row}", $dados->DT_ANDAMENTO . ' ' . $dados->HORA_ANDAMENTO);

    /*$objPHPExcel->getActiveSheet()->getStyle("B{$row}:C{$row}")
        ->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/

    $row++;

}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.utf8_decode($report_title).'.xlsx"');
header('Cache-Control: max-age=0');

$objPHPExcel->getActiveSheet()->setTitle('PROCESSOS DISTRIBUÍDOS');
$objWriter->save('php://output');
} else die('Nenhuma informa&#231;&#227;o a apresentar.');