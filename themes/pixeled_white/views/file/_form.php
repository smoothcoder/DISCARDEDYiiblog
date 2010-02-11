<div class="fileform">

<?php echo CHtml::beginForm(); ?>

	<?php
	$type=explode('/',$model->type);
	if($type[0]=='image')
	{
		$whtext=File::getHOW(Yii::app()->params['filePath'].$file);
		$url=Yii::app()->baseUrl.'/uploads/'.Yii::app()->params['sitefileName'].'/'.$file;
	}
	?>

	<?php echo CHtml::errorSummary($model); ?>

	<?php echo ($type[0]=='image') ? (($whtext)?CHtml::link(CHtml::image($url, $model->alt, array($whtext=>Yii::app()->params['imageThumbnailBoundingBox'])), $url, array('class'=>'highslide')):CHtml::image($url, $model->alt)) : CHtml::image(Yii::app()->baseUrl.'/images/file.png'); ?>
	<div class="row">
		<?php echo CHtml::activeLabel($model,'name'); ?>
		<?php echo CHtml::activeTextField($model,'name',array('size'=>45,'maxlength'=>64)); ?>
	</div>
	<div class='clearfloat' ></div>

	<div class='row'>
		<?php echo CHtml::activeLabel($model,'alt'); ?>
		<?php echo CHtml::activeTextField($model,'alt',array('size'=>32,'maxlength'=>32)); ?>
	</div>
	<div class='clearfloat' ></div>

	<div class='row'>
		<?php /*echo CHtml::activeLabel($model,'download');*/ ?>
		<?php /*echo CHtml::activeCheckBox($model,'download').Yii::t('lan','Check for downloadable file') ; */?>
	</div>



		<table class="" >
		<tr>
			<td><?php echo Yii::t('lan','WidthxHeight'); ?></td><td><?php echo $model->widthxheight; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('lan','Size'); ?></td><td><?php echo $model->size; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('lan','Type'); ?></td><td><?php echo $model->type; ?></td>
		</tr>
		<tr>
			<td><?php echo Yii::t('lan','Created'); ?></td><td><?php echo date('Y-m-d H:s',$model->createTime);?></td>
		</tr>
		</table>
	<div class='clearfloat' ></div>

	<div class="action">
	<?php echo CHtml::submitButton($update ? Yii::t('lan','Save') : Yii::t('lan','Create')); ?>
	</div>
<?php echo CHtml::endForm(); ?>

</div>
