<?php

include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'empleado');

$_SESSION['number']=12345;
/*
if(!isset($_SESSION['number'])){
	header('location:SosOrden_srch.php');
}
*/
    
$render = $template->headerHome('Orden Servicio SOS');
$template->navigateBar('PrintSos');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href="" onclick="window.open('/Transporto/Pages/Sos_pri.php');"><img src='../Images/Icons/pdf.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Imprimir Orden de Servicio <?php echo $_SESSION['number'].'-P';?></td>
		</tr>
	</table>
	</center>
<?php
$template->tail();

?>