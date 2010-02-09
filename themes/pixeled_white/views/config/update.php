<h2>Update Config <?php echo $model->key; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Config List',array('list')); ?>]
[<?php echo CHtml::link('New Config',array('create')); ?>]
[<?php echo CHtml::link('Manage Config',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>true,
)); ?>