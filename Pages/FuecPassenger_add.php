<?php
include "../Clases/TemplatePage.php";
include "../Clases/Fuec.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:Fuec_srch.php');
}

$template->headerForms('FUEC');
$template->navigateBar('FuecPassenger_add');
$fuec = new Fuec();
$fuec->getCapacityAvailable($_SESSION['number']);
$result = $fuec->result->FetchRow();

$fuecForm = new JFormer('fuecForm', array('title' => '<div align="center"><h2>Ocupantes del FUEC No. '.$_SESSION['number'].'<HR>Capacidad disonible ' . $result['size'] . ' pasajeros</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => false));

$jFormPage1 = new JFormPage($fuecForm->id . 'BasicData');

if($result['size'] > 1) {
	$jFormSection1 = new JFormSection($fuecForm->id . 'Basic', array(
			'title' => '<p>Pasajero</p>',
			'instanceOptions' => array('max' => (int)$result['size'], 'addButtonText' => 'Adicionar', 'removeButtonText' => 'Quitar',)
	));
	$jFormSection1->addJFormComponentArray(array(
		new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false)),
		new JFormComponentSingleLineText('docNum', 'Documento:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Campo requerido para crear ocupante</p>')),
		new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => '', 'disabled' => false)),
	));
	$jFormPage1->addJFormSection($jFormSection1);
	$fuecForm->addJFormPage($jFormPage1);
}
else {
	if($result['size'] == 1) {
		$jFormSection1 = new JFormSection($fuecForm->id . 'Basic', array('title' => '<p>Pasajero</p>'));
		$jFormSection1->addJFormComponentArray(array(
			new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false)),
			new JFormComponentSingleLineText('docNum', 'Documento:  ', array('initialValue' => '', 'disabled' => false)),
			new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => '', 'disabled' => false)),
		));
		$jFormPage1->addJFormSection($jFormSection1);
		$fuecForm->addJFormPage($jFormPage1);
	}
	else {
		$jFormSection1 = new JFormSection($fuecForm->id . 'Basic', array('title' => '<p>Pasajero</p>'));
		$jFormSection1->addJFormComponentArray(array(
			new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => true)),
			new JFormComponentSingleLineText('docNum', 'Documento:  ', array('initialValue' => '', 'disabled' => true)),
			new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => '', 'disabled' => true)),
		));
		$jFormPage1->addJFormSection($jFormSection1);
		$fuecForm->addJFormPage($jFormPage1);
	}
}

function onSubmit($formValues) {
	$fuec = new Fuec();
	$respCode = $fuec->addFuecPassenger($formValues, $_SESSION['number']);
	if($respCode != 0) {
		switch ($respCode) {
			case 1:
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
