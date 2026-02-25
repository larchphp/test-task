<?php
/* @var $this AuthorController */
/* @var $model Author */
/* @var $subscribeForm SubscribeForm */

$this->pageTitle = Yii::app()->name . ' - ' . $model->full_name;
$this->breadcrumbs = array(
	'Авторы' => array('index'),
	$model->full_name,
);
?>

<h1><?php echo CHtml::encode($model->full_name); ?></h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p>
		<?php echo CHtml::link('Редактировать', array('update', 'id' => $model->id)); ?> |
		<?php echo CHtml::link('Удалить', '#', array(
			'submit' => array('delete', 'id' => $model->id),
			'confirm' => 'Вы уверены, что хотите удалить этого автора?',
			'csrf' => true,
		)); ?>
	</p>
<?php endif; ?>

<h2>Книги автора</h2>

<?php if (!empty($model->books)): ?>
	<ul>
	<?php foreach ($model->books as $book): ?>
		<li>
			<?php echo CHtml::link(CHtml::encode($book->title), array('book/view', 'id' => $book->id)); ?>
			(<?php echo CHtml::encode($book->year); ?>)
		</li>
	<?php endforeach; ?>
	</ul>
<?php else: ?>
	<p>У автора пока нет книг.</p>
<?php endif; ?>

<hr>

<h2>Подписка на новые книги</h2>
<p>Введите номер телефона, чтобы получать SMS-уведомления о новых книгах этого автора.</p>

<?php $this->renderPartial('_subscribe_form', array(
	'model' => $subscribeForm,
	'author' => $model,
)); ?>
