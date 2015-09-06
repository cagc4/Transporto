<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$render = $template->headerHome('Planillas');
$template->navigateBar('Paquete');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='CasualTravel_srch.php' ><img src='../Images/Icons/viajeOcacional.png' width="120" height="120" ></a></center></td>
        </tr>
		<tr>
			<td align ='center'>Viaje Ocasional</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>