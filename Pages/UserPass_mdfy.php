<?php
include "../Clases/TemplatePage.php";
include "../Clases/User.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'cambioClave');
if(!isset($_SESSION['user'])){
	header('location:Login.php');
}
$template->headerForms('Mantenimiento de Usuarios');
$template->navigateBar('UserPass_mdfy');
$user = new User();
$user->getUser($_SESSION['user']);
$result = $user->result->FetchRow();

$userForm = new JFormer('loginForm', array('title' => '<div align="center"><h2>Cambio de Clave</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($userForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($userForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('user', 'Usuario:  ', array('initialValue' => $result['user'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentSingleLineText('password', 'Clave:  ', array('type' => 'password', 'initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'), 'tip' => '<p>Ingrese su nueva clave</p>'))
));
$jFormPage1->addJFormSection($jFormSection1);
$userForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$user = new User();
	$respCode = $user->modifyUserPass($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el usuario.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Login.php">');
	}
	return $response;
}
$template->bodyForms($userForm);
$template->tail();
?>
