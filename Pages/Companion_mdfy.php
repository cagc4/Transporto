<?php
include "../Clases/TemplatePage.php";
include "../Clases/Companion.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['docNum']) || !isset($_SESSION['docType'])){
	header('location:Companion_srch.php');
}
$template->headerForms('Mantenimiento de Acompañantes');
$template->navigateBar('Companion_vw');
$companion = new Companion();
$companion->getCompanion($_SESSION['docNum'], $_SESSION['docType']);
$result = $companion->result->FetchRow();
$companionForm = new JFormer('companionForm', array('title' => '<div align="center"><h2>Modificacion de Acompañantes</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($companionForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($companionForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docType']), array('disabled' => false, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => $result['docNum'], 'disabled' => false, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentSingleLineText('name', 'Nombres:  ', array('initialValue' => $result['name'], 'disabled' => false)),
	new JFormComponentSingleLineText('lastName', 'Apellidos:  ', array('initialValue' => $result['lastName'], 'disabled' => false)),
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => $result['address'], 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$companionForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($companionForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($companionForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => false))
));
$jFormPage2->addJFormSection($jFormSection2);
$companionForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$companion = new Companion();
	$respCode = $companion->modifyCompanion($formValues, $_SESSION['docNum'], $_SESSION['docType']);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el acompañante.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Companion_srch.php">');
	}
	return $response;
}
$template->bodyForms($companionForm);
$template->tail();
?>
