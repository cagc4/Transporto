<?php

include "../Clases/TemplateReport.php";
include "../Clases/SosOrder.php";

$reporte='SOS';

$objTemplate = new TemplateReport($reporte,'l','CAGC1',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:SosOrden_srch.php');
}
$sosOrder = new SosOrder();
$sosOrder->getSosOrderReport($_SESSION['number']);
$result = $sosOrder->result->FetchRow();

$objTemplate->setupForm($reporte,true,true,false,false,true);

$consecutivo = $_SESSION['number'];
$numAuto = $result['authNumber'];
$persona = $result['patient'];
$tipoid = $result['docTypePatient'];
$identi = $result['docNumPatient'];
$personaA = $result['companion'];
$tipoidA = $result['docTypeCompanion'];
$identiA = $result['docNumCompanion'];

$direcO = $result['source'];
$teleO = $result['phone'];
$salida = $result['collectDate'];

$direcD = $result['destination1'];
$regreso = $result['outputDate1'];

$direcD2 = $result['destination2'];
$regreso2 = $result['outputDate2'];

$servicio1 = $result['cost1'];
$servicio2 = $result['cost2'];
$totalserv = $servicio1 +$servicio2;
$servicio1 = ''.$servicio1;
$servicio2 = ''.$servicio2;

$conductor = $result['driver'];
$placa = $result['plate'];

$objTemplate->reportSos($numAuto,$persona,$tipoid,$identi,$personaA,$tipoidA,$identiA,$direcO,$teleO,$direcD,$salida,$regreso,$direcD2,$regreso2,$servicio1,$servicio2,$totalserv,$conductor,$placa,$consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>