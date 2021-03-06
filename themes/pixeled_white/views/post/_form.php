<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/fckeditor/fckeditor.js', CClientScript::POS_HEAD); ?>

<div class="posteditform">
	<?php echo CHtml::form(); ?>

	<?php echo CHtml::errorSummary($post); ?>

	<div class="row">
		<?php echo CHtml::activeLabel($post,'title'); ?>
		<?php echo CHtml::activeTextField($post,'title',array('size'=>65,'maxlength'=>128)); ?>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabelEx($post,'categoryId'); ?>
		<?php
			$categories = Category::getListData();
			echo CHtml::activeDropDownList(  $post,   'categoryId',   CHtml::listData($categories,'id','name'));
		?>
	</div>
	<div class="row">
				<?php echo CHtml::activeLabelEx($post,'publishTime'); ?>
				<?php

					$post->publishTime=date('Y-m-d H:s',($post->publishTime==null)?time():$post->publishTime); //specific for my97DatePicker
					$this->widget('application.extensions.my97DatePicker.JMy97DatePicker', array(
					'model' => $post,
					'attribute' => 'publishTime',
					'options' => array('dateFmt' => Yii::app()->params['dateformatpicker']),
					// 'options' => array('dateFmt' => 'yyyy-MM-dd HH:mm'),
					// 'htmlOptions' => array('value' => $model->endTimeFormatted),
				));?>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($post,'content'); ?>

		<?php // Editor
			$this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
			"model"=>$post,				# Data-Model
			"attribute"=>'content',			# Attribute in the Data-Model
			"height"=>'400px',
			"width"=>'100%',
			"toolbarSet"=>'Default', 			# EXISTING(!) Toolbar (see: fckeditor.js)  /Basics / Default
			"fckeditor"=>Yii::app()->basePath."/../js/fckeditor/fckeditor.php",
											# Path to fckeditor.php
			"fckBasePath"=>Yii::app()->baseUrl."/js/fckeditor/",
											# Realtive Path to the Editor (from Web-Root)
			"config" => array("EditorAreaCSS"=>Yii::app()->baseUrl.'/css/index.css',),
											# Additional Parameter (Can't configure a Toolbar dynamicly)
		) ); ?>
		<p class="hint">
		</p>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($post,'tags'); ?>
		<?php echo CHtml::activeTextField($post,'tags',array('size'=>65)); ?>
		<p class="hint">
		Separate different tags with commas.
		</p>
	</div>
	<div class="row">
		<?php echo CHtml::activeLabel($post,'status'); ?>
		<?php echo CHtml::activeDropDownList($post,'status',Post::model()->statusOptions); ?>
	</div>

	<div class="row action">
		<?php echo CHtml::submitButton($update ? 'Save' : 'Create', array('name'=>'submitPost')); ?>
		<?php echo CHtml::submitButton('Preview',array('name'=>'previewPost')); ?>
	</div>

	</form>
</div><!-- form -->

<?php if(isset($_POST['previewPost']) && !$post->hasErrors()): ?>
	<h3>Preview</h3>
	<div class="post">
		<div class="title"><?php echo CHtml::encode($post->title); ?></div>
		<div class="author">posted by <?php echo Yii::app()->user->name . ' on ' . date('F j, Y',$post->createTime); ?></div>
		<div class="content">
			<?php echo $post->content; ?>
		</div>
	</div><!-- post preview -->
<?php endif; ?>