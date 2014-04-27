<?php 

return array(
	'invokables' => array(
		'Application\Mapper\Session'				=> 'Application\Mapper\Session',
		
		'Application\Service\SessionManager'		=> 'Application\Service\SessionManager',
	),
    'factories' => array(
    	'Application\SessionManager'				=> 'Application\Service\Factory\SessionManagerFactory',
        'Application\SessionSaveHandler'			=> 'Application\Service\Factory\SessionSaveHandlerFactory',
    ),
	'initializers' => array(
    	'Application\Service\DbAdapterInitializer'	=> 'Application\Service\Initializer\DbAdapterInitializer',
    )
);