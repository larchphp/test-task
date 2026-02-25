<?php
/* @var $data Author */
?>
<div class="view">
	<h3><?php echo CHtml::link(CHtml::encode($data->full_name), array('author/view', 'id' => $data->id)); ?></h3>
	<p>Книг: <?php echo $data->bookCount; ?></p>
</div>
