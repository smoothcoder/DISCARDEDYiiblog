<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php echo CHtml::cssFile(Yii::app()->theme->baseUrl.'/css/style.css'); ?>
	<?php echo CHtml::cssFile(Yii::app()->theme->baseUrl.'/css/form.css'); ?>
	<title><?php echo $this->pageTitle; ?></title>
	<?php
// javascript
  $cs=Yii::app()->clientScript;
  $cs->registerCoreScript('jquery');
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/highslide/highslide.js', CClientScript::POS_HEAD);
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/highslide/highslide_eh.js', CClientScript::POS_HEAD);
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/persist.js', CClientScript::POS_HEAD);
  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.clipboard-2.0.1/jquery.clipboard.js', CClientScript::POS_HEAD);

  $cs->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery-lightbox/jquery.lightbox.js', CClientScript::POS_HEAD);
  $cs->registerCSSFile(Yii::app()->request->baseUrl.'/js/jquery-lightbox/css/lightbox.css');

  $cs->registerLinkTag('alternate','application/rss+xml',$this->createUrl('site/postFeed'));
  $cs->registerLinkTag('alternate','application/rss+xml',$this->createUrl('site/commentFeed'));

  $params = array(
		'BASEURL'=>Yii::app()->request->baseUrl,
                'HTTPHOST'=>$_SERVER['HTTP_HOST']
		  );
  $script = 'var PARAMS = eval('.CJavaScript::jsonEncode($params).');';
  $cs->registerScript('widget-oc1', $script, CClientScript::POS_BEGIN);
  $script = implode('',file(Yii::app()->basePath.'/../js/widget-oc.min.js'));
  $cs->registerScript('widget-oc2', $script, CClientScript::POS_READY);
  $script = 'hs.graphicsDir = PARAMS.BASEURL+\'/js/highslide/graphics/\';'."\n";
  $script .= 'hs.outlineType = \'rounded-white\';'."\n";
  $script .= 'hs.showCredits = false;';
  $cs->registerScript('hislide-end', $script, CClientScript::POS_BEGIN);
  $script = 'addHighSlideAttribute();';
  $cs->registerScript('hislide-end', $script, CClientScript::POS_END);
// css
  $cs->registerCSSFile(Yii::app()->request->baseUrl.'/js/highslide/highslide.css');

?>

<script type="text/javascript">
$(document).ready(function(){

	$(".lightbox").lightbox({
		fitToScreen: true,
		fileLoadingImage : PARAMS.BASEURL+'/js/jquery-lightbox/images/loading.gif',
		fileBottomNavCloseImage : PARAMS.BASEURL+'/js/jquery-lightbox/images/closelabel.gif',
		imageClickClose: false
	});
});
</script>

<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect2',
   '$(".message").animate({opacity: 1.0}, 7000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
</head>

<body>
	<div id="page">

		<?php require_once('headerMenu.php'); ?>


		<div id="catnav">
			<div id="toprss">
				<!--<a href="<?php echo Yii::app()->theme->baseUrl; ?>/rss.xml"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rss-trans.png" alt="<?php echo $this->pageTitle;?>" width="65" height="24" /></a>-->
			</div> <!-- Closes toprss -->
			<?php require_once('navright.php'); ?>
		</div> <!-- Closes catnav -->


		<div id="content">
			<div id="contentwrapperwide">
				<?php echo $content; ?>
			</div><!-- contentwrapper -->
			<div class="cleared"></div>
		</div><!-- content -->



		<div class="cleared"></div>

		<?php require_once('morefoot.php'); ?>

		<div id="footer">
			<div id="footerleft">
				<p>
					<?php echo Yii::app()->params['copyrightInfo']; ?>
					<?php echo Yii::t('lan',  'All Rights Reserved.' ); ?>
				</p>
			</div>
			<div id="footerright">
				<p><?php echo Yii::powered(); ?></p>
			</div>
		</div><!-- footer -->

	</div><!-- page -->
</body>

</html>