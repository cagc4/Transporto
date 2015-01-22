<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'administrador');
if(isset($_SESSION['user'])){
	unset($_SESSION['user']);
}
$query = 'select * from cc_users_vw';

$render = $template->headerSearch('Administracion de Usuarios', 'Usuarios', 'cc_users_vw', $query);
$template->navigateBar('User_srch');
$template->bodySearch($render);
$template->tail();
?>
