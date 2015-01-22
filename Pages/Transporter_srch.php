<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['docNum']) || isset($_SESSION['docType'])){
	unset($_SESSION['docNum']);
	unset($_SESSION['docType']);
}
$query = 'select * from cc_prodcon_vw';

$render = $template->headerSearch('Propietarios & Conductores', 'Propietarios & Conductores', 'cc_prodcon_vw', $query);
$template->navigateBar('Transporter_srch');
$template->bodySearch($render);
$template->tail();
?>
