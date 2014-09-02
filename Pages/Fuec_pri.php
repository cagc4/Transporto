<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$objTemplate = new TemplateReport('FUEC','P','LEGAL',false,'empleado');
$objTemplate->setupForm($reporte,false,false,false,false,false);

$objTemplate->fuec($_GET['codigo']);
$objTemplate->exportarPdf($consecutivo);

?>