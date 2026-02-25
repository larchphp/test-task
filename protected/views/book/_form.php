<?php
/* @var $this BookController */
/* @var $model Book */
/* @var $selectedAuthors array */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'book-form',
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'year'); ?>
		<?php echo $form->textField($model, 'year', array('size' => 10)); ?>
		<?php echo $form->error($model, 'year'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'isbn'); ?>
		<?php echo $form->textField($model, 'isbn', array('size' => 20, 'maxlength' => 20)); ?>
		<?php echo $form->error($model, 'isbn'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'description'); ?>
		<?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
		<?php echo $form->error($model, 'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'cover_file'); ?>
		<?php echo $form->fileField($model, 'cover_file'); ?>
		<?php echo $form->error($model, 'cover_file'); ?>
		<?php if ($model->cover_image): ?>
			<p>Текущая обложка:<br>
				<img src="<?php echo $model->getCoverUrl(); ?>" alt="Обложка" style="max-width: 150px; max-height: 200px;">
			</p>
		<?php endif; ?>
	</div>

	<div class="row">
		<label>Авторы</label>
		<?php
		$authors = Author::model()->findAll(array('order' => 'full_name'));
		echo CHtml::listBox('author_ids', $selectedAuthors,
			CHtml::listData($authors, 'id', 'full_name'),
			array('multiple' => 'multiple', 'size' => 10)
		);
		?>
		<p class="hint">Удерживайте Ctrl (Cmd) для выбора нескольких авторов</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
