<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Заявки'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Редактировать',
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index')),
	array('label'=>'Подать заявку', 'url'=>array('create')),
	//array('label'=>'View Orders', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Orders', 'url'=>array('admin')),
);
?>

<h1>Update Orders <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>