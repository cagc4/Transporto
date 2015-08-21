<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['docNum']) || isset($_SESSION['docType'])){
	unset($_SESSION['docNum']);
	unset($_SESSION['docType']);
}
$query = 'select * from cc_acompanante_vw';

$render = $template->headerSearch('Administracion de Acompañantes', 'Acompañantes', 'cc_acompanante_vw', $query);
$template->navigateBar('Companion_srch');
$template->bodySearch($render);
$template->tail();
?>
