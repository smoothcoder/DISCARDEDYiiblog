<?php if(!Yii::app()->user->isGuest): ?>
	<?php echo CHtml::link(Yii::t('lan','My account'),array('user/update','id'=>Yii::app()->user->id)); ?>
<?php endif; ?>
<?php echo CHtml::submitButton(Yii::t('lan','Logout') , array(
	'class'=>'loginbutton',
	'submit'=>'',
	'params'=>array('command'=>'logout'),));?>
