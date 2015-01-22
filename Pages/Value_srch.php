<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'administrador');
if(isset($_SESSION['fieldValue']) && isset($_SESSION['value'])){
	unset($_SESSION['fieldValue']);
	unset($_SESSION['value']);
}
$query = 'select * from cc_valores_vw';

$render = $template->headerSearch('Mantenimiento de Valores', 'Valores', 'cc_valores_vw', $query);
$template->navigateBar('Value_srch');
$template->bodySearch($render);
$template->tail();
?>
