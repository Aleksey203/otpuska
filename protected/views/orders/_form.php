<?php
/* @var $this OrdersController */
/* @var $model Orders */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'start'); ?>
		<?php //echo $form->textField($model,'start'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'start',
            'model' => $model,
            'attribute' => 'start',
            'language' => 'ru',
            'options' => array(
                'showAnim' => 'fold',
                'minDate' => '1',
                'numberOfMonths' => array(2,3),
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));?>
		<?php echo $form->error($model,'start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end'); ?>
		<?php //echo $form->textField($model,'end'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'name' => 'end',
            'model' => $model,
            'attribute' => 'end',
            'language' => 'ru',
            'options' => array(
                'showAnim' => 'fold',
                'minDate' => '2',
                'numberOfMonths' => array(2,3),
            ),
            'htmlOptions' => array(
                'style' => 'height:20px;'
            ),
        ));?>
		<?php echo $form->error($model,'end'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Подать заявку' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->