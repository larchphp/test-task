<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->pageTitle = Yii::app()->name . ' - Редактирование: ' . $model->full_name;
$this->breadcrumbs = array(
	'Авторы' => array('index'),
	$model->full_name => array('view', 'id' => $model->id),
	'Редактирование',
);
?>

<h1>Редактирование: <?php echo CHtml::encode($model->full_name); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
