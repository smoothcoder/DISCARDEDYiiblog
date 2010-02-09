<div id="navright">
	<?php if(Yii::app()->user->isGuest): ?>
		<div id="adsense_navright960x15left">
			<?php echo Yii::app()->params['adsense_navright960x15left']; ?>
		</div><!-- adsense-->
	<?php endif; ?>
	<ul class="">
		<?php if(!Yii::app()->user->isGuest): ?>
			<?php if(Yii::app()->user->status==User::STATUS_ADMIN || Yii::app()->user->status==User::STATUS_WRITER): ?>
				<li><?php echo CHtml::link(Yii::t('lan', 'Manage Posts' ) , array('post/admin')); echo CHtml::link(Yii::t('lan',  'Create New Post' ) , array('post/create'));?></li>
			<?php endif; ?>
			<?php if(Yii::app()->user->status==User::STATUS_ADMIN): ?>
				<li><?php echo CHtml::link(Yii::t('lan', 'History'  ) , array('history/admin')); ?></li>
				<li><?php echo CHtml::link(Yii::t('lan', 'Manage Pages' ) , array('pages/admin')); ?></li>

				<li><?php echo CHtml::link(Yii::t('lan', 'Manage Categories'  ) , array('cats/admin')); ?></li>
				<li><?php echo CHtml::link(Yii::t('lan', 'Manage Files' ) , array('files/admin')); ?></li>
				<li><?php echo CHtml::link(Yii::t('lan', 'Users list' ) , array('user/list')); ?></li>
				<li><?php echo CHtml::link(Yii::t('lan', 'Approve Comments' ) ,array('comment/list')) . ' (' . Comment::model()->pendingCommentCount . ')'; ?></li>
			<?php endif; ?>
		<?php endif; ?>
	</ul>


</div><!-- Closes navright -->