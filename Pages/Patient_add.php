<?php
include "../Clases/TemplatePage.php";
include "../Clases/Patient.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$template->headerForms('Mantenimiento de Pacientes');
$template->navigateBar('Patient_add');

$patientForm = new JFormer('patientForm', array('title' => '<div align="center"><h2>Creacion de Pacientes</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($patientForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($patientForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentSingleLineText('name', 'Nombres:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('lastName', 'Apellidos:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDropDown('venue', 'Sede:  ',	$util->fillDropDownCity(''), array('disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$patientForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($patientForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($patientForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => '', 'disabled' => false))
));
$jFormPage2->addJFormSection($jFormSection2);
$patientForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$patient = new Patient();
	$respCode = $patient->addPatient($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el paciente.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Patient_srch.php">');
	}
	return $response;
}
$template->bodyForms($patientForm);
$template->tail();
?>
