<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";
<<<<<<< HEAD
$reporte='FUEC';

$objTemplate = new TemplateReport('FUEC','P','LEGAL',true,'empleado');
if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}
$objTemplate->setupForm($reporte,false,false,false,false,false);

=======


$reporte='FUEC';

$objTemplate = new TemplateReport('FUEC','P','LEGAL',true,'empleado');

if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}

$objTemplate->setupForm($reporte,false,false,false,false,false);


>>>>>>> origin/master
$consecutivo = $_SESSION['number'];
$objTemplate->fuec($consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>