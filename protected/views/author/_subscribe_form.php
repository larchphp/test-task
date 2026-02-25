<?php
/* @var $model SubscribeForm */
/* @var $author Author */
?>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'subscribe-form',
	'action' => array('author/subscribe', 'id' => $author->id),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('placeholder' => '79001234567')); ?>
		<?php echo $form->error($model, 'phone'); ?>
		<p class="hint">Формат: 7XXXXXXXXXX (11 цифр)</p>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Подписаться'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
