<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$render = $template->headerHome('Home Transcorvalle');
$template->navigateBar('Home');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='Customer_srch.php' ><img src='../Images/Icons/customers.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Transporter_srch.php' ><img src='../Images/Icons/Driver.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Vehicle_srch.php' ><img src='../Images/Icons/Bus.gif' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Document_srch.php' ><img src='../Images/Icons/documents.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Forms.php' ><img src='../Images/Icons/planillas.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Clientes</td>
			<td align ='center'>Propietarios / Conductores</td>
			<td align ='center'>Vehiculos</td>
			<td align ='center'>Documentos</td>
			<td align ='center'>Planillas</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>