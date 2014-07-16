<?php
include "../Clases/TemplatePage.php";
$template = new TemplatePage(false, false, '');
session_start();
$template->headerForms('Cierre de sesion');
if(session_destroy()) {
	?>
	<p class="letraLogout"><br>
	Usted ha cerrado su session correctamente, <br>
	ahora puede cerrar la p&aacute;gina con confianza.<br><br>
	<a href='/'>Volver al Inicio</a>
	</p>
	
	<?php	
}	
else {
?>	
	<p class="letraLogout"><br>
	No se ha podido cerrar la session de forma segura
	</p>
<?php
}
$template->tail();
?>
