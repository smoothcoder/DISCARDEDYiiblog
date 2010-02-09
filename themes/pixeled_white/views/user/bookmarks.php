<?php $nBookmarks=0; foreach($models as $model): ?>
	<?php
		if($model->post)
		{	$nBookmarks++;
			$model->post->contentshort=
							Post::model()->sc_getexcerpt(
								$model->post->contentshort,
								CHtml::link('( '.Yii::t('lan','Continue reading').' ... )',array('post/show','slug'=>$model->post->slug)),
								20
							);
			$this->renderPartial('../post/_post',array(
			'post'=>$model->post,
			));
		}
	?>
<?php endforeach;?>
<?php if($nBookmarks==0)
	echo Yii::t('lan','You don \'t have any bookmarks');
?>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
