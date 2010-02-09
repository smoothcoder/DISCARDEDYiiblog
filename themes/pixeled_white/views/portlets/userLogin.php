<!--portlet component -->
<?php echo CHtml::form(); ?>

		<?php echo CHtml::activeLabel($form,'username'); ?>
		<?php echo CHtml::activeTextField($form,'username') ?>	<?php echo CHtml::error($form,'username'); ?>
		<?php echo CHtml::activeLabel($form,'password'); ?>
		<?php echo CHtml::activePasswordField($form,'password') ?><?php echo CHtml::error($form,'password'); ?>

		<?php /*echo CHtml::activeCheckBox($form,'rememberMe');*/ ?><?php /*echo CHtml::activeLabel($form,'rememberMe');*/ ?>

		<span class="submit">
			<?php /*echo CHtml::submitButton('Login',array('class'=>'loginbutton') ); */?>
			<?php echo CHtml::submitButton(Yii::t('lan','Login'),array('name'=>'loginWidget')); ?>
		</span>
		<a id="signup" href="<?php echo Yii::app()->request->baseUrl; ?>/user/registration" title="<?php echo Yii::t('lan',  'Register on DiscardedTeenz' ); ?>">
					<?php echo CHtml::image(
							Yii::app()->theme->baseUrl."/images/signupx17.png" ,
							Yii::t('lan',  'SignUp' )
					); ?>
		</a>
</form>
<?php /*echo CHtml::link(Yii::t('lan','Registration'), array('user/registration')); */?>
<?php /*echo CHtml::link(Yii::t('lan','Lost password ?'), array('user/lostpass'));*/ ?>