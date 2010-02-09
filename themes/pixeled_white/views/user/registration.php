<h2><?php echo Yii::t('lan','Registration'); ?></h2>


<div class='registrationform'>
	<?php if(Yii::app()->user->hasFlash('message')): ?>
		<div class="message">
		<?php echo Yii::app()->user->getFlash('message'); ?>
		</div>
	<?php else: ?>

		<?php echo CHtml::beginForm(''); ?>

			<?php echo CHtml::errorSummary($model); ?>

			<div class='row'>
				<?php echo CHtml::activeLabel($model,'username'); ?>
				<?php echo CHtml::activeTextField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'password'); ?>
				<?php echo CHtml::activePasswordField($model,'password',array('size'=>32,'maxlength'=>32)); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'password_repeat'); ?>
				<?php echo CHtml::activePasswordField($model,'password_repeat',array('size'=>32,'maxlength'=>32)); ?>
			</div>

			<div class='row'>
				<?php echo CHtml::activeLabel($model,'email'); ?>
				<?php echo CHtml::activeTextField($model,'email',array('size'=>50,'maxlength'=>64)); ?>
			</div>

			<?php if(extension_loaded('gd')): ?>
			<div class="row">
				<?php echo CHtml::activeLabel($model,'verifyCode'); ?>
				<div>
				<?php $this->widget('CCaptcha'); ?>
				<?php echo CHtml::activeTextField($model,'verifyCode'); ?>
				</div>
			</div>
			<?php endif; ?>

			<div class='action'>
				<?php echo CHtml::submitButton(Yii::t('lan','Registration')); ?>
			</div>

		<?php echo CHtml::endForm(); ?>
	<?php endif; ?>
</div>

