<?php if(Yii::app()->user->hasFlash('commentSubmittedMessage')): ?>
	<div class="form">
	<?php echo Yii::app()->user->getFlash('commentSubmittedMessage'); ?>
	</div>
<?php return; endif; ?>



	<div id="commentform">
		<?php echo CHtml::form(); ?>

			<?php echo CHtml::errorSummary($comment); ?>

			<div class="commentfield">
				<?php echo CHtml::activeLabel($comment,'authorName'); ?>
				<?php echo CHtml::activeTextField($comment,'authorName'); ?>
			</div>
			<div class="commentfield">
				<?php echo CHtml::activeLabel($comment,'email'); ?>
				<?php echo CHtml::activeTextField($comment,'email',array('size'=>65,'maxlength'=>128)); ?>
				<p class="hint">Your email address will not be published.</p>
			</div>
			<div class="commentfield">
				<?php echo CHtml::activeLabel($comment,'url'); ?>
				<?php echo CHtml::activeTextField($comment,'url',array('size'=>65,'maxlength'=>128)); ?>
			</div>
			<div class="commentfield">
				<?php echo CHtml::activeLabel($comment,'content'); ?>
				<?php /*echo CHtml::activeTextArea($comment,'content',array('rows'=>6, 'cols'=>50));*/?>

<?php // Editor
			$this->widget('application.extensions.fckeditor.FCKEditorWidget',array(
			"model"=>$comment,				# Data-Model
			"attribute"=>'content',			# Attribute in the Data-Model
			"height"=>'210px',
			"width"=>'380',
			"toolbarSet"=>'Basic', 			# EXISTING(!) Toolbar (see: fckeditor.js)  /Basics / Default
			"fckeditor"=>Yii::app()->basePath."/../js/fckeditor/fckeditor.php",
											# Path to fckeditor.php
			"fckBasePath"=>Yii::app()->baseUrl."/js/fckeditor/",
											# Realtive Path to the Editor (from Web-Root)
			"config" => array("EditorAreaCSS"=>Yii::app()->baseUrl.'/css/index.css',),
											# Additional Parameter (Can't configure a Toolbar dynamicly)
		) ); ?>




				<p class="hint">
				<!--You may use <a href="http://daringfireball.net/projects/markdown/syntax" target="_blank">Markdown syntax</a>.-->
				</p>
			</div>
			<div class="cleared"></div>

			<?php if(Yii::app()->user->isGuest && extension_loaded('gd')): ?>
			<div class="commentcaptcha">
				<?php echo CHtml::activeLabel($comment,'verifyCode'); ?>
				<div>
					<?php $this->widget('CCaptcha'); ?>
				</div>
			</div>
			<div class="commentfield">
					<p class="hint">Please enter the letters as they are shown in the image above.
					<br/>Letters are not case-sensitive.</p>
					<label></label>
					<?php echo CHtml::activeTextField($comment,'verifyCode'); ?>
			</div>
			<?php endif; ?>

			<div class="commentaction">
				<?php echo CHtml::submitButton($update ?Yii::t('lan','Save'): Yii::t('lan','Submit'), array('class'=>'submitbutton','name'=>'submitComment')); ?>
				<?php echo CHtml::submitButton(Yii::t('lan','Preview'),array('class'=>'submitbutton','name'=>'previewComment')); ?>
			</div>
		</form>
	</div><!-- commentform -->

	<?php if(isset($_POST['previewComment']) && !$comment->hasErrors()): ?>
		<h3>Preview</h3>
		<div class="comment">
		<div class="authorName"><?php echo $comment->authorLink; ?> says:</div>
		<div class="time"><?php echo date('F j, Y \a\t h:i a',$comment->createTime); ?></div>
		<div class="content"><?php echo $comment->contentDisplay; ?></div>
		</div><!-- post preview -->
	<?php endif; ?>