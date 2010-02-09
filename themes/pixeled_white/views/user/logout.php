<!-- single big form for user login -->
<h2><?php echo Yii::t('lan','Logout'); ?></h2>

<?php echo CHtml::form(); ?>

	<div class="row">
		<span class="submit">
			<?php /*echo CHtml::submitButton('Login',array('class'=>'loginbutton') ); */?>
			<?php echo CHtml::submitButton(Yii::t('lan','Logout') , array(
				'class'=>'logoutbutton',
				'submit'=>'',
				'params'=>array('command'=>'logout'),));?>
		</span>
	</div>
</form>

