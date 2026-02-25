<?php

class SiteController extends Controller
{
	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', 'actions' => array('index', 'error'), 'users' => array('*')),
			array('allow', 'actions' => array('login', 'register'), 'users' => array('?')),
			array('allow', 'actions' => array('logout'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$this->redirect(array('/book/index'));
	}

	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				$this->render('error', $error);
			}
		}
	}

	public function actionLogin()
	{
		$model = new LoginForm;

		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate() && $model->login()) {
				$this->redirect(Yii::app()->user->returnUrl);
			}
		}

		$this->render('login', array('model' => $model));
	}

	public function actionRegister()
	{
		$model = new RegisterForm;

		if (isset($_POST['RegisterForm'])) {
			$model->attributes = $_POST['RegisterForm'];
			if ($model->validate()) {
				$user = new User;
				$user->username = $model->username;
				$user->password = CPasswordHelper::hashPassword($model->password);
				$user->email = $model->email;
				if ($user->save()) {
					Yii::app()->user->setFlash('success', 'Регистрация прошла успешно. Войдите в систему.');
					$this->redirect(array('/site/login'));
				}
			}
		}

		$this->render('register', array('model' => $model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
