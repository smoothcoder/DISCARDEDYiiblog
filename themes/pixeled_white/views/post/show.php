<?php $this->renderPartial('_post',array(
	'post'=>$post,
)); ?>



<div id="comments_wrapper">
	<?php if($post->commentCount>=1): ?>
	<h3>
		<?php echo $post->commentCount>1 ? $post->commentCount . ' comments' : 'One comment'; ?>
		to "<?php echo CHtml::encode($post->title); ?>"
	</h3>
	<?php endif; ?>

	<?php $this->renderPartial('/comment/_list',array(
		'comments'=>$comments,
		'post'=>$post,
	)); ?>

	<?php  $this->widget('application.components.sociable.sociable',
			array(
				'post'=>$post,
				'active_sites'=>array(
				'Print',
				'Digg',
				'豆瓣',
				'del.icio.us',
				'Facebook',
				'Mixx',
				'Google',
				'Twitter',
				'Scoopeo',
				'MySpace',
				'Posterous',
				'Technorati',
				'StumbleUpon',
				'Yahoo! Bookmarks',
				'QQ书签'
					),
				)
			);
	?>
	<?php if( !Yii::app()->user->hasFlash('commentSubmittedMessage' )): ?>
		<h3>Leave a Comment</h3>
	<?php endif; ?>

	<?php $this->renderPartial('/comment/_form',array(
		'comment'=>$newComment,
		'update'=>false,
	)); ?>

</div><!-- comments -->
