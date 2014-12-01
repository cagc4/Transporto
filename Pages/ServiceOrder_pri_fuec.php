<?php

include "../Clases/TemplateReport.php";

$reporte='Orden de Servicio';

$objTemplate = new TemplateReport($reporte,'l','CAGC1',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}

$fuec = new Fuec();
$fuec->getFuec($_SESSION['number']);
$result = $fuec->result->FetchRow();
$objTemplate->setupForm($reporte,true,true,true,true,true);


$consecutivo = $_SESSION['number'];
$objetoS = $result['3'];
if($objetoS == '') {$objetoS = '                                                  ';}
$persona = $result['26'];
if($persona == '') {$persona = '                                                  ';}
$celular = $result['28'];
if($celular == '') {$celular = '                                                  ';}
$direcO = $result['30'];
if($direcO == '') {$direcO = '                                                  ';}
$direcD = $result['31'];
if($direcD == '') {$direcD = '                                                  ';}
$salida = $result['32'];
if($salida == '') {$salida = '                                                  ';}
$regreso = $result['33'];
if($regreso == '') {$regreso = '                                                  ';}
$conductor = $result['18'];
if($conductor == '') {$conductor = '                                                  ';}
$placa = $result['12'];
if($placa == '') {$placa = '                              ';}


$objTemplate->serviceOrder(8,$objetoS,$persona,$celular,$direcO,$direcD,$salida,$regreso,$conductor,$placa,$consecutivo);
$objTemplate->exportarPdf($consecutivo);



?>