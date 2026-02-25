<?php

class Subscription extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'subscription';
	}

	public function rules()
	{
		return array(
			array('author_id, phone', 'required'),
			array('author_id', 'numerical', 'integerOnly' => true),
			array('phone', 'length', 'max' => 20),
			array('phone', 'match', 'pattern' => '/^7\d{10}$/',
				'message' => 'Телефон должен быть в формате 7XXXXXXXXXX (11 цифр, начинается с 7)'),
		);
	}

	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'author_id' => 'Автор',
			'phone' => 'Телефон',
			'created_at' => 'Дата подписки',
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		return parent::beforeSave();
	}
}
