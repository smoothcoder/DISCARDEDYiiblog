<h2>View Config <?php echo $model->key; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('Config List',array('list')); ?>]
[<?php echo CHtml::link('New Config',array('create')); ?>]
[<?php echo CHtml::link('Update Config',array('update','id'=>$model->key)); ?>]
[<?php echo CHtml::linkButton('Delete Config',array('submit'=>array('delete','id'=>$model->key),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage Config',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('value')); ?>
</th>
    <td><?php echo CHtml::encode($model->value); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('comment')); ?>
</th>
    <td><?php echo CHtml::encode($model->comment); ?>
</td>
</tr>
</table>
