<?php

class ReportController extends Controller
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
			array('allow', 'actions' => array('index'), 'users' => array('*')),
			array('deny', 'users' => array('*')),
		);
	}

	public function actionIndex()
	{
		$year = Yii::app()->request->getQuery('year', date('Y'));
		$year = (int) $year;

		$authors = array();
		if ($year > 0) {
			$authors = Yii::app()->db->createCommand()
				->select('a.id, a.full_name, COUNT(ba.book_id) as book_count')
				->from('author a')
				->join('book_author ba', 'ba.author_id = a.id')
				->join('book b', 'b.id = ba.book_id')
				->where('b.year = :year', array(':year' => $year))
				->group('a.id, a.full_name')
				->order('book_count DESC')
				->limit(10)
				->queryAll();
		}

		$this->render('index', array(
			'year' => $year,
			'authors' => $authors,
		));
	}
}
