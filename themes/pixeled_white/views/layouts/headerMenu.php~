<div id="header">

	<div id="logo">
		<p1><?php echo CHtml::encode(Yii::app()->name);  ?></p1>
		<p2><?php echo CHtml::encode(Yii::app()->params['description']); ?></p2>
	</div>
	<div id="topheader">
		<?php $this->widget('UserLogin',array('visible'=>Yii::app()->user->isGuest)); ?>
		<?php $this->widget('UserMenu',array('visible'=>!Yii::app()->user->isGuest)); ?>

		<?php if(Yii::app()->user->isGuest): ?>
			<div id="adsense_header468x60right">
				<?php echo Yii::app()->params['adsense_header468x60right']; ?>


			</div><!-- adsense-->
		<?php else: ?>
			<div id="adsense_header468x40right">
			</div>
		<?php endif; ?>
	</div><!-- topheader-->

	<div id="mainmenu">
		<?php
			$this->widget('application.extensions.CDropDownMenu', array(
				'items'=>array(
					array('label'=>'Home', 'url'=>array('post/list')),
					array('label'=>'Yii', 'url'=>array('page/extensions'),
					'items'=>array(
						array('label'=>'Sociable', 'url'=>array('page/sociable', 'tag'=>'sociable')),
						)),
					array('label'=>Yii::t('lan',  'Themes' ), 'url'=>array('page/themes')/*, 'visible'=>Yii::app()->user->isGuest*/),
					array('label'=>Yii::t('lan',  'About' ), 'url'=>array('page/about')/*, 'visible'=>Yii::app()->user->isGuest*/),
					),
				)
			);
		?>
	</div><!-- mainmenu -->
	<div class="cleared">
	</div>
</div><!-- header -->
