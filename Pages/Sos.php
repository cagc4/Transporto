<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$render = $template->headerHome('Sos');
$template->navigateBar('Sos');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='Patient_srch.php' ><img src='../Images/Icons/pacientes.png' width="120" height="120" ></a></center></td>
            <td width =250><center><a href='Acompanante_srch.php' ><img src='../Images/Icons/acompanantes.png' width="150" height="150" ></a></center></td>
            <td width =250><center><a href='SosOrden_srch.php' ><img src='../Images/Icons/sosorden.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='' ><img src='../Images/Icons/copiasos.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Paciente</td>
			<td align ='center'>Acompa&ntilde;antes</td>
			<td align ='center'>Orden de Servicio</td>
			<td align ='center'>Copia Orden Servicio</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>