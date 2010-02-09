<h2>New Config</h2>

<div class="actionBar">
[<?php echo CHtml::link('Config List',array('list')); ?>]
[<?php echo CHtml::link('Manage Config',array('admin')); ?>]
</div>

<?php echo $this->renderPartial('_form', array(
	'model'=>$model,
	'update'=>false,
)); ?>