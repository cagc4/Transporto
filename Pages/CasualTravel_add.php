<?php
include "../Clases/TemplatePage.php";
include "../Clases/CasualTravel.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$casualTravel = new CasualTravel();
$casualTravel->getNextConsecutive();
$result = $casualTravel->result->FetchRow();
$_SESSION['number'] = $result['number'];
$template->headerForms('Viaje Ocacional');
$template->navigateBar('CasualTravel_add');

$casualForm = new JFormer('casualTravelForm', array('title' => '<div align="center"><h2>Viaje Ocacional No. '.$result['number'].' - P</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($casualForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($casualForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('object', 'Objeto del Contrato:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('number', 'Numero Documento:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('responsible', 'Responsable del Viaje:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('totalBuses', 'Cantidad Buses:  ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('numPassengers', 'Numero de Pasajeros  ', array('initialValue' => '', 'disabled' => false  )),
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

$jFormPage4 = new JFormPage($casualForm->id . 'DriversData', array('title' => 'Conductores'));
$jFormSection4 = new JFormSection($casualForm->id . 'Drivers');
$jFormSection4->addJFormComponentArray(array(
    new JFormComponentSingleLineText('driverone', 'Conductor 1', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('drivertwo', 'Conductor 2', array('initialValue' => '', 'disabled' => false  )),
));
$jFormPage4->addJFormSection($jFormSection4);
$casualForm->addJFormPage($jFormPage4);



function onSubmit($formValues) {
	$casualTravel = new CasualTravel();
	$respCode = $casualTravel->addCasualTravel($formValues);
	if($respCode != 0) {
		switch ($respCode) {
			case 1:
				$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el viaje ocacional.');
				break;
			case 2:
				$response = array('failureNoticeHtml' => 'La placa del vehiculo ingresado no existe.','failureJs' => "$('#plate').focus();");
				break;
			case 3:
				$response = array('failureNoticeHtml' => 'La cantidad de pasajeros no puede superar la capacidad del bus.','failureJs' => "$('#numPassengers').focus();");
				break;
			case 4:
				$response = array('failureNoticeHtml' => 'El vehiculo presenta alguno de sus documentos vencidos.','failureJs' => "$('#plate').focus();");
				break;
			case 5:
				$response = array('failureNoticeHtml' => 'El conductor 1 no existe.','failureJs' => "$('#driverone').focus();");
				break;
			case 6:
				$response = array('failureNoticeHtml' => 'El conductor 2 no existe.','failureJs' => "$('#drivertwo').focus();");
				break;
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=PrintCasual.php">');
	}
	return $response;
}
$template->bodyForms($casualForm);
$template->tail();
?>
