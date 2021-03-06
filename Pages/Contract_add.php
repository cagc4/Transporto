<?php
include "../Clases/TemplatePage.php";
include "../Clases/Contract.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$contract = new Contract();
$contract->getNextConsecutive();
$result = $contract->result->FetchRow();
$_SESSION['number'] = $result['number'];
$template->headerForms('Contrato');
$template->navigateBar('Contract_add');

$casualForm = new JFormer('contractForm', array('title' => '<div align="center"><h2>Contrato No. '.$result['number'].' - C</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($casualForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($casualForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentSingleLineText('object', 'Objeto del Contrato:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('number', 'Numero Documento:  ', array('initialValue' => '', 'disabled' => false)),
    new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Use el separador "," para indicar varias placas</p>')),
    new JFormComponentSingleLineText('totalBuses', 'Cantidad Buses:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>La cantidad de buses debe ser igual a la cantidad de placas ingresadas</p>'  )),
    new JFormComponentSingleLineText('numPassengers', 'Numero de Pasajeros:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>El numero de pasajeros no debe superar la capacidad de los buses ingresados</p>'  ))

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
    new JFormComponentSingleLineText('outputTime', 'Hora Salida:  ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('returnTime', 'Hora Regreso:  ', array('initialValue' => '', 'disabled' => false  )),
));
$jFormPage3->addJFormSection($jFormSection3);
$casualForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($casualForm->id . 'ConditionData', array('title' => 'Condiciones'));
$jFormSection4 = new JFormSection($casualForm->id . 'Condition');
$jFormSection4->addJFormComponentArray(array(
    new JFormComponentDate('contractFirm', 'Fecha de Firma del Contrato:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
    new JFormComponentSingleLineText('contractCost', 'Costo del contrato:  ', array('initialValue' => '', 'disabled' => false  )),
    new JFormComponentSingleLineText('advance', 'Abono:  ', array('initialValue' => '', 'disabled' => false  )),
));
$jFormPage4->addJFormSection($jFormSection4);
$casualForm->addJFormPage($jFormPage4);

function onSubmit($formValues) {
	$contract = new Contract();
	$respCode = $contract->addContract($formValues);

	if($respCode != 0) {
		switch ($respCode) {
			case 1:
				$response = array('failureNoticeHtml' => 'El separador de las placas debe ser coma ",".');
				break;
			case 2:
				$response = array('failureNoticeHtml' => 'Una de las placas no existe.');
				break;
			case 3:
				$response = array('failureNoticeHtml' => 'La cantidad de pasajeros no debe superar la capacidad de los buses ingresados.');
				break;
			case 4:
				$response = array('failureNoticeHtml' => 'Se debe ingresar la cantidad de buses.');
				break;
			case 5:
				$response = array('failureNoticeHtml' => 'La cantidad de buses debe corresponder a la cantidad de placas ingresadas.');
				break;
			default:
				$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el Contrato.');
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=PrintContract.php">');
	}
	return $response;
}
$template->bodyForms($casualForm);
$template->tail();
?>
