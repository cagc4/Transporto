
<?php

// CAGC	 001	13-06-2013

// Include the jFormer PHP (use an good path in your code)

//CAGC INICIO 001;
require_once('JFormer/php/JFormer.php');

//CAGC FIN 001;

// Create the form
$loginForm = new JFormer('loginForm', array(
    'title' => '',
    'submitButtonText' => 'Ingresar',
    'requiredText' => ' (Requerido)'
));

// Add components to the section
$loginForm->addJFormComponentArray(array(
    new JFormComponentSingleLineText('username', 'username:', array(
        'validationOptions' => array('required', 'username'),
        'tip' => '<p>Nombre de usuario para ingresar al sistema</p>',
        'persistentTip' => true
    )),
    new JFormComponentSingleLineText('password', 'password:', array(
        'type' => 'password',
        'validationOptions' => array('required', 'password'),
        'tip' => '<p>Password para ingresar al sistema</p>',
    )),
    new JFormComponentMultipleChoice('rememberMe', '',
        array(
            array('label' => 'Recuerdame'),
        ),
        array(
            'tip' => '<p>No cerrar sesión</p>',
        )
    ),
));

// Set the function for a successful form submission
function onSubmit($formValues) {
    // Server side checks go here
    
    if($formValues->username == 'admin' && $formValues->password == '12345') {
        // If they want to be remembered
        if(!empty($formValues->rememberMe)) {
            // Let them know they successfully logged in
            $response = array('successPageHtml' => '
                <h2>Bienvenido a Transporto</h2>
            ');
            // Alternatively, you could also do a redirect
            //return array('redirect' => 'http://www.jformer.com');
        }
        // If they do not want to be remembered
        else {
            $response = array('successPageHtml' => '
                <h2>Bienvenido a Transporto</h2>
            ');
        }
    }
    // If login fails, give a failure notice
    else {
        $response = array(
            'failureNoticeHtml' => 'El usuario o password son incorrectos',
            'failureJs' => "$('#password').val('').focus();",  // You can pass a JavaScript callback to run if it fails
        );
    }

    return $response;
}

// Process any request to the form
$loginForm->processRequest(false);
?>