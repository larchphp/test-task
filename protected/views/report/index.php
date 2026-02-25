<?php
/* @var $this ReportController */
/* @var $year int */
/* @var $authors array */

$this->pageTitle = Yii::app()->name . ' - Отчёт';
$this->breadcrumbs = array('Отчёт');
?>

<h1>ТОП-10 авторов по количеству книг</h1>

<div class="form">
	<form method="get" action="<?php echo $this->createUrl('report/index'); ?>">
		<div class="row">
			<label for="year">Год выпуска:</label>
			<input type="number" name="year" id="year" value="<?php echo CHtml::encode($year); ?>" min="1900" max="2100" style="width: 100px;">
			<?php echo CHtml::submitButton('Показать'); ?>
		</div>
	</form>
</div>

<?php if (!empty($authors)): ?>
	<h2>Результаты за <?php echo CHtml::encode($year); ?> год</h2>
	<table class="detail-view" style="width: 100%;">
		<thead>
			<tr>
				<th style="width: 50px;">#</th>
				<th>Автор</th>
				<th style="width: 150px;">Количество книг</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($authors as $i => $author): ?>
			<tr>
				<td><?php echo $i + 1; ?></td>
				<td><?php echo CHtml::link(CHtml::encode($author['full_name']), array('author/view', 'id' => $author['id'])); ?></td>
				<td><?php echo CHtml::encode($author['book_count']); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php elseif ($year > 0): ?>
	<p>Нет данных за <?php echo CHtml::encode($year); ?> год.</p>
<?php endif; ?>
