<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$reporte='Orden de Servicio';

$objTemplate = new TemplateReport($reporte,'l','CAGC1',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:CasualTravel_srch.php');
}
$casualTravel = new CasualTravel();
$casualTravel->getServiceOrder($_SESSION['number']);
$result = $casualTravel->result->FetchRow();
$objTemplate->setupForm($reporte,true,true,true,true,true);

$consecutivo = $result['consecutivo'].'-P';
$objetoS = $result['objetoS'];
if($objetoS == '') {$objetoS = '                                                  ';}
$persona = $result['persona'];
if($persona == '') {$persona = '                                                  ';}
$celular = $result['celular'];
if($celular == '') {$celular = '                                                  ';}
$direcO = $result['origen'];
if($direcO == '') {$direcO = '                                                  ';}
$direcD = $result['destino'];
if($direcD == '') {$direcD = '                                                  ';}
$salida = $result['fechasalida'];
if($salida == '') {$salida = '                                                  ';}
$regreso = $result['fecharegreso'];
if($regreso == '') {$regreso = '                                                  ';}
$conductor = $result['conductor'];
if($conductor == '') {$conductor = '                                                  ';}
$placa = $result['placa'];		
if($placa == '') {$placa = '                              ';}

$objTemplate->serviceOrder(8,$objetoS,$persona,$celular,$direcO,$direcD,$salida,$regreso,$conductor,$placa,$consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>