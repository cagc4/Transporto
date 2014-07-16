<?php
include "../Clases/TemplatePage.php";

$template = new TemplatePage(false, true, 'administrador');

$render = $template->headerHome('Administracion de Clientes');
$template->navigateBar('HomeAdmin');
?>
	<br><br><br><br><br><br><br><br>
	<center>
	<table>
		<tr>
			<td width =250><center><a href='User_srch.php' ><img src='../Images/Icons/Users.png' width="150" height="150" ></a></center></td>
			<td width =250><center><a href='Value_srch.php' ><img src='../Images/Icons/valores.png' width="150" height="150" ></a></center></td>
		</tr>
		<tr>
			<td align ='center'>Usuarios</td>
			<td align ='center'>Valores Parametrizados</td>
		</tr>
	</table>
	</center>
<?php
$template->tail();
?>