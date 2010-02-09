<?php
$SITECODE = '123abc';			// Anything that you want, just to add some salt !
$SITEFILENAME = 'file'.$SITECODE; // Just make the directory accordingly to store one type of images

// this contains the application parameters that can be maintained via GUI
return array(
    // sitecode
   'sitecode'=>$SITECODE,
   'sitefileName'=>$SITEFILENAME,
    // avatar path
    'avatarPath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'avatar'.DIRECTORY_SEPARATOR,
    // file path
    'filePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$SITEFILENAME.DIRECTORY_SEPARATOR,
    // no avatar image
    'noAvatar'=>'noavatar.png',
    // avatar width (resize)
    'avatarWidth'=>'64',
    // avatar height (resize)
    'avatarHeight'=>'64',
    // this is displayed in the header section
    'title'=>'DISCARDEDyiiblog',
    // this is description
    'description'=>'Blog for yii development',
    // this is keywords
    'keywords'=>'Moira,read,book,image',
    // this is used in error pages

    'adminEmail'=>'zzzzzzzz@gmail.com',
    // number of posts displayed per page
    'postsPerPage'=>2,
    // whether post comments need to be approved before published
    'commentNeedApproval'=>true,
    // the copyright information displayed in the footer section
    'copyrightInfo'=>'Copyright &copy; 2009 by DiscardedTeenz.com',
    // Image size in list of files
    'imageThumbnailBoundingBox'=>'80',
    // Registration confirm (better leave allways true)
    'confirmRegistration'=>true,
    // Email From
    'emailFrom'=>'DISCARDEDdev Website',
   'dateformat'=>'Y-m-d', //F j, Y
   'dateformatpicker'=>'yyyy-MM-dd HH:mm',
   // FOR USER_Controller sending emails with WB_Email and PHPMailer in SMTP mode
	'smtp_server'=>'smtp.gmail.com',
	'smtp_address'=>'xxxxxxxxx@gmail.com',
	'smtp_username'=>'xxxxxxxxx@gmail.com',
	'smtp_password'=>'yyyyyyyyy',
	'smtp_port'=>587,
	'smtp_secure'=>'tls',
	'NotifyAdminOnRegistration'=>true,

  // few scripts :
	'script_sideright_1'=>'',
	'adsense_header468x60right'=>'<paste the entire script here>', //complete adsense script

	'adsense_navright960x15left'=>'<paste the entire script here>', //complete adsense script

	'ganalytics_tracker'=>'<paste the entire script here>', //complete google analytics script


   // FOR translating messages
   'sourcePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'themes/pixeled',
   'messagePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'messages',
   'languages' =>array('es','fr','zh_cn'),
   'fileTypes'=>array('php', 'xml'),
   'translator'=>'Yii::t',

);
