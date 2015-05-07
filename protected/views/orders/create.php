<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index')),
	//array('label'=>'Manage Orders', 'url'=>array('admin')),
);
?>

<h1>Новая заявка</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>