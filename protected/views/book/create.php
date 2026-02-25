<?php
/* @var $this BookController */
/* @var $model Book */

$this->pageTitle = Yii::app()->name . ' - Новая книга';
$this->breadcrumbs = array(
	'Книги' => array('index'),
	'Новая книга',
);
?>

<h1>Новая книга</h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'selectedAuthors' => $selectedAuthors,
)); ?>
