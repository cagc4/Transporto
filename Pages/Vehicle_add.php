<?php
include "../Clases/TemplatePage.php";
include "../Clases/vehicle.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$template->headerForms('Mantenimiento de Vehiculos');
$template->navigateBar('Vehicle_add');

$vehicleForm = new JFormer('vehicleForm', array('title' => '<div align="center"><h2>Creacion de Vehiculos</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($vehicleForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($vehicleForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('internalCode', 'Codigo interno:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('trademark', 'Marca:  ', $util->fillDropDown('cc_marca_fld'), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('class', 'Clase:  ', $util->fillDropDown('cc_clase_fld'), array('disabled' => false)),
	new JFormComponentDropDown('model', 'Modelo:  ', $util->fillDropDownModel(), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('color', 'Color:  ', $util->fillDropDown('cc_color_fld'), array('disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$vehicleForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($vehicleForm->id . 'FeatureData', array('title' => 'Caracteristicas'));
$jFormSection2 = new JFormSection($vehicleForm->id . 'Feature');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentDropDown('type', 'Tipo:  ', $util->fillDropDown('cc_tipo_fld'), array('disabled' => false)),
	new JFormComponentSingleLineText('size', 'Capacidad:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numMachine', 'Numero Motor:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numChassis', 'Numero Chasis:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('cylinderCapcity', 'Cilindraje:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required')))
));
$jFormPage2->addJFormSection($jFormSection2);
$vehicleForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($vehicleForm->id . 'OwnerData', array('title' => 'Propietario'));
$jFormSection3 = new JFormSection($vehicleForm->id . 'Owner');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentDropDown('docTypeOwner', 'Tipo Documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numDocOwner', 'Numero Documento:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required', 'integer'))),
));
$jFormPage3->addJFormSection($jFormSection3);
$vehicleForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($vehicleForm->id . 'DriverData', array('title' => 'Conductor'));
$jFormSection4 = new JFormSection($vehicleForm->id . 'Driver');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentDropDown('docTypeDriver', 'Tipo Documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false)),
	new JFormComponentSingleLineText('numDocDriver', 'Numero Documento:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage4->addJFormSection($jFormSection4);
$vehicleForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($vehicleForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection5 = new JFormSection($vehicleForm->id . 'Comments');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => '', 'disabled' => false))
));
$jFormPage5->addJFormSection($jFormSection5);
$vehicleForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$vehicle = new Vehicle();
	$respCode = $vehicle->addVehicle($formValues);
	if($respCode != 0) {
		if($respCode == 1) {
			$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el vehiculo.');
		}
		else {
			if($respCode == 2) {
				$response = array('failureNoticeHtml' => 'El propietario ingresado no existe.');
			}
			else {
				if($respCode == 3) {
					$response = array('failureNoticeHtml' => 'El conductor ingresado no existe.');
				}
			}
		}
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=vehicle_srch.php">');
	}
	return $response;
}
$template->bodyForms($vehicleForm);
$template->tail();
?>
