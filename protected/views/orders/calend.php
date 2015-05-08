<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	'Календарь',
);
?>
<div class="help">
    <div class="blue">на рассмотрении</div>
    <div class="green">одобрена</div>
    <div class="orangered">отклонена</div>
</div>
<h1>Календарь заявок</h1>
<div id="calend">
<?php $this->renderPartial('_month', array(
    'model'=>$model)); ?>
</div>