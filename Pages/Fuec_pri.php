<?php

include "../Clases/TemplateReport.php";
include "../Clases/CasualTravel.php";

$reporte='FUEC';

$consecutivo='376009200201400010001';

$objTemplate = new TemplateReport($reporte,'P','LEGAL',false,'empleado');
$objTemplate->setupForm($reporte,false,false,false,false,false);

$objTemplate->fuec($consecutivo);
$objTemplate->exportarPdf($consecutivo);

?>