<?php
include "../Clases/TemplatePage.php";
include "../Clases/SosOrder.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:SosOrden_srch.php');
}
$sosOrder = new SosOrder();
$sosOrder->getSosOrder($_SESSION['number']);
$result = $sosOrder->result->FetchRow();
$template->headerForms('SOS');
$template->navigateBar('SosOrder_mdfy');

$sosForm = new JFormer('sosForm', array('title' => '<div align="center"><h2>Registro de Orden de Servicio SOS No. '.$_SESSION['number'].'</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($sosForm->id . 'PatientData', array('title' => 'Paciente'));
$jFormSection1 = new JFormSection($sosForm->id . 'Patient');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('authNumber', 'Numero Autorizacion:  ', array('initialValue' => $result['authNumber'], 'disabled' => false,)),
	new JFormComponentDropDown('docTypePatient', 'Tipo documento Paciente:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypePatient']), array('disabled' => false,)),
	new JFormComponentSingleLineText('docNumPatient', 'Numero documento Paciente:  ', array('initialValue' => $result['docNumPatient'], 'disabled' => false)),
	new JFormComponentDropDown('docTypeCompanion', 'Tipo documento Acompa&ntilde;ante:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeCompanion']), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumCompanion', 'Numero documento Acompa&ntilde;ante:  ', array('initialValue' => $result['docNumCompanion'], 'disabled' => false,)),
	new JFormComponentDropDown('relationship', 'Parentezco:  ', $util->fillDropDownVew('cc_parentezco_fld', $result['relationship']), array('disabled' => false,)),
));
$jFormPage1->addJFormSection($jFormSection1);
$sosForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($sosForm->id . 'SourceData', array('title' => 'Origen'));
$jFormSection2 = new JFormSection($sosForm->id . 'Source');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('source', 'Origen:  ', array('initialValue' => $result['source'], 'disabled' => false)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => false)),
	new JFormComponentDate('collectDate', 'Fecha de Recogida:  ', array('initialValue' => $result['collectDate'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('collectTime', 'Hora de Recogida:  ', array('initialValue' => $result['collectTime'], 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
));
$jFormPage2->addJFormSection($jFormSection2);
$sosForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($sosForm->id . 'Destination1Data', array('title' => 'Destino 1'));
$jFormSection3 = new JFormSection($sosForm->id . 'Destination1');
$jFormSection3->addJFormComponentArray(array(
    new JFormComponentSingleLineText('destination1', 'Destino 1:  ', array('initialValue' => $result['destination1'], 'disabled' => false)),
	new JFormComponentDate('outputDate1', 'Fecha de Salida 1:  ', array('initialValue' => $result['outputDate1'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time1', 'Hora 1:  ', array('initialValue' => $result['time1'], 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost1', 'Costo de Servicio 1:  ', array('initialValue' => $result['cost1'], 'disabled' => false)),
));
$jFormPage3->addJFormSection($jFormSection3);
$sosForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($sosForm->id . 'Destination2Data', array('title' => 'Destino 2'));
$jFormSection4 = new JFormSection($sosForm->id . 'Destination2');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentSingleLineText('destination2', 'Destino 2:  ', array('initialValue' => $result['destination2'], 'disabled' => false)),
	new JFormComponentDate('outputDate2', 'Fecha de Salida 2:  ', array('initialValue' => $result['outputDate2'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time2', 'Hora 2:  ', array('initialValue' => $result['time2'], 'disabled' => false, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost2', 'Costo de Servicio 2:  ', array('initialValue' => $result['cost2'], 'disabled' => false)),
));
$jFormPage4->addJFormSection($jFormSection4);
$sosForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($sosForm->id . 'DriverVehicleData', array('title' => 'Conductor/Vehiculo'));
$jFormSection5 = new JFormSection($sosForm->id . 'DriverVehicle');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => false)),
    new JFormComponentDropDown('docTypeDriver', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeDriver']), array('disabled' => false,)),
    new JFormComponentSingleLineText('docNumDriver', 'Numero documento:  ', array('initialValue' => $result['docNumDriver'], 'disabled' => false,)),
));
$jFormPage5->addJFormSection($jFormSection5);
$sosForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$sosOrder = new SosOrder();
	$respCode = $sosOrder->modifySosOrder($formValues, $_SESSION['number']);
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
