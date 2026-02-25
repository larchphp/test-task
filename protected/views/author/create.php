<?php
/* @var $this AuthorController */
/* @var $model Author */

$this->pageTitle = Yii::app()->name . ' - Новый автор';
$this->breadcrumbs = array(
	'Авторы' => array('index'),
	'Новый автор',
);
?>

<h1>Новый автор</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
