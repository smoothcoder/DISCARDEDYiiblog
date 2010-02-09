<ul>
<?php foreach($this->getRecentComments() as $comment): ?>

	<div class="recentauthor"><?php echo $comment->getAuthorUrl();  ?>&nbsp;on&nbsp;
		<?php echo CHtml::link(CHtml::encode($comment->post->title),array('post/show','slug'=>$comment->post->slug)); ?>
	</div>
	<div class="recentcomment">
		<?php echo yii::app()->lib_tools->shorten_string(htmlspecialchars_decode( $comment->contentDisplay),10);  ?>

	</div>
<?php endforeach; ?>
</ul>