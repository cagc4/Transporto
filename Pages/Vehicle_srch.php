<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['plate'])){
	unset($_SESSION['plate']);
}
$query = 'select * from cc_vehicle_vw';

$render = $template->headerSearch('Vehiculos', 'Vehiculos', 'cc_vehicle_vw', $query);
$template->navigateBar('Vehicle_srch');
$template->bodySearch($render);
$template->tail();
?>
