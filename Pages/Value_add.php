<?php
include "../Clases/TemplatePage.php";
include "../Clases/Value.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'administrador');
$template->headerForms('Mantenimiento de Valores');
$template->navigateBar('Value_add');

$userForm = new JFormer('valueForm', array('title' => '<div align="center"><h2>Creacion de Valores</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($userForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($userForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('fieldValue', 'Valor:  ', $util->fillDropDownValue(), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('description', 'Descripcion:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('value', 'Valor:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required')))
));
$jFormPage1->addJFormSection($jFormSection1);
$userForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$value = new Value();
	$respCode = $value->addValue($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el parametro.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Value_srch.php">');
	}
	return $response;
}
$template->bodyForms($userForm);
$template->tail();
?>
