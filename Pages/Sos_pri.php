<?php

include "../Clases/TemplateReport.php";

$reporte='SOS';

$objTemplate = new TemplateReport($reporte,'l','CAGC1',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:SosOrden_srch.php');
}

$objTemplate->setupForm($reporte,true,true,true,true,true);

$objetoS='';
$persona='';
$celular='';
$direcO='';
$direcD='';
$salida='';
$regreso='';
$conductor='';
$placa='';
$consecutivo='12';
    
$objTemplate->reportSos(8,$objetoS,$persona,$celular,$direcO,$direcD,$salida,$regreso,$conductor,$placa,$consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>