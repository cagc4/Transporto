<?php
include "../Clases/TemplatePage.php";
include "../Clases/Transporter.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['docNum']) || !isset($_SESSION['docType'])){
	header('location:Transporter_srch.php');
}
$template->headerForms('Mantenimiento de Propietarios/Conductores');
$template->navigateBar('Transporter_vw');
$transporter = new Transporter();
$transporter->getTransporter($_SESSION['docNum'], $_SESSION['docType']);
$result = $transporter->result->FetchRow();
$transporterForm = new JFormer('transporterForm', array('title' => '<div align="center"><h2>Consulta de Propietarios/Conductores</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($transporterForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($transporterForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentDropDown('ownerType', 'Propietario/Conductor:  ', $util->fillDropDownVew('cc_type_pc_fld', $result['ownerType'], false), array('disabled' => true, 'validationOptions' => array('required'),)),
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docType'], false), array('disabled' => true, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => $result['docNum'], 'disabled' => true, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentDropDown('cityExpedition', 'Ciudad de Expedicion:  ',	$util->fillDropDownCityVew('', $result['cityExpedition']), array('disabled' => true, 'tip' => '<p>Ingresar solo si tipo documento es Cedula de Ciudadania</p>')),
	new JFormComponentSingleLineText('name', 'Nombre:  ', array('initialValue' => $result['name'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDate('birthDate', 'Fecha de Nacimiento:  ', array('initialValue' => $result['birthDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>'))
));
$jFormPage1->addJFormSection($jFormSection1);
$transporterForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($transporterForm->id . 'ContactData', array('title' => 'Contacto'));
$jFormSection2 = new JFormSection($transporterForm->id . 'Contact');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => true)),
	new JFormComponentSingleLineText('celPhone', 'Celular:  ', array('initialValue' => $result['celPhone'], 'disabled' => true, 'validationOptions' => array('integer', 'minLength' => 10), 'tip' => '<p>Ingresar minimo 10 digitos</p>')),
	new JFormComponentSingleLineText('email', 'E-mail:  ', array('initialValue' => $result['email'], 'disabled' => true, 'validationOptions' => array('email'))),
));
$jFormPage2->addJFormSection($jFormSection2);
$transporterForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($transporterForm->id . 'LocationData', array('title' => 'Ubicacion'));
$jFormSection3 = new JFormSection($transporterForm->id . 'Location');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => $result['address'], 'disabled' => true)),
	new JFormComponentDropDown('state', 'Deparatmento:  ', $util->fillDropDownStateVew($result['state']), array('disabled' => true)),
	new JFormComponentDropDown('city', 'Ciudad:  ',	$util->fillDropDownCityVew('', $result['city']), array('disabled' => true))
));
$jFormPage3->addJFormSection($jFormSection3);
$transporterForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($transporterForm->id . 'LicenseData', array('title' => 'Licencia'));
$jFormSection4 = new JFormSection($transporterForm->id . 'License');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentDropDown('licenseCategory', 'Categoria:  ', $util->fillDropDownVew('cc_catLicencia_fld', $result['licenseCategory'], false), array('disabled' => true)),
	new JFormComponentSingleLineText('licenseNum', 'Numero licencia:  ', array('initialValue' => $result['licenseNum'], 'disabled' => true)),
	new JFormComponentDate('expirationDate', 'Fecha vencimiento:  ', array('initialValue' => $result['expirationDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
));
$jFormPage4->addJFormSection($jFormSection4);
$transporterForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($transporterForm->id . 'FinancialData', array('title' => 'Financieros'));
$jFormSection5 = new JFormSection($transporterForm->id . 'Financial');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentDropDown('bank', 'Banco:  ', $util->fillDropDownVew('cc_banco_fld', $result['bank'], false), array('disabled' => true)),
	new JFormComponentDropDown('acctType', 'Tipo de Cuenta:  ', $util->fillDropDownVew('cc_tipoCuenta_fld', $result['acctType'], false), array('disabled' => true)),
	new JFormComponentSingleLineText('acctNum', 'Numero de Cuenta:  ', array('initialValue' => $result['acctNum'], 'disabled' => true)),
));
$jFormPage5->addJFormSection($jFormSection5);
$transporterForm->addJFormPage($jFormPage5);

$jFormPage6 = new JFormPage($transporterForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection6 = new JFormSection($transporterForm->id . 'Comments');
$jFormSection6->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['details'], 'disabled' => true))
));
$jFormPage6->addJFormSection($jFormSection6);
$transporterForm->addJFormPage($jFormPage6);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Transporter_mdfy.php">');
	return $response;
}
$template->bodyForms($transporterForm);
$template->tail();
?>
