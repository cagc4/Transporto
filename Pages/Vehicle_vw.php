<?php
include "../Clases/TemplatePage.php";
include "../Clases/Vehicle.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['plate'])){
	header('location:Vehicle_srch.php');
}
$template->headerForms('Mantenimiento de Vehiculos');
$template->navigateBar('Vehicle_vw');
$vehicle = new Vehicle();
$vehicle->getVehicle($_SESSION['plate']);
$result = $vehicle->result->FetchRow();

$vehicleForm = new JFormer('vehicleForm', array('title' => '<div align="center"><h2>Consulta de Vehiculos</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($vehicleForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($vehicleForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('internalCode', 'Codigo interno:  ', array('initialValue' => $result['internalCode'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('trademark', 'Marca:  ', $util->fillDropDownVew('cc_marca_fld', $result['trademark'], false), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('class', 'Clase:  ', $util->fillDropDownVew('cc_clase_fld', $result['class'], false), array('disabled' => true)),
	new JFormComponentDropDown('model', 'Modelo:  ', $util->fillDropDownModelVew($result['model']), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('color', 'Color:  ', $util->fillDropDownVew('cc_color_fld', $result['color'], false), array('disabled' => true)),
));
$jFormPage1->addJFormSection($jFormSection1);
$vehicleForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($vehicleForm->id . 'FeatureData', array('title' => 'Caracteristicas'));
$jFormSection2 = new JFormSection($vehicleForm->id . 'Feature');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentDropDown('type', 'Tipo:  ', $util->fillDropDownVew('cc_tipo_fld', $result['type'], false), array('disabled' => true)),
	new JFormComponentSingleLineText('size', 'Capacidad:  ', array('initialValue' => $result['size'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numMachine', 'Numero Motor:  ', array('initialValue' => $result['numMachine'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numChassis', 'Numero Chasis:  ', array('initialValue' => $result['numChassis'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('cylinderCapcity', 'Cilindraje:  ', array('initialValue' => $result['cylinderCapcity'], 'disabled' => true, 'validationOptions' => array('required')))
));
$jFormPage2->addJFormSection($jFormSection2);
$vehicleForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($vehicleForm->id . 'OwnerData', array('title' => 'Propietario'));
$jFormSection3 = new JFormSection($vehicleForm->id . 'Owner');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentDropDown('docTypeOwner', 'Tipo Documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeOwner'], false), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('numDocOwner', 'Numero Documento:  ', array('initialValue' => $result['numDocOwner'], 'disabled' => true, 'validationOptions' => array('required', 'integer'))),
));
$jFormPage3->addJFormSection($jFormSection3);
$vehicleForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($vehicleForm->id . 'DriverData', array('title' => 'Conductor'));
$jFormSection4 = new JFormSection($vehicleForm->id . 'Driver');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentDropDown('docTypeDriver', 'Tipo Documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docTypeDriver'], false), array('disabled' => true)),
	new JFormComponentSingleLineText('numDocDriver', 'Numero Documento:  ', array('initialValue' => $result['numDocDriver'], 'disabled' => true)),
));
$jFormPage4->addJFormSection($jFormSection4);
$vehicleForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($vehicleForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection5 = new JFormSection($vehicleForm->id . 'Comments');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => true))
));
$jFormPage5->addJFormSection($jFormSection5);
$vehicleForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Vehicle_mdfy.php">');
	return $response;
}
$template->bodyForms($vehicleForm);
$template->tail();
?>
