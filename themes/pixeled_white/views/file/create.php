<h2><?php echo Yii::t('lan','New File'); ?> <?php echo CHtml::link(Yii::t('lan','Manage Files'), array('admin')); ?></h2>

</script>
<div class="fileform">
	<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'name'); ?>
				<?php echo CHtml::activeFileField($model,'name'); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'alt'); ?>
				<?php echo CHtml::activeTextField($model,'alt',array('size'=>32,'maxlength'=>32)); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'download'); ?>
				<?php echo CHtml::activeCheckBox($model,'download').Yii::t('lan','Check for downloadable file') ; ?>
			</div>
			<div class='action'>
				<?php echo CHtml::submitButton($update ? Yii::t('lan','Save') : Yii::t('lan','Create')); ?>
			</div>
	<?php echo CHtml::endForm(); ?>
</div>
<br />
<table class="dataGrid" style="display:none;">
    <tr>
        <th><?php echo Yii::t('lan','File'); ?></th>
        <th><?php echo Yii::t('lan','Name'); ?></th>
        <th><?php echo Yii::t('lan','Type'); ?></th>
        <th><?php echo Yii::t('lan','Actions'); ?></th>
    </tr>
</table>

