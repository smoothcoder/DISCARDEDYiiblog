
<h2>
	<?php if ($model->id==Yii::app()->user->id)
				echo Yii::t('lan','My account');
			else echo Yii::t('lan','Update User')." ";
			if( Yii::app()->user->status==User::STATUS_ADMIN)
			{
				echo CHtml::link('#'.$model->id, array('user/show','id'=>$model->id)).' ' ;
				echo CHtml::link(Yii::t('lan','Users List'),array('list'));
			}
	?>
</h2>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
    'update'=>true,
)); ?>
