<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$render = $template->headerHome('Administracion vehiculos');
$template->navigateBar('AdminVehicle');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='Vehicle_srch.php' ><img src='../Images/Icons/AdminVehicles.png' width="120" height="120" ></a></center></td>
            		<td width =250><center><a href='Vehicle_srch.php' ><img src='../Images/Icons/mantenimiento.png' width="150" height="150" ></a></center></td>
            	</tr>
		<tr>
			<td align ='center'>Vehiculos</td>
			<td align ='center'>Mantenimiento Vehiculos</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>