<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number'])){
	unset($_SESSION['number']);
}
$query = 'select * from cc_formcontract_vw';

$render = $template->headerSearch('Extracto Contratos', 'Extracto Contratos', 'cc_formcontract_vw', $query);
$template->navigateBar('ContractExtract_srch');
$template->bodySearch($render);
$template->tail();
?>
