<?php
include "../Clases/TemplatePage.php";
$template = new TemplatePage(false, false, 'empleado');

$template->headerForms('Acceso restringido');
?>
<p class="letraLogout"><br>
ACCESO RESTRINGIDO!!! <br>
POR FAVOR INICIE SESION. <br>
Haga clic <a href="Login.php">aqui</a> para iniciar sesion</p>

<?php	
$template->tail();
?>
