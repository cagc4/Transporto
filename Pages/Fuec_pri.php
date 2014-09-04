<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$reporte='FUEC';

$objTemplate = new TemplateReport('FUEC','P','LEGAL',false,'empleado');
$objTemplate->setupForm($reporte,false,false,false,false,false);


$consecutivo = '376009200201400180029';
$objTemplate->fuec($consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>