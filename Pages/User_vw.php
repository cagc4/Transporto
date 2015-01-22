<?php
include "../Clases/TemplatePage.php";
include "../Clases/User.php";

$util = new Utilities();
$template = new TemplatePage(true, true, 'administrador');
if(!isset($_SESSION['user'])){
	header('location:User_srch.php');
}
$template->headerForms('Mantenimiento de Usuarios');
$template->navigateBar('User_vw');
$user = new User();
$user->getUser($_SESSION['user']);
$result = $user->result->FetchRow();

$userForm = new JFormer('userForm', array('title' => '<div align="center"><h2>Consulta de Usuarios</h2></div>', 'submitButtonText' => 'Modificar', 'requiredText' => '*', 'pageNavigator' => true));

$jFormPage1 = new JFormPage($userForm->id . 'BasicData', array('title' => 'Basicos'));
$jFormSection1 = new JFormSection($userForm->id . 'Basic');
$jFormSection1->addJFormComponentArray(array(
	new JFormComponentSingleLineText('user', 'Usuario:  ', array('initialValue' => $result['user'], 'disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('role', 'Perfil:  ', $util->fillDropDownVew('cc_role_fld', $result['role'], false), array('disabled' => true, 'validationOptions' => array('required'))),
	new JFormComponentDropDown('state', 'Estado:  ', $util->fillDropDownVew('cc_estado_fld', $result['state'], false), array('disabled' => true, 'validationOptions' => array('required')))
));
$jFormPage1->addJFormSection($jFormSection1);
$userForm->addJFormPage($jFormPage1);

function onSubmit($formValues) {
	$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=User_mdfy.php">');
	return $response;
}
$template->bodyForms($userForm);
$template->tail();
?>
