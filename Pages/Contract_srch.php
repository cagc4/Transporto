<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number'])){
	unset($_SESSION['number']);
}
$query = 'select * from cc_contract_vw';

$render = $template->headerSearch('Contrato', 'Contrato', 'cc_contract_vw', $query);
$template->navigateBar('Contract_srch');
$template->bodySearch($render);
$template->tail();
?>
