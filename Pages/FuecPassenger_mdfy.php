<?php
include "../Clases/TemplatePage.php";
include "../Clases/Fuec.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['number']) || !isset($_SESSION['numberId'])){
	header('location:Fuec_srch.php');
}

$template->headerForms('FUEC');
$template->navigateBar('FuecPassenger_mdfy');
$fuec = new Fuec();
$fuec->getPassengerFuecView($_SESSION['number'], $_SESSION['numberId']);
$passenger = $fuec->result->FetchRow();

$fuecForm = new JFormer('fuecForm', array('title' => '<div align="center"><h2>Ocupante del FUEC No. '.$_SESSION['number'].'</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => false));

$jFormPage1 = new JFormPage($fuecForm->id . 'ModifyData', array('title' => 'Modificar Ocupante'));
$jFormSection = new JFormSection($fuecForm->id . 'Modify', array('title' => '<p>Pasajero</p>'));
$jFormSection->addJFormComponentArray(array(
	new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $passenger['docType']), array('disabled' => false)),
	new JFormComponentSingleLineText('docNum', 'Documento:  ', array('initialValue' => $passenger['docNum'], 'disabled' => false, 'tip' => '<p>Deje este campo vacio para eliminar ocupante</p>')),
	new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => $passenger['name'], 'disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection);
$fuecForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$fuec = new Fuec();
	$respCode = $fuec->modifyFuecPassenger($formValues, $_SESSION['number'], $_SESSION['numberId']);
	if($respCode != 0) {
		switch ($respCode) {
			case 10:
				$response = array('failureNoticeHtml' => 'No hay capacidad para ingresar mas ocupantes.');
				break;
			default:
				$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar los ocupantes.');
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=FuecPassenger_srch.php">');
	}
	return $response;
}
$template->bodyForms($fuecForm);
$template->tail();
?>
