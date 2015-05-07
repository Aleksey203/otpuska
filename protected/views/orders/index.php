<?php
/* @var $this OrdersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Заявки на отпуск',
);

$this->menu=array(
	array('label'=>'Подать заявку', 'url'=>array('create')),
    //array('label'=>'Список заявок', 'url'=>array('index')),
	//array('label'=>'Управление заявками', 'url'=>array('admin')),
);
?>

<h1>Заявки на отпуск</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
