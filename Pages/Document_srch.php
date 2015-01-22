<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number']) || isset($_SESSION['plate']) || isset($_SESSION['documentType'])){
	unset($_SESSION['number']);
	unset($_SESSION['plate']);
	unset($_SESSION['documentType']);
}
$query = 'select * from cc_documentos_vw';

$render = $template->headerSearch('Documentos', 'Documentos', 'cc_documentos_vw', $query);
$template->navigateBar('Document_srch');
$template->bodySearch($render);
$template->tail();
?>
