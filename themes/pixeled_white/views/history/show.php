<h2>View History <?php echo $model->id; ?></h2>

<div class="actionBar">
[<?php echo CHtml::link('History List',array('list')); ?>]
[<?php echo CHtml::link('New History',array('create')); ?>]
[<?php echo CHtml::link('Update History',array('update','id'=>$model->id)); ?>]
[<?php echo CHtml::linkButton('Delete History',array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure?')); ?>
]
[<?php echo CHtml::link('Manage History',array('admin')); ?>]
</div>

<table class="dataGrid">
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('created')); ?>
</th>
    <td><?php echo CHtml::encode($model->created); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('username')); ?>
</th>
    <td><?php echo CHtml::encode($model->username); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('IP')); ?>
</th>
    <td><?php echo CHtml::encode($model->IP); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('category')); ?>
</th>
    <td><?php echo CHtml::encode($model->category); ?>
</td>
</tr>
<tr>
	<th class="label"><?php echo CHtml::encode($model->getAttributeLabel('file')); ?>
</th>
    <td><?php echo CHtml::encode($model->file); ?>
</td>
</tr>
</table>
