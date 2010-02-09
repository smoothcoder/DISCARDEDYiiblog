<?php if(Yii::app()->user->status==User::STATUS_ADMIN || Yii::app()->user->status==User::STATUS_WRITER): ?>
	<h2>Create New Post</h2>
<?php endif; ?>
<?php $this->renderPartial('_form', array(
	'post'=>$post,
	'update'=>false,
)); ?>
