<?php

class RegisterForm extends CFormModel
{
	public $username;
	public $password;
	public $password_confirm;
	public $email;

	public function rules()
	{
		return array(
			array('username, password, password_confirm, email', 'required'),
			array('email', 'email'),
			array('username', 'length', 'min' => 3, 'max' => 255),
			array('password', 'length', 'min' => 6),
			array('password_confirm', 'compare', 'compareAttribute' => 'password',
				'message' => 'Пароли не совпадают'),
			array('username', 'unique', 'className' => 'User', 'attributeName' => 'username',
				'message' => 'Этот логин уже занят'),
			array('email', 'unique', 'className' => 'User', 'attributeName' => 'email',
				'message' => 'Этот email уже используется'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'username' => 'Логин',
			'password' => 'Пароль',
			'password_confirm' => 'Подтверждение пароля',
			'email' => 'Email',
		);
	}
}
