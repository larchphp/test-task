<?php

class User extends CActiveRecord
{
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return array(
			array('username, password, email', 'required'),
			array('username, email', 'length', 'max' => 255),
			array('username', 'unique'),
			array('email', 'unique'),
			array('email', 'email'),
		);
	}

	public function relations()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Логин',
			'password' => 'Пароль',
			'email' => 'Email',
			'created_at' => 'Дата регистрации',
		);
	}

	public function validatePassword($password)
	{
		return CPasswordHelper::verifyPassword($password, $this->password);
	}

	public function hashPassword($password)
	{
		return CPasswordHelper::hashPassword($password);
	}

	public function beforeSave()
	{
		if ($this->isNewRecord) {
			$this->created_at = date('Y-m-d H:i:s');
		}
		return parent::beforeSave();
	}
}
