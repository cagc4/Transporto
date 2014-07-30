<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:ContractExtract_srch.php');
}
$render = $template->headerHome('Contrato');
$template->navigateBar('PrintContract');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href="" onclick="window.open('/Transporto/Pages/Contract_pri.php');"><img src='../Images/Icons/pdf.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Imprimir Contrato <?php echo $_SESSION['number'].'-C';?></td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>