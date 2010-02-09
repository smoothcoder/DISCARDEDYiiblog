<h2>History List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New History',array('create')); ?>]
[<?php echo CHtml::link('Manage History',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:
<?php echo CHtml::link($model->id,array('show','id'=>$model->id)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('created')); ?>:
<?php echo CHtml::encode($model->created); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('username')); ?>:
<?php echo CHtml::encode($model->username); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('IP')); ?>:
<?php echo CHtml::encode($model->IP); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('category')); ?>:
<?php echo CHtml::encode($model->category); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('file')); ?>:
<?php echo CHtml::encode($model->file); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>