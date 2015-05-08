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

<b>Для редактирования заявки - нажмите на цветную полосу заявки.</b>
<div id="one-click" style="display: none;">
    <div class="box">
        <span class="arrow"></span>
        <a class="button approve" href="#">Одобрить</a>
        <a class="button decline" href="#">Отклонить</a>
        <div class="text"></div>
    </div>

</div>