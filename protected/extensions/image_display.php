<?php
 /***************************************************************************
 * Appshore                                                                 *
 * http://www.appshore.com                                                  *

 * This file written by Brice Michel  bmichel@appshore.com                  *
 * Copyright (C) 2004-2009 Brice Michel                                     *
 ***************************************************************************/


chdir('..');
if( isset( $HTTP_SERVER_VARS ))
{
	list( $subdomain, $domain, $tld) = explode( '.', $HTTP_SERVER_VARS['SERVER_NAME'] );

	if(isset($subdomain) && isset($domain) && isset($tld) && file_exists($domain.'.'.$tld.'.cfg.php') )

	{
		$baseurl = ($HTTP_SERVER_VARS['SERVER_PORT'] == '443' )?'https://':'http://';
		$baseurl .= $subdomain.'.'.$domain.'.'.$tld;
	}
	else
	{
		echo '<br/><br/>Invalid domain name<br/><br/>';

		echo 'Please contact your administrator';
		exit();
	}
}

include_once($domain.'.'.$tld.'.cfg.php');

if( ($fp = @fopen( ($name = APPSHORE_STORAGE.SEP.'logo.gif'), 'rb')) )

	header("Content-Type: image/gif");
elseif( ($fp = @fopen( ($name = APPSHORE_STORAGE.SEP.'logo.png'), 'rb')) )
	header("Content-Type: image/png");
elseif( ($fp = @fopen( ($name = APPSHORE_STORAGE.SEP.'logo.jpg'), 'rb')) )

	header("Content-Type: image/jpeg");
elseif( ($fp = @fopen( ($name = APPSHORE_STORAGE.SEP.'logo.jpeg'), 'rb')) )
	header("Content-Type: image/jpeg");
else
{
	$fp = @fopen( ($name = APPSHORE_API.SEP.'images'.SEP.LOGO), 'rb');

	list( $ignore, $type) = explode( '.', LOGO);
	header("Content-Type: image/".$type);
}
header("Content-Length: " . filesize($name));
fpassthru($fp);
