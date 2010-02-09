<?php

class Product extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Product':
	 * @var integer $id
	 * @var integer $fileId
	 * @var integer $downloadFileId
	 * @var string $merchant
	 * @var integer $created
	 * @var string $expiration
	 * @var decimal $priceUS
	 * @var string $description
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
		return 'Product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('merchant','length','max'=>64),
			array('description','length','max'=>1024),
			array(' fileId', 'required'),
			array(' fileId', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	* @return array attributes that can be massively assigned
	*/
	public function safeAttributes()
	{
		return array('fileId','downloadFileId','merchant','created','expiration','status','priceUS','description');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		'file'=>array(self::BELONGS_TO,'File','fileId'),
		'downloadfile'=>array(self::BELONGS_TO,'File','downloadFileId'),
		);

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'fileId' => 'File',
			'downloadFileId' =>'Download File',
			'created' => 'Product creation',
			'from' => 'From',
			'expiration' => 'Expiration',
			'priceUS' => 'Price Us',
			'description' => 'Description',
		);
	}

	/**
	* Prepares attributes before performing validation.
	*/
	protected function beforeValidate($on)
	{
		if($this->isNewRecord)
		{
		$this->created=time();
		}
		$this->expiration=strtotime($this->expiration);
		return true;
	}
}