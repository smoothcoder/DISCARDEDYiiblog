<h2><?php echo Yii::t('lan','Lost password ?'); ?></h2>


<div class='lostform'>
	<?php if(Yii::app()->user->hasFlash('message')): ?>
		<div class="message">
			<?php echo Yii::app()->user->getFlash('message'); ?>
		</div>
	<?php else: ?>

		<?php echo yii::t('lan','If you have lost your password, please provide your email below, your password will be sent back.'); ?>
		<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>

			<?php echo CHtml::errorSummary($model); ?>

			<div class='row'>
				<?php echo CHtml::activeLabel($model,'usernameoremail'); ?>
				<?php echo CHtml::activeTextField($model,'usernameoremail',array('size'=>45,'maxlength'=>64)); ?>
			</div>
			<div class="clearfloat"></div>
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
				<?php echo CHtml::submitButton(Yii::t('lan','Lost password ?')); ?>
			</div>
		<?php echo CHtml::endForm(); ?>
	<?php endif; ?>


</div>
