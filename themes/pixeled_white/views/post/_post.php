<div class="post">
	<div class="title">
		<div id="postpres">
			<div class="ppres_datebox">
				<div class="ppres_date2">
					<?php $this->widget('PostDate', array('ct'=>date($p.'M'.$p.'<\b\r>j', $post->createTime))); ?>
				</div>
				<div class="ppres_comment">
					<?php echo CHtml::link($post->commentCount,array('post/show','slug'=>$post->slug,'#'=>'comments')); ?>
				</div>
			</div>
			<?php if(!$post->titleLink): ?>
				<h1><?php echo CHtml::link(CHtml::encode($post->title),array('post/show','slug'=>$post->slug)); ?></h1>
			<?php else: ?>
					<h1><?php echo CHtml::link(CHtml::encode($post->title),array('post/show','id'=>$post->id)); ?></h1>
			<?php endif; ?>
		</div><!-- end postpres -->


	</div>
	<div class="author">
		<?php if(!Yii::app()->user->isGuest): ?>
		[<?php echo '<span class="'.strtolower($post->statusText).'">'.$post->statusText.'</span>'; ?>]
		<?php endif; ?>
		posted by <?php echo $post->author->username . ' on ' . date('F j, Y',$post->createTime); ?>
	</div>
	<!--<div class="cleared"></div>-->
	<div class="content">
		<?php echo $post->contentshort; ?>
	</div><!--content -->

	<div class="nav">
		<?php if($post->category): ?>
			<div class="topTag"><span class="tag-link">
				<?php echo CHtml::link(CHtml::encode($post->category->name),array('category/show','slug'=>$post->category->slug)); ?>
			</span></div>
		<?php endif; ?>
		<?php if( strlen(Post::getTagLinks($post))>0): ?>
			<div class="topTag"><span class="tag-link">
				<?php echo Post::getTagLinks($post); ?>
			</span></div>
		<?php endif; ?>
		<?php if (strcmp(( $this->getAction()->getId()),'list')==0): ?>
				<?php if($post->contentbig):
				// shows 'Read more' only if in post/list ?>
					<div class="topMore"><span class="more-link">
						<?php echo CHtml::link(Yii::t('lan','Read more'),array('post/show','slug'=>$post->slug,'#'=>'post-more')); ?>
					</span></div>
				<?php endif; ?>
		<?php endif; ?>
		<div class="topComments"><span class="comment-link">
			<?php echo CHtml::link(Yii::t('lan','Comments')." ({$post->commentCount})",array('post/show','slug'=>$post->slug,'#'=>'comments')); ?>
		</span></div>
		<?php if(!Yii::app()->user->isGuest): ?>

			<!--Add Bookmark-->
			<div class="topCrud"><span class="crud-link">
				<?php echo CHtml::ajaxLink((($post->bookmarks)?Yii::t('lan','Delete'):Yii::t('lan','Add')).' '.Yii::t('lan','Bookmark'),
					$this->createUrl('post/ajaxBookmark',array('id'=>$post->id)),
					array('success'=>'function(msg){ pThis.html(msg+" '.Yii::t('lan','Bookmark').'") }'),
					array('onclick'=>'var pThis=$(this);'));

?>

			</span></div>

			<!--Add Update  Post link-->
			<?php if(Yii::app()->user->status==User::STATUS_ADMIN || Yii::app()->user->status==User::STATUS_WRITER): ?>
				<div class="topCrud"><span class="crud-link">
					<?php /*echo CHtml::link('Update',array('post/update','id'=>$post->id));*/ ?>

						<?php echo CHtml::link(Yii::t('lan','Update'),array('post/update','id'=>$post->id)); ?>

				</span></div>
			<?php endif; ?>

			<!--Add Delete Post -->
			<?php if(Yii::app()->user->status==User::STATUS_ADMIN || Yii::app()->user->status==User::STATUS_WRITER): ?>
				<div class="topCrud"><span class="crud-link">
						<?php echo CHtml::linkButton(Yii::t('lan','Delete'),array(
							'submit'=>array('post/delete','id'=>$post->id),
							'confirm'=>Yii::t('lan','Are you sure to delete this post ?'),
						)); ?>

				</span></div>
			<?php endif; ?>
		<?php endif; ?>
		<!--<span class="update-label">
			Last updated on <?php echo date('F j, Y',$post->updateTime); ?>
		</span>-->
	</div><!--nav -->
	<div class="cleared"></div>
</div><!-- post -->
