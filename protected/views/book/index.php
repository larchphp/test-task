<?php
/* @var $this BookController */
/* @var $dataProvider CActiveDataProvider */

$this->pageTitle = Yii::app()->name . ' - Книги';
$this->breadcrumbs = array('Книги');
?>

<h1>Книги</h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p><?php echo CHtml::link('Добавить книгу', array('create'), array('class' => 'btn')); ?></p>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_item',
	'emptyText' => 'Книг пока нет.',
)); ?>
