<?php
$type=explode('/',$model->type);
if($type[0]=='image')
{
    $whtext=File::getHOW(Yii::app()->params['filePath'].$model->name);
    $url=Yii::app()->baseUrl.'/uploads/'.Yii::app()->params['sitefileName'].'/'.$model->name;
}
?>

<tr class="<?php echo $n%2?'even':'odd';?>">
	<td align="center">
		<?php echo ($type[0]=='image')
					? (($whtext)
						? CHtml::link(
								CHtml::image(
									$url,
									$model->alt,
									array($whtext=>Yii::app()->params['imageThumbnailBoundingBox'])),
								$url,
								array('class'=>'highslide'))
						: CHtml::image($url, $model->alt))
					: CHtml::image(Yii::app()->theme->baseUrl.'/images/file.png'); ?>
	</td>
	<td>
		<?php echo $model->name.'<br />'.$model->alt; ?>
	</td>
	<td>
		<?php echo $model->type; ?>
	</td>
	<td>
		<?php echo date( Yii::app()->params['dateformat'] ,$model->createTime); ?>
	</td>
	<td>
		<?php echo CHtml::tag('a',array('onclick'=>'insert_html("'.$url.'", "'.$model->alt.'", "'.$type[0].'")'),Yii::t('lan','Insert')); ?>
		<?php echo CHtml::link(Yii::t('lan','Update'),array('update','id'=>$model->id)); ?>

	</td>
</tr>