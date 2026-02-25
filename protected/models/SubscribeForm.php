<?php

class SubscribeForm extends CFormModel
{
	public $phone;
	public $author_id;

	public function rules()
	{
		return array(
			array('phone, author_id', 'required'),
			array('author_id', 'numerical', 'integerOnly' => true),
			array('phone', 'length', 'max' => 20),
			array('phone', 'match', 'pattern' => '/^7\d{10}$/',
				'message' => 'Телефон должен быть в формате 7XXXXXXXXXX (11 цифр, начинается с 7)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'phone' => 'Телефон',
			'author_id' => 'Автор',
		);
	}
}
