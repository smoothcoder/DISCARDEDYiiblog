<?php $this->pageTitle=Yii::app()->name . ' - Characters'; ?>

<h1>The main characters</h1>

<?php if(Yii::app()->user->hasFlash('characters')): ?>
<div class="confirmation">
<?php echo Yii::app()->user->getFlash('characters'); ?>
</div>
<?php else: ?>
<div class="contentgallery">
	<p>The main characters from Moïra, the book</p>
	<!--<quote>Listen to them. Children of the night. What music they make.</quote><em>- Count Dracula.</em>
	<br/>-->

	<div class="boxparagraph">
		<div class="boxgrid peek">
			<a class="lightbox" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/MOIRA2_.jpg"  rel="lightbox[characters]">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/MOIRA2x200_.jpg"/>
			</a>
			<a class="lightbox" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/MOIRA2.jpg" rel="lightbox[characters]">
				<img class="cover" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/MOIRA2x200.jpg"/>
			</a>
		</div>
		<div>
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/VMB_RF_03.gif" width="370px"/>
		</div>
		<div class="description">
			<p >Moïra, our hero, is the daughter of Q'orianka Bronté, a housewife and Alain Bronté, a French Diplomat. She is an only child and has spent most of her childhood traveling from Paris, London to Vladivostok, Russia.
Moira is a medium height girl, with chocolaty brown hair and deep greenish, gray eyes. She has what most people would call a slightly sassy, devilish attitude. And though she stays polite and quite amicable, she is used to getting into trouble over nothing, (at least that what she says).
As for her abilities, she can control water ; it can go from bending waves to splashing liquids out of nowhere, and unlike her other friends, she can also control the temperature of said water and turn it into ice, for example (which really reflects her state of mind and emotions).
		</div>

	</div>
	<div class="cleared"></div>

	<div class="boxparagraph">

		<div class="boxgrid peek">
			<a class="lightbox" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/VIKTOR2_.jpg"  rel="lightbox[characters]">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/VIKTOR2x200_.jpg"/>
			</a>
			<a class="lightbox" href="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/VIKTOR2.jpg" rel="lightbox[characters]">
				<img class="cover" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/gallery/VIKTOR2x200.jpg"/>
			</a>
		</div>
		<div>
			<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/VMB_RF_01.jpg" width="370px"/>
		</div>
		<div class="description">
			<p >Viktor is the son of Ray Longriver, an Alaskan tour guide and Okala Redspark, Maralah High's principal. He has a sister named June who is two years younger. Viktor is a tall, dark haired surfer type high school boy, who plays on his charm, stupid smile and Neanderthal attitude to influence people. But unlike how he might act when surrounded by other people, he is actually a lovable, smart and humorous guy, (who screams like a girl when punched).
As for his talents,he has the ability to control fire and can light himself up in a few seconds without the help of a spark. When  this happens, his eyes turn from a hazel color to a light green, (in which case step back and protect yourself from any harmful, uncontrolled blast).
		</div>
	</div>
	<div class="cleared"></div>


</div>

<?php endif; ?>