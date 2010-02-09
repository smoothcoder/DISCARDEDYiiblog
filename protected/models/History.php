<?php

class History extends CActiveRecord
{

	const DOWNLOAD_VAULT = "DOWNLOAD_VAULT";
	const DOWNLOAD_PUBLIC = "DOWNLOAD_PUBLIC";
	/**
	 * The followings are the available columns in table 'History':
	 * @var integer $id
	 * @var integer $created
	 * @var string $username
	 * @var string $IP
	 * @var string $category
	 * @var string $file
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
		return 'History';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username','length','max'=>64),
			array('IP','length','max'=>64),
			array('file','length','max'=>64),
			array('category','length','max'=>64),
			array('created, category', 'required'),
			array('created', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}
	/**
	* @return array attributes that can be massively assigned
	*/
	public function safeAttributes()
	{
		return array('created','username','IP','category','file');
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'created' => 'Created',
			'username' => 'Username',
			'IP' => 'Ip',
			'category' => 'Category',
			'file' => 'File',
		);
	}

	/**
	* Prepares attributes before performing validation.
	*/
	protected function beforeValidate()
	{
		if($this->isNewRecord)
		{
		$this->created=time();
		if (isset (Yii::app()->user->username))
			$this->username=Yii::app()->user->username;
		else $this->username='GUEST';
		$this->IP=$_SERVER['REMOTE_ADDR'];
		}
		return true;
	}

}