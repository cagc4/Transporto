<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(isset($_SESSION['docNum']) || isset($_SESSION['docType'])){
	unset($_SESSION['docNum']);
	unset($_SESSION['docType']);
}
$query = 'select * from cc_sos_orden_tbl';

$render = $template->headerSearch('Orden Servicio', 'Orden Servicio', 'cc_sos_orden_tbl', $query);
$template->navigateBar('SosOrden_srch');
$template->bodySearch($render);
?>
<a href="/Transporto/Pages/PrintSos.php">orden de servicio Prueba </a>
<?php
$template->tail();
?>
