<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div>

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu', array(
			'items' => array(
				array('label' => 'Книги', 'url' => array('/book/index')),
				array('label' => 'Авторы', 'url' => array('/author/index')),
				array('label' => 'Отчёт', 'url' => array('/report/index')),
				array('label' => 'Вход', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
				array('label' => 'Регистрация', 'url' => array('/site/register'), 'visible' => Yii::app()->user->isGuest),
				array('label' => 'Выход (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
			),
		)); ?>
	</div>

	<?php if (isset($this->breadcrumbs)): ?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links' => $this->breadcrumbs,
		)); ?>
	<?php endif ?>

	<?php
	foreach (Yii::app()->user->getFlashes() as $key => $message) {
		echo '<div class="flash-' . $key . '">' . CHtml::encode($message) . '</div>';
	}
	?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<?php echo Yii::powered(); ?>
	</div>

</div>

</body>
</html>
