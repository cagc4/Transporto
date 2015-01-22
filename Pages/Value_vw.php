<?php
include "../Clases/TemplatePage.php";
include "../Clases/Value.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'administrador');
if(!isset($_SESSION['fieldValue']) && !isset($_SESSION['value'])){
	header('location:Value_srch.php');
}
$template->headerForms('Mantenimiento de Valores');
$template->navigateBar('Value_vw');
$value = new Value();
$value->getValue($_SESSION['fieldValue'], $_SESSION['value']);
$result = $value->result->FetchRow();

$userForm = new JFormer('valueForm', array('title' => '<div align="center"><h2>Consulta de Valores</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($userForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($userForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('fieldValue', 'Valor:  ', $util->fillDropDownValueVew($result['fieldValue']), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('description', 'Descripcion:  ', array('initialValue' => $result['description'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('value', 'Valor:  ', array('initialValue' => $result['value'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('state', 'Estado:  ', $util->fillDropDownVew('cc_state_fld', $result['state'], false), array('disabled' => true, 'validationOptions' => array('required'))),
));
$jFormPage1->addJFormSection($jFormSection1);
$userForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Value_mdfy.php">');
	return $response;
}
$template->bodyForms($userForm);
$template->tail();
?>
