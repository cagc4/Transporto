<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$render = $template->headerHome('Planillas');
$template->navigateBar('Forms');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='Paquete.php' ><img src='../Images/Icons/paquete.png' width="120" height="120" ></a></center></td>
            <td width =250><center><a href='ContractExtract_srch.php' ><img src='../Images/Icons/extractoContrato.png' width="150" height="150" ></a></center></td>
            <td width =250><center><a href='Contract_srch.php' ><img src='../Images/Icons/Forms.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Fuec.php' ><img src='../Images/Icons/fuec.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Historicos</td>
			<td align ='center'>Extractos Contratos</td>
			<td align ='center'>Contrato</td>
			<td align ='center'>FUEC</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>