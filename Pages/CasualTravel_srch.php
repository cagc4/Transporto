<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number'])){
	unset($_SESSION['number']);
}
$query = 'select * from cc_formocacional_vw';

$render = $template->headerSearch('Viajes Ocacionales', 'Viajes Ocacionales', 'cc_formocacional_vw', $query);
$template->navigateBar('CasualTravel_srch');
$template->bodySearch($render);
$template->tail();
?>
