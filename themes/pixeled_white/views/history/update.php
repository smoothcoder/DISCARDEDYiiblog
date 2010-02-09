<h2>Update History <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('History List',array('list')); ?>]
[<?php echo CHtml::link('New History',array('create')); ?>]
[<?php echo CHtml::link('Manage History',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>