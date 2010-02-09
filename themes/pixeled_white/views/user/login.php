<!-- single big form for user login -->
<h2><?php echo Yii::t('lan','Login'); ?></h2>

<?php echo CHtml::form(); ?>

	<div class="row">
		<?php echo CHtml::activeLabel($model,'username'); ?>
		<?php echo CHtml::activeTextField($model,'username') ?>	<?php echo CHtml::error($model,'username'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($model,'password'); ?>
		<?php echo CHtml::activePasswordField($model,'password') ?><?php echo CHtml::error($model,'password'); ?>
	</div>
	<div class="row">
		<?php echo CHtml::activeCheckBox($model,'rememberMe'); ?><?php echo CHtml::activeLabel($model,'rememberMe'); ?>
	</div>
	<div class="row">
		<span class="submit">
			<?php /*echo CHtml::submitButton('Login',array('class'=>'loginbutton') ); */?>
			<?php echo CHtml::submitButton(Yii::t('lan','Login'),array('name'=>'loginWidget')); ?>
		</span>
	</div>
</form>
<?php echo CHtml::link(Yii::t('lan','Registration'), array('user/registration')); ?><br />
<?php echo CHtml::link(Yii::t('lan','Lost password ?'), array('user/lostpass')); ?>
