<h2>Config List</h2>

<div class="actionBar">
[<?php echo CHtml::link('New Config',array('create')); ?>]
[<?php echo CHtml::link('Manage Config',array('admin')); ?>]
</div>

<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>

<?php foreach($models as $n=>$model): ?>
<div class="item">
<?php echo CHtml::encode($model->getAttributeLabel('key')); ?>:
<?php echo CHtml::link($model->key,array('show','id'=>$model->key)); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('value')); ?>:
<?php echo CHtml::encode($model->value); ?>
<br/>
<?php echo CHtml::encode($model->getAttributeLabel('comment')); ?>:
<?php echo CHtml::encode($model->comment); ?>
<br/>

</div>
<?php endforeach; ?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>