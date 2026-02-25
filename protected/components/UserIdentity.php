<?php

class UserIdentity extends CUserIdentity
{
	private $_id;

	public function authenticate()
	{
		$user = User::model()->find('LOWER(username)=?', array(strtolower($this->username)));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} elseif (!CPasswordHelper::verifyPassword($this->password, $user->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			$this->_id = $user->id;
			$this->setState('username', $user->username);
			$this->errorCode = self::ERROR_NONE;
		}

		return !$this->errorCode;
	}

	public function getId()
	{
		return $this->_id;
	}
}
