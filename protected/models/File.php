<?php

class File extends CActiveRecord
{
	public $_instancefile;
	const DOWNLOAD_NO=0;
	const DOWNLOAD_YES=1;
	/**
	* The followings are the available columns in table 'File':
	* @var integer $id
	* @var string $name
	* @var string $type
	* @var integer $createTime
	* @var integer $alt
	* @var integer $download
	* @var integer $size
	* @var string $widthxheight
	*/

	/**
	* Returns the static model of the specified AR class.
	* @return CActiveRecord the static model class
	*/
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	* @return string the associated database table name
	*/
	public function tableName()
	{
		return 'File';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
		array('name','length','max'=>64),
		array('type','length','max'=>32),
		array('alt','length','max'=>32),
		array('name', 'required'),
		array('download','in','range'=>array(0,1)), // no-yes
		array('createTime', 'numerical', 'integerOnly'=>true),
		);
	}


	/**
	* @return array attributes that can be massively assigned
	*/
	public function safeAttributes()
	{
		return array('name','alt','download');
	}


	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels()
	{
		return array(
		'name'=>Yii::t('lan','Name'),
		'type'=>Yii::t('lan','Type'),
		'name'=>Yii::t('lan','Name'),
		'createTime'=>Yii::t('lan','Create Time'),
		'alt'=>Yii::t('lan','About file'),
		);
	}

	/**
	* @return array post status names indexed by status IDs
	*/
	public function getDownloadOptions()
	{
		return array(
		self::DOWNLOAD_NO=>Yii::t('lan','Not for download'),
		self::DOWNLOAD_YES=>Yii::t('lan','Downloadable'),

		);
	}

	/**
	* @return string the status display for the current post
	*/
	public function getDownloadText()
	{
		$options=$this->downloadOptions;
		return $options[$this->download];
	}

	/**
	* Prepares attributes before performing validation.
	*/
	protected function beforeValidate()
	{


		if (	(!$this->isNewRecord) 	&& (File::model()->findbyPk($this->id)->name !=$this->name) )
		{
			$this->addError('name',Yii::t('lan','File exists.'));
			return false;
		}
		elseif (	($this->isNewRecord) 	&& (strlen($this->name)==0  )	)
		{
			$this->addError('name',Yii::t('lan','File name is null.'));
			return false;
		}
		elseif (	($this->isNewRecord 	&& file_exists(Yii::app()->params['filePath'].$this->name)) 	)
		{
			$this->name = Yii::t('lan','copy of ').$this->name; //$this->addError('name',Yii::t('lan','File exists.'));
			return true;
		}
		else	return true;
	}

	/**
	* @return image height or weight.
	*/
	public function getHOW($image)
	{
		$size=@getimagesize($image);

		$bb=Yii::app()->params['imageThumbnailBoundingBox'];
		if($size[0]>$bb && $size[1]<=$bb)
		$whtext='width';
		else if($size[0]<=$bb && $size[1]>$bb)
		$whtext='height';
		else if($size[0]>$bb && $size[1]>$bb)
		if(1.0<=$size[1]/$size[0])
		$whtext='height';
		else
		$whtext='width';

		return $whtext;
	}

	/**
	* @return non exist name.
	*/
	function getNonExistName($filename)
	{
		$pathinfo=pathinfo($filename);
		$name=$pathinfo['dirname'].'/'.$pathinfo['filename'];
		$extension=$pathinfo['extension'];

		$k=1;
		while(file_exists($filename))
		{
		$filename=$name.'('.$k.').'.$extension;
		$k++;
		}

		return $pathinfo['filename'].'('.($k-1).').'.$extension;
	}


	/**
	* @return to be used for dropdowns
	*/
	function getListData()
	{
		return File::model()->findAllBySql('SELECT id, name FROM File WHERE download='.self::DOWNLOAD_NO.' ORDER by id');
	}
	/**
	* @return to be used for Download dropdowns
	*/
	function getListDownloadData()
	{
		return File::model()->findAllBySql('SELECT id, name FROM File WHERE download='.self::DOWNLOAD_YES.' ORDER by id');
	}
}
