<?php
include "../Clases/TemplatePage.php";
include "../Clases/SosOrder.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['number'])){
	header('location:SosOrden_cpy.php');
}
$sosOrder = new SosOrder();
$sosOrder->getSosOrder($_SESSION['number']);
$result = $sosOrder->result->FetchRow();
$template->headerForms('SOS');
$template->navigateBar('SosOrder_pst');

$sosForm = new JFormer('sosForm', array('title' => '<div align="center"><h2>Copia de Orden de Servicio SOS No. '.$_SESSION['number'].'</h2></div>', 'submitButtonText' => 'Copiar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($sosForm->id . 'PatientData', array('title' => 'Paciente'));
$jFormSection1 = new JFormSection($sosForm->id . 'Patient');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('authNumber', 'Numero Autorizacion:  ', array('initialValue' => $result['authNumber'], 'disabled' => true,)),
	new JFormComponentDropDown('docTypePatient', 'Tipo documento Paciente:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypePatient']), array('disabled' => true,)),
	new JFormComponentSingleLineText('docNumPatient', 'Numero documento Paciente:  ', array('initialValue' => $result['docNumPatient'], 'disabled' => true)),
	new JFormComponentDropDown('docTypeCompanion', 'Tipo documento Acompañante:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeCompanion']), array('disabled' => true,)),
    new JFormComponentSingleLineText('docNumCompanion', 'Numero documento Acompañante:  ', array('initialValue' => $result['docNumCompanion'], 'disabled' => true,)),
	new JFormComponentDropDown('relationship', 'Parentezco:  ', $util->fillDropDownVew('cc_parentezco_fld', $result['relationship']), array('initialValue' => $result['relationship'], 'disabled' => true,)),
));
$jFormPage1->addJFormSection($jFormSection1);
$sosForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($sosForm->id . 'SourceData', array('title' => 'Origen'));
$jFormSection2 = new JFormSection($sosForm->id . 'Source');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('source', 'Origen:  ', array('initialValue' => $result['source'], 'disabled' => true)),
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => true)),
	new JFormComponentDate('collectDate', 'Fecha de Recogida:  ', array('initialValue' => $result['collectDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('collectTime', 'Hora de Recogida:  ', array('initialValue' => $result['collectTime'], 'disabled' => true, 'tip' => '<p>Formato HH:MM</p>')),
));
$jFormPage2->addJFormSection($jFormSection2);
$sosForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($sosForm->id . 'Destination1Data', array('title' => 'Destino 1'));
$jFormSection3 = new JFormSection($sosForm->id . 'Destination1');
$jFormSection3->addJFormComponentArray(array(
    new JFormComponentSingleLineText('destination1', 'Destino 1:  ', array('initialValue' => $result['destination1'], 'disabled' => true)),
	new JFormComponentDate('outputDate1', 'Fecha de Salida 1:  ', array('initialValue' => $result['outputDate1'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time1', 'Hora 1:  ', array('initialValue' => $result['time1'], 'disabled' => true, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost1', 'Costo de Servicio 1:  ', array('initialValue' => $result['cost1'], 'disabled' => true)),
));
$jFormPage3->addJFormSection($jFormSection3);
$sosForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($sosForm->id . 'Destination2Data', array('title' => 'Destino 2'));
$jFormSection4 = new JFormSection($sosForm->id . 'Destination2');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentSingleLineText('destination2', 'Destino 2:  ', array('initialValue' => $result['destination2'], 'disabled' => true)),
	new JFormComponentDate('outputDate2', 'Fecha de Salida 2:  ', array('initialValue' => $result['outputDate2'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('time2', 'Hora 2:  ', array('initialValue' => $result['time2'], 'disabled' => true, 'tip' => '<p>Formato HH:MM</p>')),
	new JFormComponentSingleLineText('cost2', 'Costo de Servicio 2:  ', array('initialValue' => $result['cost2'], 'disabled' => true)),
));
$jFormPage4->addJFormSection($jFormSection4);
$sosForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($sosForm->id . 'DriverVehicleData', array('title' => 'Conductor/Vehiculo'));
$jFormSection5 = new JFormSection($sosForm->id . 'DriverVehicle');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => true)),
    new JFormComponentDropDown('docTypeDriver', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeDriver']), array('disabled' => true,)),
    new JFormComponentSingleLineText('docNumDriver', 'Numero documento:  ', array('initialValue' => $result['docNumDriver'], 'disabled' => true,)),
));
$jFormPage5->addJFormSection($jFormSection5);
$sosForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$sosOrder = new SosOrder();
	$respCode = $sosOrder->copySosOrder($_SESSION['number']);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar la copia de la orden de servicio.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=PrintSos.php">');
	}
	return $response;
}
$template->bodyForms($sosForm);
$template->tail();
?>
