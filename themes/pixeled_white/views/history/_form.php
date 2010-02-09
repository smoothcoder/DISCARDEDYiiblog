<div class="yiiForm">

<p>
Fields with <span class="required">*</span> are required.
</p>

<?php echo CHtml::beginForm(); ?>

<?php echo CHtml::errorSummary($model); ?>

<div class="simple">
<?php echo CHtml::activeLabelEx($model,'created'); ?>
<?php echo CHtml::activeTextField($model,'created'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'username'); ?>
<?php echo CHtml::activeTextField($model,'username',array('size'=>60,'maxlength'=>64)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'IP'); ?>
<?php echo CHtml::activeTextField($model,'IP',array('size'=>60,'maxlength'=>64)); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'category'); ?>
<?php echo CHtml::activeTextField($model,'category'); ?>
</div>
<div class="simple">
<?php echo CHtml::activeLabelEx($model,'file'); ?>
<?php echo CHtml::activeTextField($model,'file',array('size'=>60,'maxlength'=>64)); ?>
</div>

<div class="action">
<?php echo CHtml::submitButton($update ? 'Save' : 'Create'); ?>
</div>

<?php echo CHtml::endForm(); ?>

</div><!-- yiiForm -->