<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'DISCARDEDdev',
    'defaultController'=>'post',
    'language'=>'en',
    'theme'=>'pixeled_white',

    //-- Preloading 'log' component
    'preload'=>array('log'),

    //-- Autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',

	'application.extensions.image',
	'application.extensions.my97DatePicker',
	'application.extensions.WB_Email',
	'application.extensions.fckeditor',
    ),

    //-- Application components
    'components'=>array(
	'log'=>array(
		'class'=>'CLogRouter',
		'routes'=>array(
			array(
			'class'=>'CFileLogRoute',
 			'levels'=>'error, warning',
// 			'levels'=>'error, warning, trace',		//for debugtoolbar mode
			),
/*			array( // configuration for the debugtoolbar
			'class'=>'XWebDebugRouter',		//for debugtoolbar mode
			'config'=>'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',//for debugtoolbar mode
			'levels'=>'error, warning, trace, profile, info',//for debugtoolbar mode
			),*/
		),
	),
        'image'=>array(
		'class'=>'application.extensions.image.CImageComponent',
		// GD or ImageMagick
		'driver'=>'GD',
		// ImageMagick setup path
		'params'=>array('directory'=>'/opt/local/bin'),
        ),
	'WB_Email' => array(
		'class' =>  'application.extensions.WB_Email.WB_Email',
	),
        'user'=>array(
		// enable cookie-based authentication
		'allowAutoLogin'=>true,
		// force 401 HTTP error if authentication needed
		'loginUrl'=>null,
        ),

      	'db'=>array(
		'class' => 'CDbConnection',
		'connectionString'=>'mysql:host=localhost;dbname=DISCARDEDyiiblog',
                 'username'=>'yiidatabaseuser',
                 'password'=>'yiidbpassword',
	         'charset'=>'utf8'
	),
        'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,
		'rules'=>require(dirname(__FILE__).'/urlrules.php')
        ),
	'config' => array(   // TODO : not sure to keep this
		'class' => 'application.extensions.EConfig',
	),

	'lib_tools' => array(
		'class' => 'application.extensions.lib_tools',
	),

    ),
    // END application components

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>require(dirname(__FILE__).'/params.php'),
);

