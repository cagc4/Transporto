<?php
include "../Clases/TemplatePage.php";
include "../Clases/Customer.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'empleado');
if(!isset($_SESSION['docNum']) || !isset($_SESSION['docType'])){
	header('location:Customer_srch.php');
}
$template->headerForms('Mantenimiento de Clientes');
$template->navigateBar('Customer_vw');
$customer = new Customer();
$customer->getCustomer($_SESSION['docNum'], $_SESSION['docType']);
$result = $customer->result->FetchRow();
$customerForm = new JFormer('customerForm', array('title' => '<div align="center"><h2>Consulta de Clientes</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($customerForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($customerForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
    new JFormComponentDropDown('docType', 'Tipo de documento:  ', $util->fillDropDownVew('cc_tipo_doc_fld', $result['docType'], false), array('disabled' => true, 'validationOptions' => array('required'),)),
	new JFormComponentSingleLineText('docNum', 'Numero documento:  ', array('initialValue' => $result['docNum'], 'disabled' => true, 'validationOptions' => array('required', 'integer'), 'tip' => '<p>Ingresar solo numeros</p>')),
	new JFormComponentDropDown('cityExpedition', 'Ciudad de Expedicion:  ',	$util->fillDropDownCityVew('', $result['cityExpedition']), array('disabled' => true, 'tip' => '<p>Ingresar solo si tipo documento es Cedula de Ciudadania</p>')),
	new JFormComponentSingleLineText('name', 'Nombre/Razon social:  ', array('initialValue' => $result['name'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDate('birthDate', 'Fecha de Nacimiento:  ', array('initialValue' => $result['birthDate'], 'disabled' => true, 'tip' => '<p>Formato MM/DD/AAAA</p>')),
	new JFormComponentSingleLineText('contact', 'Representante legal:  ', array('initialValue' => $result['contact'], 'disabled' => true, 'tip' => '<p>Ingresar solo si tipo documento es NIT</p>'))
));
$jFormPage1->addJFormSection($jFormSection1);
$customerForm->addJFormPage($jFormPage1);

$jFormPage2 = new JFormPage($customerForm->id . 'ContactData', array('title' => 'Contacto'));
$jFormSection2 = new JFormSection($customerForm->id . 'Contact');
$jFormSection2->addJFormComponentArray(array(
	new JFormComponentSingleLineText('phone', 'Telefono:  ', array('initialValue' => $result['phone'], 'disabled' => true)),
	new JFormComponentSingleLineText('celPhone', 'Celular:  ', array('initialValue' => $result['celPhone'], 'disabled' => true, 'validationOptions' => array( 'integer', 'minLength' => 10), 'tip' => '<p>Ingresar minimo 10 digitos</p>')),
	new JFormComponentSingleLineText('email', 'E-mail:  ', array('initialValue' => $result['email'], 'disabled' => true))
));
$jFormPage2->addJFormSection($jFormSection2);
$customerForm->addJFormPage($jFormPage2);

$jFormPage3 = new JFormPage($customerForm->id . 'LocationData', array('title' => 'Ubicacion'));
$jFormSection3 = new JFormSection($customerForm->id . 'Location');
$jFormSection3->addJFormComponentArray(array(
	new JFormComponentSingleLineText('address', 'Direccion:  ', array('initialValue' => $result['address'], 'disabled' => true)),
	new JFormComponentDropDown('state', 'Deparatmento:  ', $util->fillDropDownStateVew($result['state']), array('disabled' => true)),
	new JFormComponentDropDown('city', 'Ciudad:  ',	$util->fillDropDownCityVew('', $result['city']), array('disabled' => true))
));
$jFormPage3->addJFormSection($jFormSection3);
$customerForm->addJFormPage($jFormPage3);

$jFormPage4 = new JFormPage($customerForm->id . 'FinancialData', array('title' => 'Financieros'));
$jFormSection4 = new JFormSection($customerForm->id . 'Financial');
$jFormSection4->addJFormComponentArray(array(
	new JFormComponentDropDown('bank', 'Banco:  ', $util->fillDropDownVew('cc_banco_fld', $result['bank'], false), array('disabled' => true)),
	new JFormComponentDropDown('acctType', 'Tipo de Cuenta:  ', $util->fillDropDownVew('cc_tipoCuenta_fld', $result['acctType'], false), array('disabled' => true)),
	new JFormComponentSingleLineText('acctNum', 'Numero de Cuenta:  ', array('initialValue' => $result['acctNum'], 'disabled' => true)),
));
$jFormPage4->addJFormSection($jFormSection4);
$customerForm->addJFormPage($jFormPage4);

$jFormPage5 = new JFormPage($customerForm->id . 'CommentsData', array('title' => 'Observaciones'));
$jFormSection5 = new JFormSection($customerForm->id . 'Comments');
$jFormSection5->addJFormComponentArray(array(
	new JFormComponentTextArea('details', 'Comentarios:  ', array('initialValue' => $result['acctNum'], 'disabled' => true))
));
$jFormPage5->addJFormSection($jFormSection5);
$customerForm->addJFormPage($jFormPage5);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Customer_mdfy.php">');
	return $response;
}
$template->bodyForms($customerForm);
$template->tail();
?>
