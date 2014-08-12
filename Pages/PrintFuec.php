<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}
$render = $template->headerHome('FUEC');
$template->navigateBar('PrintFuec');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href="" onclick="window.open('/Transporto/Pages/Fuec_pri.php');"><img src='../Images/Icons/pdf.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Imprimir FUEC <?php echo $_SESSION['number'];?></td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>