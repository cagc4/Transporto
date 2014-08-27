<?php
include "../Clases/TemplatePage.php";
$template = new TemplatePage(false, true, 'empleado');
$location = '';
switch($_GET["Page"]) {
	case 'Customer_srch':
		$_SESSION['docNum'] = $_GET["Numero_Documento"];
		$_SESSION['docType'] = $_GET["Tipo_Identificacion"];
		$location = 'location:Customer_vw.php';
		break;
	case 'Transporter_srch':
		$_SESSION['docNum'] = $_GET["Numero_Documento"];
		$_SESSION['docType'] = $_GET["Tipo_Identificacion"];
		$location = 'location:Transporter_vw.php';
		break;
	case 'Vehicle_srch':
		$_SESSION['plate'] = $_GET["Placa"];
		$location = 'location:Vehicle_vw.php';
		break;
	case 'Document_srch':
		$_SESSION['number'] = $_GET["Numero"];
		$_SESSION['plate'] = $_GET["Placa"];
		$_SESSION['documentType'] = $_GET["Documento"];
		$location = 'location:Document_vw.php';
		break;
	case 'CasualTravel_srch':
		$_SESSION['number'] = $_GET["Consecutivo"];
		$location = 'location:PrintCasual.php';
		break;
	case 'ContractExtract_srch':
		$_SESSION['number'] = $_GET["Consecutivo"];
		$location = 'location:PrintExtract.php';
		break;
	case 'Contract_srch':
		$_SESSION['number'] = $_GET["Consecutivo"];
		$location = 'location:PrintContract.php';
		break;
	case 'User_srch':
		$_SESSION['user'] = $_GET["Usuario"];
		$location = 'location:User_vw.php';
		break;
	case 'Login':
		$_SESSION['user'] = $_GET["Usuario"];
		$location = 'location:UserPass_mdfy.php';
		break;
	case 'Home':
		$_SESSION['role'] = 'cambioClave';
		$location = 'location:UserPass_mdfy.php';
		break;
	case 'Value_srch':
		$_SESSION['fieldValue'] = $_GET["Campo"];
		$_SESSION['value'] = $_GET["Valor"];
		$location = 'location:Value_vw.php';
		break;
	case 'PrintFuec':
		$_SESSION['number'] = $_GET["Numero_FUEC"];
		$location = 'location:PrintFuec.php';
		break;
}
header($location);
?>