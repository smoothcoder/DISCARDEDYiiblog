<?php
/**
 * *************************************************************************\
 * Appshore                                                                 *
 * http://www.appshore.com                                                  *
 * This file written by Brice MICHEL <bmichel@appshore.com>                 *
 * Copyright (C) 2004 Brice MICHEL                                          *
 * -------------------------------------------------------------------------*
 * This program is free software; you can redistribute it and/or modify it  *
 * under the terms of the GNU General Public License as published by the    *
 * Free Software Foundation; either version 2 of the License, or (at your   *
 * option) any later version.                                               *
 * \*************************************************************************
 */

// generic classe to download into tables
// classes child specific to each app must be defined to init some variables
// and to build menus
class lib_tools extends CApplicationComponent
{
	private $_baseUrl;
	private $_loadername ='image_loader.php';
	private $_downloadername ='downloader.php';

	// First stage of download where user set up download file type, name and if we have an header
	function safeArgsDownload()
	{
		$args = new safe_args();
		$args->set('pathAndFilename',     NOTSET, 'any');
		$args->set('filename',             NOTSET, 'any');
		$args->set('filetype',             NOTSET, 'any');
		$args = $args->get(func_get_args());

		$this->download( $args['pathAndFilename'], $args['filename'], $args['filetype']);
	}

	public function get_image_loader()
	{
		// Get the resources path
		$loaderpathname = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_loadername;
		 if ( is_file($loaderpathname) )
			//publish image_loader.php
			$this->_baseUrl = Yii::app()->assetManager->publish($loaderpathname,true);
		return ($this->_baseUrl);

	}

	public function get_downloader()
	{
		// Get the resources path
		$loaderpathname = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->_downloadername;
		 if ( is_file($loaderpathname) )
			//publish image_loader.php
			$this->_baseUrl = Yii::app()->assetManager->publish($loaderpathname,true);
		return ($this->_baseUrl);

	}

	public function shorten_string($string, $wordsreturned)
	/*  Returns the first $wordsreturned out of $string.  If string
	contains more words than $wordsreturned, the entire string
	is returned.*/
	{
		$retval = $string;	//	Just in case of a problem
		$array = explode(" ", $string);
		/*  Already short enough, return the whole thing*/
		if (count($array)<=$wordsreturned)
		{
			$retval = $string;
		}
		/*  Need to chop of some words*/
		else
		{
			array_splice($array, $wordsreturned);
			$retval = implode(" ", $array)." ...";
		}
		return $retval;
	}

}