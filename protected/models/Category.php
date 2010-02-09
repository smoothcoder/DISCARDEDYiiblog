<?php

class Category extends CActiveRecord
{
    /**
     * The followings are the available columns in table 'Category':
     * @var integer $id
     * @var string $name
     * @var string $slug
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
		return 'Category';
	}

	/**
	* @return array validation rules for model attributes.
	*/
	public function rules()
	{
		return array(
			array('name','length','max'=>64),
			array('slug','length','max'=>32),
			array('name', 'required'),
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
			'posts'=>array(self::HAS_MANY,'Post','categoryId','order'=>'posts.createTime DESC', // MFM 1.1 migration ??
			'condition'=>'status='.Post::STATUS_PUBLISHED.' AND posts.publishTime<'.time()), // MFM 1.1 migration instead of Post
	);
	}

	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels()
	{
		return array(
			'name'=>Yii::t('lan','Name'),
		);
	}

	/**
	* @return array attributes that can be massively assigned
	*/
	public function safeAttributes()
	{
		return array('name');
	}

	/**
	* Prepares attributes before performing validation.
	*/
	protected function beforeValidate($on)
	{
		$this->slug=Post::getSlug('Category',$this->name,($this->isNewRecord)?null:$this->id);
		return true;
	}

	/**
	* @return to be used for dropdowns
	*/
	function getListData()
	{
		return Category::model()->findAllBySql('SELECT id, name FROM Category order by id');
	}
}
