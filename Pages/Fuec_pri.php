<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$reporte='FUEC';

$consecutivo='376009200201400010001';

$objTemplate = new TemplateReport($reporte,'P','Legal',false,'empleado');
$objTemplate->setupForm($reporte,true,false,false,false,true);

$objTemplate->fuec($consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>