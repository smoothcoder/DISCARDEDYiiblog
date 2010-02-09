<?php

class Config extends CActiveRecord
{
	/**
	 * The followings are the available columns in table 'Config':
	 * @var string $key
	 * @var string $value
	 * @var string $comment
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
		return 'Config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('key','length','max'=>100),
			array('comment','length','max'=>256),
			array('key, comment', 'required'),
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
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'key' => 'Key',
			'value' => 'Value',
			'comment' => 'Comment',
		);
	}

	/**
	* Prepares attributes before performing validation.
	*/
	protected function beforeValidate($on)
	{
		$this->value=serialize($this->value);
		return true;
	}

	/**
	* Postprocessing after the record is saved
	*/
	protected function afterSave()
	{

	}

}