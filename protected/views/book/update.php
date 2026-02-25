<?php
/* @var $this BookController */
/* @var $model Book */

$this->pageTitle = Yii::app()->name . ' - Редактирование: ' . $model->title;
$this->breadcrumbs = array(
	'Книги' => array('index'),
	$model->title => array('view', 'id' => $model->id),
	'Редактирование',
);
?>

<h1>Редактирование: <?php echo CHtml::encode($model->title); ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'selectedAuthors' => $selectedAuthors,
)); ?>
