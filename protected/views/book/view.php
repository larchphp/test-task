<?php
/* @var $this BookController */
/* @var $model Book */

$this->pageTitle = Yii::app()->name . ' - ' . $model->title;
$this->breadcrumbs = array(
	'Книги' => array('index'),
	$model->title,
);
?>

<h1><?php echo CHtml::encode($model->title); ?></h1>

<?php if (!Yii::app()->user->isGuest): ?>
	<p>
		<?php echo CHtml::link('Редактировать', array('update', 'id' => $model->id)); ?> |
		<?php echo CHtml::link('Удалить', '#', array(
			'submit' => array('delete', 'id' => $model->id),
			'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
			'csrf' => true,
		)); ?>
	</p>
<?php endif; ?>

<?php if ($model->getCoverUrl()): ?>
	<div style="margin-bottom: 15px;">
		<img src="<?php echo $model->getCoverUrl(); ?>" alt="Обложка" style="max-width: 300px; max-height: 400px;">
	</div>
<?php endif; ?>

<table class="detail-view">
	<tr>
		<th>Название</th>
		<td><?php echo CHtml::encode($model->title); ?></td>
	</tr>
	<tr>
		<th>Год выпуска</th>
		<td><?php echo CHtml::encode($model->year); ?></td>
	</tr>
	<tr>
		<th>ISBN</th>
		<td><?php echo CHtml::encode($model->isbn); ?></td>
	</tr>
	<tr>
		<th>Описание</th>
		<td><?php echo nl2br(CHtml::encode($model->description)); ?></td>
	</tr>
	<tr>
		<th>Авторы</th>
		<td>
			<?php
			$names = array();
			foreach ($model->authors as $author) {
				$names[] = CHtml::link(CHtml::encode($author->full_name), array('author/view', 'id' => $author->id));
			}
			echo $names ? implode(', ', $names) : 'не указаны';
			?>
		</td>
	</tr>
	<tr>
		<th>Дата добавления</th>
		<td><?php echo CHtml::encode($model->created_at); ?></td>
	</tr>
</table>
