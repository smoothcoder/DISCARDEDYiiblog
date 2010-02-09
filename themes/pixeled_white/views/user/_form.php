<?php $bookmarkWidget=$this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'My profile')); ?>
	<div class='userform'>

		<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data')); ?>

			<?php echo CHtml::errorSummary($model); ?>

			<?php if(Yii::app()->user->status==User::STATUS_ADMIN): ?>
				<div class='row'>
					<?php echo CHtml::activeLabel($model,'username'); ?>
					<?php echo CHtml::activeTextField($model,'username',array('size'=>32,'maxlength'=>50)); ?>
				</div>
			<?php else: ?>
				<div class='row'>
					<div class='label'><?php echo Yii::t('lan','Username'); ?></div>
					<div class='textfield'><?php echo $model->username; ?></div>
				</div>
			<?php endif; ?>
			<div class='row'>
				<p><?php echo Yii::t('lan','Your last login was on ').date('Y-m-d H:s',$model->lastlogin); ?></p>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'password',array(($update)?'':'class'=>'required')); ?>
				<?php echo CHtml::activePasswordField($model,'password',array('size'=>32,'maxlength'=>32, 'value'=>($update && !$_POST) ? '' : $model->password)); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'email'); ?>
				<?php echo CHtml::activeTextField($model,'email',array('size'=>45,'maxlength'=>64)); ?>
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'url'); ?>
				<?php echo CHtml::activeTextField($model,'url',array('size'=>45,'maxlength'=>64)); ?>
			</div>
			<div class='clearfloat' ></div>
			<?php if(Yii::app()->user->status==User::STATUS_ADMIN): ?>
				<div class='row'>
					<?php echo CHtml::activeLabel($model,'status'); ?>
					<?php echo CHtml::activeDropDownList($model,'status',User::model()->statusOptions); ?>
				</div>

				<div class='row'>
					<?php echo CHtml::activeLabel($model,'banned'); ?>
					<?php $result = CHtml::activeRadioButtonList($model,'banned',User::model()->bannedOptions,array('separator'=>'')); ?>
					<?php echo str_replace('label','span',$result); ?>
				</div>
			<?php endif; ?>

			<div class='row'>
				<?php echo CHtml::activeLabel($model,'avatar'); ?>
				<?php echo CHtml::activeFileField($model,'avatar'); ?>
			</div>

			<div class='row'>
				<img src="<?php echo Yii::app()->baseUrl.'/uploads/avatar/'.(($model->avatar)?$model->avatar:Yii::app()->params['noAvatar']); ?>" alt="<?php echo ($model->username);  ?>"  title="<?php echo ($model->username);  ?>" />
			</div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'about'); ?>
				<?php echo CHtml::activeTextArea($model,'about',array('rows'=>5, 'cols'=>52)); ?>
			</div>
			<div class='clearfloat' ></div>
			<div class='row'>
				<?php echo CHtml::activeLabel($model,'newsletter'); ?>
				<?php echo CHtml::activeCheckBox($model,'newsletter').Yii::t('lan','Check to subscribe to newsletter') ; ?>
			</div>

			<div class='action'>
				<?php echo CHtml::submitButton($update ? Yii::t('lan','Save') : Yii::t('lan','Create')); ?>
			</div>

		<?php echo CHtml::endForm(); ?>

	</div>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('system.web.widgets.CClipWidget', array('id'=>'My bookmarks'));
	//here code is the same as UserController actionBookmarks() but with renderPartial
	$criteria=new CDbCriteria;

        $pages=new CPagination(User::model()->count($criteria));
        $pages->pageSize=Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

	 $models=$this->loadUser(Yii::app()->user->id);

        $this->renderPartial('bookmarks',array(
            'models'=>$models->bookmarks,
            'pages'=>$pages,
        ));
?>

<?php $this->endWidget(); ?>


<?php
$tabParameters = array();
foreach($this->clips as $key=>$clip)
    $tabParameters['tab'.(count($tabParameters)+1)] = array('title'=>$key, 'content'=>$clip);
?>

<?php $this->widget('system.web.widgets.CTabView', array('tabs'=>$tabParameters)); ?>