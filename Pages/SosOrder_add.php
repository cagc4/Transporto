<?php
include "../Clases/TemplatePage.php";
include "../Clases/SosOrder.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$sosOrder = new SosOrder();
$sosOrder->getNextConsecutive();
$result = $sosOrder->result->FetchRow();
$_SESSION['number'] = $result['number'];
$template->headerForms('SOS');
$template->navigateBar('SosOrder_add');

$sosForm = new JFormer('sosForm', array('title' => '<div align="center"><h2>Registro de Orden de Servicio SOS No. '.$result['number'].'</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($sosForm->id . 'PatientData', array('title' => 'Paciente'));
$jFormSection1 = new JFormSection($sosForm->id . 'Patient');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('authNumber', 'Numero Autorizacion:  ', array('initialValue' => '', 'disabled' => false,)),
	new JFormComponentDropDown('docTypePatient', 'Tipo documento Paciente:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false,)),
	new JFormComponentSingleLineText('docNumPatient', 'Numero documento Paciente:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDropDown('docTypeCompanion', 'Tipo documento Acompañante:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumCompanion', 'Numero documento Acompañante:  ', array('initialValue' => '', 'disabled' => false,)),
	new JFormComponentDropDown('relationship', 'Parentezco:  ', $util->fillDropDown('cc_parentezco_fld'), array('initialValue' => '', 'disabled' => false,)),
));
$jFormPage1->addJFormSection($jFormSection1);
$sosForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($sosForm->id . 'SourceData', array('title' => 'Origen'));
$jFormSection2 = new JFormSection($sosForm->id . 'Source');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('source', 'Origen:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDate('collectDate', 'Fecha de Recogida:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('collectTime', 'Hora de Recogida:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
));
$jFormPage2->addJFormSection($jFormSection2);
$sosForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($sosForm->id . 'Destination1Data', array('title' => 'Destino 1'));
$jFormSection3 = new JFormSection($sosForm->id . 'Destination1');
$jFormSection3->addJFormComponentArray(array(
    new JFormComponentSingleLineText('destination1', 'Destino 1:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDate('outputDate1', 'Fecha de Salida 1:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time1', 'Hora 1:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost1', 'Costo de Servicio 1:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage3->addJFormSection($jFormSection3);
$sosForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($sosForm->id . 'Destination2Data', array('title' => 'Destino 2'));
$jFormSection4 = new JFormSection($sosForm->id . 'Destination2');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentSingleLineText('destination2', 'Destino 2:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDate('outputDate2', 'Fecha de Salida 2:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time2', 'Hora 2:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost2', 'Costo de Servicio 2:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage4->addJFormSection($jFormSection4);
$sosForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($sosForm->id . 'DriverVehicleData', array('title' => 'Conductor/Vehiculo'));
$jFormSection5 = new JFormSection($sosForm->id . 'DriverVehicle');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentDropDown('docTypeDriver', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumDriver', 'Numero documento:  ', array('initialValue' => '', 'disabled' => false,)),
));
$jFormPage5->addJFormSection($jFormSection5);
$sosForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$sosOrder = new SosOrder();
	$respCode = $sosOrder->addSosOrder($formValues);
	if($respCode != 0) {
		switch ($respCode) {
			case 1:
				$response = array('failureNoticeHtml' => 'El vehiculo ingresado no existe.');
				break;
			case 2:
				$response = array('failureNoticeHtml' => 'El paciente ingresado no existe.');
				break;
			case 3:
				$response = array('failureNoticeHtml' => 'El acompañante ingresado no existe.');
				break;
			case 4:
				$response = array('failureNoticeHtml' => 'El parentezco debe ingresarse.');
				break;
			case 5:
				$response = array('failureNoticeHtml' => 'El conductor ingresado no existe.');
				break;
			default:
				$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el FUEC.');
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=SosOrder_srch.php">');
	}
	return $response;
}
$template->bodyForms($sosForm);
$template->tail();
?>
