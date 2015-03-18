<?php
include "../Clases/TemplatePage.php";
include "../Clases/Maintenance.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['ID'])){
	header('location:Maintenance_srch.php');
}
$template->headerForms('Administracion de Mantenimientos Vehiculares');
$template->navigateBar('Maintenance_mdfy');
$maintenance = new Maintenance();
$maintenance->getMaintenance($_SESSION['ID']);
$result = $maintenance->result->FetchRow();

$documentForm = new JFormer('maintenanceForm', array('title' => '<div align="center"><h2>Modificacion de Mantenimientos Vehiculares</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($documentForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($documentForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('maintenanceType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_mantenimiento_fld', $result['maintenanceType']), array('disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('plate', 'Placa:  ', array('initialValue' => $result['plate'], 'disabled' => false, 'validationOptions' => array('required'), 'tip' => '<p>El vehiculo debe ser registrado previamente</p>')),
	new JFormComponentDate('maintenanceDate', 'Fecha Mantenimiento:  ', array('initialValue' => $result['maintenanceDate'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>', 'validationOptions' => array('required'))),
	new JFormComponentDate('nextMaintenanceDate', 'Fecha Proximo Mantenimiento:  ', array('initialValue' => $result['nextMaintenanceDate'], 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>', 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('mileage', 'Kilometraje:  ', array('initialValue' => $result['mileage'], 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('responsible', 'Responsable:  ', array('initialValue' => $result['responsible'], 'disabled' => false)),
	new JFormComponentSingleLineText('place', 'Lugar:  ', array('initialValue' => $result['place'], 'disabled' => false)),
));
$jFormPage1->addJFormSection($jFormSection1);
$documentForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($documentForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection2 = new JFormSection($documentForm->id . 'Comments');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => false))
));
$jFormPage2->addJFormSection($jFormSection2);
$documentForm->addJFormPage($jFormPage2);

function onSubmit($formValues) {
	$maintenance = new Maintenance();
	$respCode = $maintenance->modifyMaintenance($formValues, $_SESSION['ID']);
	if($respCode != 0) {
        switch($respCode) {
            case 1:
                    $response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el mantenimiento vehicular.');
                    break;

            case 2:
				    $response = array('failureNoticeHtml' => 'La placa del vehiculo ingresado no existe.');
                    break;
            case 3:
                    $response = array('failureNoticeHtml' => 'La fecha del mantenimiento debe ser menor o igual a la fecha actual.');
                    break;
            case 4:
                    $response = array('failureNoticeHtml' => 'La fecha del próximo mantenimiento debe ser mayor a la fecha del mantenimiento.');
                    break;
        }
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Maintenance_srch.php">');
	}
	return $response;
}
$template->bodyForms($documentForm);
$template->tail();
?>
