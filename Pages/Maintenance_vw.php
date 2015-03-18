<?php
include "../Clases/TemplatePage.php";
include "../Clases/Maintenance.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['ID'])){
	header('location:Maintenance_srch.php');
}
$template->headerForms('Administracion de Mantenimientos Vehiculares');
$template->navigateBar('Maintenance_vw');
$maintenance = new Maintenance();
$maintenance->getMaintenance($_SESSION['ID']);
$result = $maintenance->result->FetchRow();

$documentForm = new JFormer('maintenanceForm', array('title' => '<div align="center"><h2>Consulta de Mantenimientos Vehiculares</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($documentForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($documentForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('maintenanceType', 'Tipo de Mantenimiento:  ', $util->fillDropDownVew('cc_mantenimiento_fld', $result['maintenanceType']), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => true, 'validationOptions' => array('required'), 'tip' => '<p>El vehiculo debe ser registrado previamente</p>')),
	new JFormComponentDate('maintenanceDate', 'Fecha Mantenimiento:  ', array('initialValue' => $result['maintenanceDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>', 'validationOptions' => array('required'))),
	new JFormComponentDate('nextMaintenanceDate', 'Fecha Proximo Mantenimiento:  ', array('initialValue' => $result['nextMaintenanceDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>', 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('mileage', 'Kilometraje:  ', array('initialValue' => $result['mileage'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('responsible', 'Responsable:  ', array('initialValue' => $result['responsible'], 'disabled' => true)),
	new JFormComponentSingleLineText('place', 'Lugar:  ', array('initialValue' => $result['place'], 'disabled' => true)),
));
$jFormPage1->addJFormSection($jFormSection1);
$documentForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($documentForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($documentForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => true))
));
$jFormPage2->addJFormSection($jFormSection2);
$documentForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Maintenance_mdfy.php">');
	return $response;
}
$template->bodyForms($documentForm);
$template->tail();
?>
