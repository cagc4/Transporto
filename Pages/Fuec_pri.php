<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$reporte='FUEC';

$objTemplate = new TemplateReport('FUEC','P','LEGAL',false,'empleado');
session_start();
if(!isset($_SESSION['number'])){
	if(!$_GET["Numero_FUEC"]) {
		header('location:Fuec_srch.php');
	}
	else {
		$_SESSION['number'] = $_GET["Numero_FUEC"];
	}
}
$objTemplate->setupForm($reporte,false,false,false,false,false);

$reporte='FUEC';

$consecutivo = $_SESSION['number'];
$objTemplate->fuec($consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>
