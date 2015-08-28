<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['number'])){
	unset($_SESSION['number']);
}
$query = 'select * from cc_sos_orden_vw';

$render = $template->headerSearch('Copia Orden Servicio', 'Copia Orden Servicio', 'cc_sos_orden_vw', $query);
$template->navigateBar('SosOrder_cpy');
$template->bodySearch($render);
$template->tail();
?>
