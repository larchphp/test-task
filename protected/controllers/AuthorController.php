<?php

class AuthorController extends Controller
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
			array('allow', 'actions' => array('index', 'view', 'subscribe'), 'users' => array('*')),
			array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Author', array(
			'criteria' => array(
				'order' => 'full_name ASC',
			),
			'pagination' => array(
				'pageSize' => 20,
			),
		));

		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$subscribeForm = new SubscribeForm;
		$subscribeForm->author_id = $id;

		$this->render('view', array(
			'model' => $model,
			'subscribeForm' => $subscribeForm,
		));
	}

	public function actionCreate()
	{
		$model = new Author;

		if (isset($_POST['Author'])) {
			$model->attributes = $_POST['Author'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Автор успешно создан.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['Author'])) {
			$model->attributes = $_POST['Author'];
			if ($model->save()) {
				Yii::app()->user->setFlash('success', 'Автор успешно обновлён.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Автор удалён.');
			$this->redirect(array('index'));
		} else {
			throw new CHttpException(400, 'Неверный запрос.');
		}
	}

	public function actionSubscribe($id)
	{
		if (!Yii::app()->request->isPostRequest) {
			throw new CHttpException(400, 'Неверный запрос.');
		}

		$author = $this->loadModel($id);
		$form = new SubscribeForm;
		$form->attributes = isset($_POST['SubscribeForm']) ? $_POST['SubscribeForm'] : array();
		$form->author_id = $id;

		if ($form->validate()) {
			$existing = Subscription::model()->findByAttributes(array(
				'author_id' => $id,
				'phone' => $form->phone,
			));

			if ($existing) {
				Yii::app()->user->setFlash('notice', 'Вы уже подписаны на этого автора.');
			} else {
				$sub = new Subscription;
				$sub->author_id = $id;
				$sub->phone = $form->phone;
				if ($sub->save()) {
					Yii::app()->user->setFlash('success', 'Вы подписались на новые книги автора ' . CHtml::encode($author->full_name) . '.');
				} else {
					Yii::app()->user->setFlash('error', 'Ошибка при сохранении подписки.');
				}
			}
		} else {
			$errors = $form->getErrors();
			$msg = '';
			foreach ($errors as $attr => $errs) {
				$msg .= implode('; ', $errs) . ' ';
			}
			Yii::app()->user->setFlash('error', trim($msg));
		}

		$this->redirect(array('view', 'id' => $id));
	}

	private function loadModel($id)
	{
		$model = Author::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'Автор не найден.');
		}
		return $model;
	}
}
