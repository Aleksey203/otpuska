<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	$model->id,
);

$this->menu=array(
    array('label'=>'Список заявок', 'url'=>array('index')),
    array('label'=>'Подать заявку', 'url'=>array('create')),
	//array('label'=>'Update Orders', 'url'=>array('update', 'id'=>$model->id)),
	//array('label'=>'Delete Orders', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	//array('label'=>'Manage Orders', 'url'=>array('admin')),
);
?>

<h1>Заявка №<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		//'user_id',
		'date',
		'start',
		'end',
		'duration',
		'confirmed',
	),
)); ?>
