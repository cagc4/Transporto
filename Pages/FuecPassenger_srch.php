<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}

$query = "select * from cc_fuec_ocupantes_vw where FUEC = '" . $_SESSION['number'] . "'";

$render = $template->headerSearch('Ocupantes del FUEC', 'Ocupantes del FUEC', 'cc_fuec_ocupantes_vw', $query);
$template->navigateBar('FuecPassenger_srch');

$template->bodySearch($render);
$template->tail();
?>
