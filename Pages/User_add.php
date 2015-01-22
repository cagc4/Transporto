<?php
include "../Clases/TemplatePage.php";
include "../Clases/User.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'administrador');
$template->headerForms('Mantenimiento de Usuarios');
$template->navigateBar('User_add');

$userForm = new JFormer('userForm', array('title' => '<div align="center"><h2>Creacion de Usuarios</h2></div>', 'submitButtonText' => 'Aceptar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($userForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($userForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('user', 'Usuario:  ', array('initialValue' => '', 'disabled' => false, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('role', 'Perfil:  ', $util->fillDropDown('cc_role_fld'), array('disabled' => false, 'validationOptions' => array('required')))
));
$jFormPage1->addJFormSection($jFormSection1);
$userForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$user = new User();
	$respCode = $user->addUser($formValues);
	if($respCode != 0) {
		$response = array('failureNoticeHtml' => 'Inconvenientes tecnicos al procesar el usuario.');
	}
	else {
		$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=User_srch.php">');
	}
	return $response;
}
$template->bodyForms($userForm);
$template->tail();
?>
