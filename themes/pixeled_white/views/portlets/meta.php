<ul>
<?php if(!Yii::app()->user->isGuest): ?>
	<li><?php echo CHtml::link(Yii::t('lan',  'Logout' ) , array('user/logout'), array("title"=>Yii::t("lan",  "Logout" )  )  ); ?></li>
<?php else: ?>
	<li><?php echo CHtml::link(Yii::t('lan',  'Login' ) , array('user/login'), array("title"=>Yii::t("lan",  "Login" )  )  ); ?></li>
<?php endif; ?>
<li><?php echo CHtml::link(Yii::t('lan',  'Lost Password' ) , array('user/lostpass'), array("title"=>Yii::t("lan",  "Lost Password" )  )  ); ?></li>
<li><?php echo CHtml::link(Yii::t('lan',  'Registration' ) , array('user/registration'), array("title"=>Yii::t("lan",  "Register the website" )  )); ?></li>
<li><?php echo CHtml::link(Yii::t('lan',  'Entries RSS' ) , array('/site/postFeed'), array("title"=>Yii::t("lan",  "Subscribe RSS" )  )); ?></li>
<li><?php echo CHtml::link(Yii::t('lan',  'Comments RSS' ) , array('/site/commentFeed'), array("title"=>Yii::t("lan",  "Subscribe RSS" )  )); ?></li>
</ul>
