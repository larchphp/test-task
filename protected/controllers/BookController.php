<?php

class BookController extends Controller
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
			array('allow', 'actions' => array('index', 'view'), 'users' => array('*')),
			array('allow', 'actions' => array('create', 'update', 'delete'), 'users' => array('@')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('authors');
		$criteria->order = 't.title ASC';

		$dataProvider = new CActiveDataProvider('Book', array(
			'criteria' => $criteria,
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

		$this->render('view', array(
			'model' => $model,
		));
	}

	public function actionCreate()
	{
		$model = new Book;

		if (isset($_POST['Book'])) {
			$model->attributes = $_POST['Book'];
			$model->cover_file = CUploadedFile::getInstance($model, 'cover_file');

			if ($model->cover_file) {
				$filename = uniqid('cover_') . '.' . $model->cover_file->extensionName;
				$model->cover_image = $filename;
			}

			if ($model->save()) {
				if ($model->cover_file) {
					$model->cover_file->saveAs($model->getUploadPath() . $model->cover_image);
				}

				$this->saveAuthors($model);

				$model = Book::model()->with('authors')->findByPk($model->id);
				SmsPilotService::notifySubscribers($model);

				Yii::app()->user->setFlash('success', 'Книга успешно создана.');
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array(
			'model' => $model,
			'selectedAuthors' => array(),
		));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		$selectedAuthors = CHtml::listData($model->authors, 'id', 'id');

		if (isset($_POST['Book'])) {
			$oldCover = $model->cover_image;
			$model->attributes = $_POST['Book'];
			$model->cover_file = CUploadedFile::getInstance($model, 'cover_file');

			if ($model->cover_file) {
				$filename = uniqid('cover_') . '.' . $model->cover_file->extensionName;
				$model->cover_image = $filename;
			} else {
				$model->cover_image = $oldCover;
			}

			if ($model->save()) {
				if ($model->cover_file) {
					if ($oldCover) {
						$oldPath = $model->getUploadPath() . $oldCover;
						if (file_exists($oldPath)) {
							@unlink($oldPath);
						}
					}
					$model->cover_file->saveAs($model->getUploadPath() . $model->cover_image);
				}

				$this->saveAuthors($model);

				Yii::app()->user->setFlash('success', 'Книга успешно обновлена.');
				$this->redirect(array('view', 'id' => $model->id));
			}

			$selectedAuthors = isset($_POST['author_ids']) ? $_POST['author_ids'] : array();
		}

		$this->render('update', array(
			'model' => $model,
			'selectedAuthors' => array_values($selectedAuthors),
		));
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			Yii::app()->user->setFlash('success', 'Книга удалена.');
			$this->redirect(array('index'));
		} else {
			throw new CHttpException(400, 'Неверный запрос.');
		}
	}

	private function saveAuthors(Book $model)
	{
		BookAuthor::model()->deleteAllByAttributes(array('book_id' => $model->id));

		$authorIds = isset($_POST['author_ids']) ? $_POST['author_ids'] : array();
		foreach ($authorIds as $authorId) {
			$ba = new BookAuthor;
			$ba->book_id = $model->id;
			$ba->author_id = (int) $authorId;
			$ba->save();
		}
	}

	private function loadModel($id)
	{
		$model = Book::model()->with('authors')->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'Книга не найдена.');
		}
		return $model;
	}
}
