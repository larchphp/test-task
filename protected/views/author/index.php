<?php
/* @var $this AuthorController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = Yii::app()->name . ' - Авторы';
$this->breadcrumbs = array('Авторы');
?>

<h1>Авторы</h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p><?php echo CHtml::link('Добавить автора', array('create'), array('class' => 'btn')); ?></p>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_item',
	'emptyText' => 'Авторов пока нет.',
)); ?>
