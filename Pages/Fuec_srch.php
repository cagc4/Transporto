<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number']) || isset($_SESSION['numberId'])){
	unset($_SESSION['number']);
	unset($_SESSION['numberId']);
}
$query = 'select * from cc_fuec_vw';

$render = $template->headerSearch('FUEC', 'FUEC', 'cc_fuec_vw', $query);
$template->navigateBar('Fuec_srch');

$template->bodySearch($render);
$template->tail();
?>
