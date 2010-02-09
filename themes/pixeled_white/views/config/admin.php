<h2>Managing Config</h2>

<div class="actionBar">
[<?php echo CHtml::link('Config List',array('list')); ?>]
[<?php echo CHtml::link('New Config',array('create')); ?>]
</div>

<table class="dataGrid">
  <thead>
  <tr>
    <th><?php echo $sort->link('key'); ?></th>
    <th><?php echo $sort->link('comment'); ?></th>
	<th>Actions</th>
  </tr>
  </thead>
  <tbody>
<?php foreach($models as $n=>$model): ?>
  <tr class="<?php echo $n%2?'even':'odd';?>">
    <td><?php echo CHtml::link($model->key,array('show','id'=>$model->key)); ?></td>
    <td><?php echo CHtml::encode($model->comment); ?></td>
    <td>
      <?php echo CHtml::link('Update',array('update','id'=>$model->key)); ?>
      <?php echo CHtml::linkButton('Delete',array(
      	  'submit'=>'',
      	  'params'=>array('command'=>'delete','id'=>$model->key),
      	  'confirm'=>"Are you sure to delete #{$model->key}?")); ?>
	</td>
  </tr>
<?php endforeach; ?>
  </tbody>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>