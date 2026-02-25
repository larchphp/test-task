<?php
/* @var $data Book */
?>
<div class="view">
	<h3><?php echo CHtml::link(CHtml::encode($data->title), array('book/view', 'id' => $data->id)); ?></h3>
	<p>
		<strong>Год:</strong> <?php echo CHtml::encode($data->year); ?> |
		<strong>ISBN:</strong> <?php echo CHtml::encode($data->isbn); ?>
	</p>
	<p>
		<strong>Авторы:</strong>
		<?php
		$names = array();
		foreach ($data->authors as $author) {
			$names[] = CHtml::link(CHtml::encode($author->full_name), array('author/view', 'id' => $author->id));
		}
		echo $names ? implode(', ', $names) : 'не указаны';
		?>
	</p>
</div>
