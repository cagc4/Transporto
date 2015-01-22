<?php
include "../Clases/TemplatePage.php";
include "../Clases/Document.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$template->headerForms('Mantenimiento de Documentos');
$template->navigateBar('Document_add');

$documentForm = new JFormer('documentForm', array('title' => '<div align="center"><h2>Creacion de Documentos</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($documentForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($documentForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('documentType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_docum_fld'), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('number', 'Numero:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'), 'tip' => '<p>El vehiculo debe ser registrado previamente</p>')),
	new JFormComponentSingleLineText('transitAgency', 'Organismo de Transito:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Aplica solo para Licencia de Transito</p>')),
));
$jFormPage1->addJFormSection($jFormSection1);
$documentForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($documentForm->id . 'InsuranceData', array('title' => 'Seguro'));
$jFormSection2 = new JFormSection($documentForm->id . 'Insurance');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('insurance', 'Compania:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Aplica para cualquier tipo de Seguro</p>')),
	new JFormComponentDate('dateOfIssue', 'Fecha de Expedicion:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentDate('expirationDate', 'Fecha de Vencimiento:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>'))
));
$jFormPage2->addJFormSection($jFormSection2);
$documentForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($documentForm->id . 'CoverageData', array('title' => 'Cobertura'));
$jFormSection3 = new JFormSection($documentForm->id . 'Coverage');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentTextArea('coverage', 'Cobertura:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Aplica para cualquier tipo de Seguro</p>'))
));
$jFormPage3->addJFormSection($jFormSection3);
$documentForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($documentForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection4 = new JFormSection($documentForm->id . 'Comments');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => '', 'disabled' => false))
));
$jFormPage4->addJFormSection($jFormSection4);
$documentForm->addJFormPage($jFormPage4);

function onSubmit($formValues) {
	$document = new Document();
	$respCode = $document->addDocument($formValues);
	if($respCode != 0) {
		if($respCode == 1) {
			$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el documento.');
		}
		else {
			if($respCode == 2) {
				$response = array('failureNoticeHtml' => 'La placa del vehiculo ingresado no existe.');
			}
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Document_srch.php">');
	}
	return $response;
}
$template->bodyForms($documentForm);
$template->tail();
?>
