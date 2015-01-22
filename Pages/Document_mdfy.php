<?php
include "../Clases/TemplatePage.php";
include "../Clases/Document.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['number']) || !isset($_SESSION['plate']) || !isset($_SESSION['documentType'])){
	header('location:Document_srch.php');
}
$document = new Document();
$document->getDocument($_SESSION['number'], $_SESSION['plate'], $_SESSION['documentType']);
$result = $document->result->FetchRow();
$template->headerForms('Mantenimiento de Documentos');
$template->navigateBar('Document_mdfy');

$documentForm = new JFormer('documentForm', array('title' => '<div align="center"><h2>Modificacion de Documentos</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($documentForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($documentForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('documentType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_docum_fld', $result['documentType'], true), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('number', 'Numero:  ', array('initialValue' => $result['number'], 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => false, 'validationOptions' => array('required'), 'tip' => '<p>El vehiculo debe ser registrado previamente</p>')),
	new JFormComponentSingleLineText('transitAgency', 'Organismo de Transito:  ', array('initialValue' => $result['transitAgency'], 'disabled' => false, 'tip' => '<p>Aplica solo para Licencia de Transito</p>')),
));
$jFormPage1->addJFormSection($jFormSection1);
$documentForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($documentForm->id . 'InsuranceData', array('title' => 'Seguro'));
$jFormSection2 = new JFormSection($documentForm->id . 'Insurance');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('insurance', 'Compania:  ', array('initialValue' => $result['insurance'], 'disabled' => false, 'tip' => '<p>Aplica para cualquier tipo de Seguro</p>')),
	new JFormComponentDate('dateOfIssue', 'Fecha de Expedicion:  ', array('initialValue' => $result['dateOfIssue'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentDate('expirationDate', 'Fecha de Vencimiento:  ', array('initialValue' => $result['expirationDate'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>'))
));
$jFormPage2->addJFormSection($jFormSection2);
$documentForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($documentForm->id . 'CoverageData', array('title' => 'Cobertura'));
$jFormSection3 = new JFormSection($documentForm->id . 'Coverage');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentTextArea('coverage', 'Cobertura:  ', array('initialValue' => $result['coverage'], 'disabled' => false, 'tip' => '<p>Aplica para cualquier tipo de Seguro</p>'))
));
$jFormPage3->addJFormSection($jFormSection3);
$documentForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($documentForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection4 = new JFormSection($documentForm->id . 'Comments');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => false))
));
$jFormPage4->addJFormSection($jFormSection4);
$documentForm->addJFormPage($jFormPage4);

function onSubmit($formValues) {
	$document = new Document();
	$respCode = $document->modifyDocument($formValues, $_SESSION['number'], $_SESSION['plate'], $_SESSION['documentType']);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el documento.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Document_srch.php">');
	}
	return $response;
}
$template->bodyForms($documentForm);
$template->tail();
?>
