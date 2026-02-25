<?php

class Author extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'author';
	}

	public function rules()
	{
		return array(
			array('full_name', 'required'),
			array('full_name', 'length', 'max' => 255),
		);
	}

	public function relations()
	{
		return array(
			'books' => array(self::MANY_MANY, 'Book', 'book_author(author_id, book_id)'),
			'subscriptions' => array(self::HAS_MANY, 'Subscription', 'author_id'),
			'bookCount' => array(self::STAT, 'Book', 'book_author(author_id, book_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'full_name' => 'ФИО',
		);
	}
}
