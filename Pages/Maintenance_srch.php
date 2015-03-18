<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$query = 'select * from cc_mantenimientos_vw';

$render = $template->headerSearch('Mantenimientos Vehiculares', 'Mantenimientos Vehiculares', 'cc_mantenimientos_vw', $query);
$template->navigateBar('Maintenance_srch');
$template->bodySearch($render);
$template->tail();
?>
