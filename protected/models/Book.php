<?php

class Book extends CActiveRecord
{
	public $cover_file;

	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'book';
	}

	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max' => 255),
			array('year', 'numerical', 'integerOnly' => true),
			array('isbn', 'length', 'max' => 20),
			array('description', 'safe'),
			array('cover_file', 'file',
				'types' => 'jpg, jpeg, png, gif',
				'maxSize' => 5 * 1024 * 1024,
				'allowEmpty' => true,
			),
		);
	}

	public function relations()
	{
		return array(
			'authors' => array(self::MANY_MANY, 'Author', 'book_author(book_id, author_id)'),
			'bookAuthors' => array(self::HAS_MANY, 'BookAuthor', 'book_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'year' => 'Год выпуска',
			'description' => 'Описание',
			'isbn' => 'ISBN',
			'cover_image' => 'Обложка',
			'cover_file' => 'Файл обложки',
			'created_at' => 'Дата добавления',
		);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		return parent::beforeSave();
	}

	public function getUploadPath()
	{
		return Yii::app()->basePath . '/../uploads/';
	}

	public function getCoverUrl()
	{
		if ($this->cover_image) {
			return Yii::app()->baseUrl . '/uploads/' . $this->cover_image;
		}
		return null;
	}

	public function beforeDelete()
	{
		if ($this->cover_image) {
			$path = $this->getUploadPath() . $this->cover_image;
			if (file_exists($path)) {
				@unlink($path);
			}
		}
		return parent::beforeDelete();
	}
}
