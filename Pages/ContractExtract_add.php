<?php
include "../Clases/TemplatePage.php";
include "../Clases/ContractExtract.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$contractExtract = new ContractExtract();
$contractExtract->getNextConsecutive();
$result = $contractExtract->result->FetchRow();
$_SESSION['number'] = $result['number'];
$template->headerForms('Extracto de Contrato');
$template->navigateBar('ContractExtract_add');

$casualForm = new JFormer('contractExtractForm', array('title' => '<div align="center"><h2>Extracto de Contrato No. '.$result['number'].' - C</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($casualForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($casualForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('object', 'Objeto del Contrato:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('number', 'Numero Documento:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('totalBuses', 'Cantidad Buses:  ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('numPassengers', 'Numero de Pasajeros:  ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentMultipleChoice('school', '', array(array('value' => '', 'label' => 'Escolar', 'checked' => false, 'disabled' => false))),

));
$jFormPage1->addJFormSection($jFormSection1);
$casualForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($casualForm->id . 'LocationData', array('title' => 'Localizacion'));
$jFormSection2 = new JFormSection($casualForm->id . 'Location');
$jFormSection2->addJFormComponentArray(array(
    new JFormComponentSingleLineText('provenience', 'Origen:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('destination', 'Destino:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('outputAddress', 'Direccion Salida  ', array('initialValue' => '', 'disabled' => false  )),
));
$jFormPage2->addJFormSection($jFormSection2);
$casualForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($casualForm->id . 'ScheduleData', array('title' => 'Horarios'));
$jFormSection3 = new JFormSection($casualForm->id . 'Schedule');
$jFormSection3->addJFormComponentArray(array(
    new JFormComponentDate('outputDate', 'Fecha de Salida:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
    new JFormComponentDate('returnDate', 'Fecha de Regreso:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
    new JFormComponentSingleLineText('outputTime', 'Hora Salida ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('returnTime', 'Hora Regreso', array('initialValue' => '', 'disabled' => false  )),
));
$jFormPage3->addJFormSection($jFormSection3);
$casualForm->addJFormPage($jFormPage3);

function onSubmit($formValues) {
	$contractExtract = new ContractExtract();
	$respCode = $contractExtract->addContractExtract($formValues);
	if($respCode != 0) {
		if($respCode == 1) {
			$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el Extracto de Contrato.');
		}
		else {
			if($respCode == 2) {
				$response = array('failureNoticeHtml' => 'La placa del vehiculo ingresado no existe.');
			}
			else {
				if($respCode == 3) {
					$response = array('failureNoticeHtml' => 'La cantidad de pasajeros no puede superar la capacidad del bus.');
				}
			}
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=PrintExtract.php">');
	}
	return $response;
}
$template->bodyForms($casualForm);
$template->tail();
?>
