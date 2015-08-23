<?php

include "../Clases/TemplateReport.php";

$reporte='SOS';

$objTemplate = new TemplateReport($reporte,'l','CAGC1',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:SosOrden_srch.php');
}

$objTemplate->setupForm($reporte,true,true,false,false,true);

$consecutivo='12';
$numAuto='12345';
$persona='Carlos Alberto Garcia Cobo';
$tipoid='CC';
$identi='14800275';
$personaA='Andres Martinez';
$tipoidA='CC';
$identiA='123456';

$direcO='Cali-Calle 21N numero 9A-105 Apto 202';
$teleO='3012657760';
$salida='2015-08-22 8:00';

$direcD='Cali-Fundación Club Noel';
$regreso='2015-08-23 15:00';

$direcD2='Valle del Lili';
$regreso2='2015-08-24 13:00';

$servicio1 = 45000;
$servicio2 = 36000;
$totalserv = $servicio1 +$servicio2;
$servicio1=''.$servicio1;
$servicio2=''.$servicio2;

$conductor='Francisco Javier Franco';
$placa='KCS973';

$objTemplate->reportSos($numAuto,$persona,$tipoid,$identi,$personaA,$tipoidA,$identiA,$direcO,$teleO,$direcD,$salida,$regreso,$direcD2,$regreso2,$servicio1,$servicio2,$totalserv,$conductor,$placa,$consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>