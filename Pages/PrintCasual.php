<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:CasualTravel_srch.php');
}
$render = $template->headerHome('Impresion de Reportes');
$template->navigateBar('PrintCasual');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href="" onclick="window.open('/Transporto/Pages/CasualTravel_pri.php');"><img src='../Images/Icons/pdf.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href="" onclick="window.open('/Transporto/Pages/ServiceOrder_pri.php');"><img src='../Images/Icons/pdf2.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Imprimir Planilla <?php echo $_SESSION['number'].'-P';?></td>
			<td align ='center'>Imprimir Orden de Servicio <?php echo $_SESSION['number'].'-P';?></td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>