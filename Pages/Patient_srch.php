<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['docNum']) || isset($_SESSION['docType'])){
	unset($_SESSION['docNum']);
	unset($_SESSION['docType']);
}
$query = 'select * from cc_paciente_vw';

$render = $template->headerSearch('Administracion de Pacientes', 'Pacientes', 'cc_paciente_vw', $query);
$template->navigateBar('Patient_srch');
$template->bodySearch($render);
$template->tail();
?>
