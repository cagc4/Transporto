<?php
include "../Clases/TemplatePage.php";
include "../Clases/Patient.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['docNum']) || !isset($_SESSION['docType'])){
	header('location:Patient_srch.php');
}
$template->headerForms('Mantenimiento de Pacientes');
$template->navigateBar('Patient_vw');
$patient = new Patient();
$patient->getPatient($_SESSION['docNum'], $_SESSION['docType']);
$result = $patient->result->FetchRow();
$patientForm = new JFormer('patientForm', array('title' => '<div align="center"><h2>Modificacion de Pacientes</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($patientForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($patientForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docType']), array('disabled' => false, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => $result['docNum'], 'disabled' => false, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentSingleLineText('name', 'Nombres:  ', array('initialValue' => $result['name'], 'disabled' => false)),
	new JFormComponentSingleLineText('lastName', 'Apellidos:  ', array('initialValue' => $result['lastName'], 'disabled' => false)),
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => $result['address'], 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => false)),
	new JFormComponentDropDown('venue', 'Sede:  ',	$util->fillDropDownCityVew('', $result['venue']), array('disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$patientForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($patientForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($patientForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => false))
));
$jFormPage2->addJFormSection($jFormSection2);
$patientForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$patient = new Patient();
	$respCode = $patient->modifyPatient($formValues, $_SESSION['docNum'], $_SESSION['docType']);
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
