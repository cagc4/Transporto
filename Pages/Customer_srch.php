<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['docNum']) || isset($_SESSION['docType'])){
	unset($_SESSION['docNum']);
	unset($_SESSION['docType']);
}
$query = 'select * from cc_customer_vw';

$render = $template->headerSearch('Administracion de Clientes', 'Clientes', 'cc_customer_vw', $query);
$template->navigateBar('Customer_srch');
$template->bodySearch($render);
$template->tail();
?>
