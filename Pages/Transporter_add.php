<?php
include "../Clases/TemplatePage.php";
include "../Clases/Transporter.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
$template->headerForms('Mantenimiento de Propietarios/Conductores');
$template->navigateBar('Transporter_add');

$transporterForm = new JFormer('transporterForm', array('title' => '<div align="center"><h2>Mantenimiento de Propietarios/Conductores</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($transporterForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($transporterForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('ownerType', 'Propietario/Conductor:  ', $util->fillDropDown('cc_type_pc_fld'), array('disabled' => false, 'validationOptions' => array('required'),)),
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDown('cc_tipo_doc_fld'), array('disabled' => false, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentDropDown('cityExpedition', 'Lugar de Expedicion:  ',	$util->fillDropDownCity(''), array('disabled' => false)),
	new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentDate('birthDate', 'Fecha de Nacimiento:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>'))
));
$jFormPage1->addJFormSection($jFormSection1);
$transporterForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($transporterForm->id . 'ContactData', array('title' => 'Contacto'));
$jFormSection2 = new JFormSection($transporterForm->id . 'Contact');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentSingleLineText('celPhone', 'Celular:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Ingresar minimo 10 digitos</p>')),
	new JFormComponentSingleLineText('email', 'E-mail:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('email')))
));
$jFormPage2->addJFormSection($jFormSection2);
$transporterForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($transporterForm->id . 'LocationData', array('title' => 'Ubicacion'));
$jFormSection3 = new JFormSection($transporterForm->id . 'Location');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDropDown('state', 'Deparatmento:  ', $util->fillDropDownState(), array('disabled' => false)),
	new JFormComponentDropDown('city', 'Ciudad:  ',	$util->fillDropDownCity(''), array('disabled' => false))
));
$jFormPage3->addJFormSection($jFormSection3);
$transporterForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($transporterForm->id . 'LicenseData', array('title' => 'Licencia'));
$jFormSection4 = new JFormSection($transporterForm->id . 'License');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentDropDown('licenseCategory', 'Categoria:  ', $util->fillDropDown('cc_catLicencia_fld'), array('disabled' => false)),
	new JFormComponentSingleLineText('licenseNum', 'Numero licencia:  ', array('initialValue' => '', 'disabled' => false)),
	new JFormComponentDate('expirationDate', 'Fecha vencimiento:  ', array('initialValue' => '', 'disabled' => false, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
));
$jFormPage4->addJFormSection($jFormSection4);
$transporterForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($transporterForm->id . 'FinancialData', array('title' => 'Financieros'));
$jFormSection5 = new JFormSection($transporterForm->id . 'Financial');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentDropDown('bank', 'Banco:  ', $util->fillDropDown('cc_banco_fld'), array('disabled' => false)),
	new JFormComponentDropDown('acctType', 'Tipo de Cuenta:  ', $util->fillDropDown('cc_tipoCuenta_fld'), array('disabled' => false)),
	new JFormComponentSingleLineText('acctNum', 'Numero de Cuenta:  ', array('initialValue' => '', 'disabled' => false)),
));
$jFormPage5->addJFormSection($jFormSection5);
$transporterForm->addJFormPage($jFormPage5);

$jFormPage6 = new JFormPage($transporterForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection6 = new JFormSection($transporterForm->id . 'Comments');
$jFormSection6->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => '', 'disabled' => false))
));
$jFormPage6->addJFormSection($jFormSection6);
$transporterForm->addJFormPage($jFormPage6);

function onSubmit($formValues) {
	$transporter = new Transporter();
	$respCode = $transporter->addTransporter($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el propietario/conductor.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Transporter_srch.php">');
	}
	return $response;
}
$template->bodyForms($transporterForm);
$template->tail();
?>
