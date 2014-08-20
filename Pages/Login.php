<?php
include "../Clases/TemplatePage.php";
if ( isset ( $_SESSION['role'] ))
	session_destroy();
session_start();

$template = new TemplatePage(true, false, '');
$template->headerForms('Login de Usuario');

$loginForm = new JFormer('loginForm', array('title' => '<div align="center"><h2>Ingreso al Sistema</h2></div>','submitButtonText' => 'Login', 'requiredText' => ' (Requerido)'));

$loginForm->addJFormComponentArray(array(new JFormComponentSingleLineText('username', 'Usuario:  ', array('validationOptions' => array('required', 'username'),'tip' => '<p>Ingrese su usuario</p>','persistentTip' => false)),

new JFormComponentSingleLineText('password', 'Clave:  ', array('type' => 'password','validationOptions' => array('required'),'tip' => '<p>Ingrese su clave</p>',)),));


function onSubmit($formValues) {

	$util = new Utilities();
	$user=$util->sessionStart($formValues->username,$formValues->password);

	if($user != null) {
		$_SESSION['user'] = $formValues->username;
		if($user['state'] == 'C') {
			$_SESSION['role']='cambioClave';
			$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=PassThrough.php?Page=Login&Usuario='.$formValues->username.'">');
		}
		else {
			if($user['role'] == '01')
			{
					$_SESSION['role']='administrador';
					$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=HomeAdmin.php">');
			}
			else {
				if($user['role'] == '02') {

					$_SESSION['role']='empleado';
					$response = array('successPageHtml' => '<meta http-equiv="refresh" content="0; url=Home.php">');
				}
			}
		}
	}
	else {
		$response = array('failureNoticeHtml' => 'El usuario o password son incorrectos','failureJs' => "$('#password').val('').focus();",);
	}
	return $response;
}


$template->bodyForms($loginForm);
$template->tail();
?>