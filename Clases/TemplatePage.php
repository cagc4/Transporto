<?php
include "../Clases/Utilities.php";
include "../Clases/Conexion.php";

class TemplatePage
{
	var $role;

	function TemplatePage($isForm, $validateSession, $role) {

		$util = new Utilities();
		$this->role = $role;

		if($validateSession) {
			$util->validateSession($role);
		}
		if($isForm) {
			require_once('JFormer/php/JFormer.php');
		}
	}

	function logoCabecera() {

	    if ($this->role =='administrador')
	    	$logoCa= "<a href='HomeAdmin.php'><img src='../Images/Logo.png'></a>";
		else
			$logoCa= "<a href='Home.php'><img src='../Images/Logo.png'></a>";

		return $logoCa;

	}
	function background (){
		 $background='';
		 return $background;
	}

	function headerHome($title) {
	?>
		<!DOCTYPE html>
		<html>
		<head>
			<title><?php echo $title; ?></title>
			<link href="css/estilos.css" rel=stylesheet type=text/css>

			<script type='text/javascript' src='js/jquery.js'></script>
			<script type='text/javascript' src='js/jquery.simplemodal.js'></script>
			<script type='text/javascript' src='js/osx.js'></script>

			<table width="100%"  border="0">
				<tr>
					<td colspan="1"><?php echo $this->logoCabecera(); ?></td>
				</tr>
			</table>
       	</head>

       	<?php echo $this->background(); ?>

	<?php
	}
	function headerForms($title) {
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title><?php echo $title; ?></title>
				<link href="css/estilos.css" rel=stylesheet type=text/css>
				<link rel="stylesheet" type="text/css" href="css/EstiloIndex.css">
				<link href="css/estilos.css" rel=stylesheet type=text/css>
				<link rel="stylesheet" type="text/css" href="JFormer/styles/jformer.css" />

				<script type="text/javascript" src="JFormer/scripts/jquery-1.5.2.min.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormerUtility.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormer.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponent.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentAddress.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentCreditCard.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentDate.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentDropDown.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentFile.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentHidden.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentLikert.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentLikertStatement.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentMultipleChoice.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentName.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentSingleLineText.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormComponentTextArea.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormPage.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormSection.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormerDatePicker.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormerMask.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormerScroller.js"></script>
				<script type="text/javascript" src="JFormer/scripts/JFormerTip.js"></script>
				<table width="100%" >
					<tr>
						<td colspan="1"><?php echo $this->logoCabecera(); ?></td>
					</tr>
				</table>
			</head>
			<?php echo $this->background(); ?>
				<br>
		<?php
	}

	function headerSearch($title, $gridName, $tableName, $query) {
		include "Datagrid/inc/jqgrid_dist.php";
		$util = new Utilities();

		$render = $util->getDataGrid($gridName, $tableName, $query);
		?>
		<!DOCTYPE html>
		<html>
			<head>
				<title><?php echo $title; ?></title>
				<link href="css/estilos.css" rel=stylesheet type=text/css>
				<link rel="stylesheet" type="text/css" media="screen" href="Datagrid/js/themes/redmond/jquery-ui.custom.css"></link>
				<link rel="stylesheet" type="text/css" media="screen" href="Datagrid/js/jqgrid/css/ui.jqgrid.css"></link>

				<script src="Datagrid/js/jquery.min.js" type="text/javascript"></script>
				<script src="Datagrid/js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
				<script src="Datagrid/js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
				<script src="Datagrid/js/themes/jquery-ui.custom.min.js" type="text/javascript"></script>
				<table width="100%"  border="0">
					<tr>
						<td colspan="1"><?php echo $this->logoCabecera(); ?></td>
					</tr>
				</table>
			</head>
			<?php echo $this->background(); ?>
		<?php
		return $render;
	}

	function navigateBar($page) {
			$util = new Utilities();
			echo '<table align=right>';
			echo '<tr>';


			$menu = $util->findMenu ($page);


			while ($row = $menu->FetchRow()){

				$direccion = $row["cc_url_fld"];
				$tipo = $row["cc_type_fld"];
				$image = $row["cc_nombre_fld"];

				$icono = "<img src='$image' border=0 >";

				if ($tipo =='hel' or $tipo =='web')
					$enlace = "<a href='$direccion' target='_blank'>";
				else
					if ($tipo == 'war')
					{
						$enlace = "<a href='$direccion' class='osx'>";
					}
					else{
						$enlace = "<a href='$direccion'>";
					}

				echo "<td>".$enlace." ".$icono."</a></td>";
			}

			echo '</tr>';
			echo '</table>';
			echo '<br>';
	}

	function bodyForms($form) {
		?>
			<div  align=center>
				<?php

					if  ($form->id == 'loginForm')
						echo "<div class='login'>";
					else
						echo "<div class='forms'>";

				?>


				 <?php
				 	$form->processRequest(false);
				 ?>
			</div>
		<?php
	}

	function bodySearch($render) {
		?>
			<center>
				<div style="margin:10px">
					<br><br>
					<?php echo $render; ?>
				</div>
			</center>
		<?php
	}

   function warnings(){
   		$util = new Utilities();
		$util->imprimirWarnings();
   }

    function tail() {
		?>

				<br><br><br><br>
				<footer>
						<p>Transcorvalle SAS Direcci&#243;n: Calle 27 # 32-47 ,Tel&#233;fono: (2) 2253308,Tulu&#225;, Valle del Cauca, Colombia 2014<br>
						<a href='http://www.transcorvalle.com.co' style="background-color:transaparent" class='enlace'>www.transcorvalle.com.co</a>
				</footer>
			</body>
		</html>
		<?php
	}

}
?>
