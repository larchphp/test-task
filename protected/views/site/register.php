<?php
/* @var $this SiteController */
/* @var $model RegisterForm */

$this->pageTitle = Yii::app()->name . ' - Регистрация';
$this->breadcrumbs = array('Регистрация');
?>

<h1>Регистрация</h1>

<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'register-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'username'); ?>
		<?php echo $form->textField($model, 'username'); ?>
		<?php echo $form->error($model, 'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'email'); ?>
		<?php echo $form->textField($model, 'email'); ?>
		<?php echo $form->error($model, 'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password'); ?>
		<?php echo $form->passwordField($model, 'password'); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password_confirm'); ?>
		<?php echo $form->passwordField($model, 'password_confirm'); ?>
		<?php echo $form->error($model, 'password_confirm'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Зарегистрироваться'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>

<p>Уже есть аккаунт? <?php echo CHtml::link('Войти', array('/site/login')); ?></p>
