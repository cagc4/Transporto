<?php
include "../Clases/TemplatePage.php";
include "../Clases/Companion.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$template->headerForms('Mantenimiento de Acompa&ntilde;antes');
$template->navigateBar('Companion_add');

$companionForm = new JFormer('companionForm', array('title' => '<div align="center"><h2>Creacion de Acompa&ntilde;antes</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($companionForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($companionForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentSingleLineText('name', 'Nombres:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('lastName', 'Apellidos:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$companionForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($companionForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($companionForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => '', 'disabled' => false))
));
$jFormPage2->addJFormSection($jFormSection2);
$companionForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$companion = new Companion();
	$respCode = $companion->addCompanion($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el acompa&ntilde;ante.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Companion_srch.php">');
	}
	return $response;
}
$template->bodyForms($companionForm);
$template->tail();
?>
