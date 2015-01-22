<?php
include "../Clases/TemplatePage.php";
include "../Clases/Fuec.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');

$template->headerForms('FUEC');
$template->navigateBar('Fuec_add');

$fuecForm = new JFormer('fuecForm', array('title' => '<div align="center"><h2>Registro de FUEC</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($fuecForm->id . 'GeneralData', array('title' => 'Generales'));
$jFormSection1 = new JFormSection($fuecForm->id . 'General');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('contractNumber', 'Numero Contrato:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
    new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('agreement', 'Convenio consorcio:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$fuecForm->addJFormPage($jFormPage1);

$jFormPage4 = new JFormPage($fuecForm->id . 'ResponsibleData', array('title' => 'Responsable'));
$jFormSection4 = new JFormSection($fuecForm->id . 'Responsible');
$jFormSection4->addJFormComponentArray(array(
    new JFormComponentDropDown('docTypeResponsible', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumResponsible', 'Documento:  ', array('initialValue' => '', 'disabled' => false,)),
	new JFormComponentSingleLineText('nameResponsible', 'Nombre:  ', array('initialValue' => '', 'disabled' => false,)),
	new JFormComponentSingleLineText('phoneResponsible', 'Telefono:  ', array('initialValue' => '', 'disabled' => false,)),
	new JFormComponentSingleLineText('addressResponsible', 'Direccion:  ', array('initialValue' => '', 'disabled' => false,))
));
$jFormPage4->addJFormSection($jFormSection4);
$fuecForm->addJFormPage($jFormPage4);

$jFormPage2 = new JFormPage($fuecForm->id . 'Driver1Data', array('title' => 'Conductor 1'));
$jFormSection2 = new JFormSection($fuecForm->id . 'Driver1');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentDropDown('docTypeDriver1', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false, 'validationOptions' => array('required'))),
    new JFormComponentSingleLineText('docNumDriver1', 'Documento:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
));
$jFormPage2->addJFormSection($jFormSection2);
$fuecForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($fuecForm->id . 'Driver2Data', array('title' => 'Conductor 2'));
$jFormSection3 = new JFormSection($fuecForm->id . 'Driver2');
$jFormSection3->addJFormComponentArray(array(
    new JFormComponentDropDown('docTypeDriver2', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumDriver2', 'Documento:  ', array('initialValue' => '', 'disabled' => false,)),
));
$jFormPage3->addJFormSection($jFormSection3);
$fuecForm->addJFormPage($jFormPage3);

function onSubmit($formValues) {
	$fuec = new Fuec();
	$respCode = $fuec->addFuec($formValues);
	if($respCode != 0) {
		switch ($respCode) {
			case 1:
				$response = array('failureNoticeHtml' => 'El contrato ingresado no existe.');
				break;
			case 2:
				$response = array('failureNoticeHtml' => 'La placa no existe en el contrato ingresado.');
				break;
			case 3:
				$response = array('failureNoticeHtml' => 'El conductor 1 no existe.');
				break;
			case 4:
				$response = array('failureNoticeHtml' => 'El conductor 2 no existe.');
				break;
			default:
				$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el FUEC.');
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
