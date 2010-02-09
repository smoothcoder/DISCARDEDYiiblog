<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<?php echo CHtml::linkTag("Shortcut Icon", "icon", Yii::app()->request->baseUrl."/favicon.ico" );?>
	<?php echo CHtml::cssFile(Yii::app()->theme->baseUrl.'/css/style.css'); ?>
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

<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect2',
   '$("#close_btn").click(function(){ $(".form").animate({opacity: 1.0}, 100).fadeOut("slow"); }); ',
   CClientScript::POS_READY
);
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

</head>

<body>
	<div id="page">
		<?php require_once('headerMenu.php'); ?>

		<div id="catnav">
			<?php require_once('navright.php'); ?>
		</div> <!-- Closes catnav -->


		<div id="content">
			<div id="contentwrapper">
				<?php if(Yii::app()->user->hasFlash('message')): ?>
				<br />
				<div class="form">
					<?php echo Yii::app()->user->getFlash('message'); ?>
				</div>
				<?php endif; ?>
				<?php echo $content; ?>
			</div><!-- contentwrapper -->


			<div id="sidebars">

				<div id="sidebar_full">
					<div id="navicons">
						<ul>
							<li>
								<p> <?php echo Yii::t('lan',  'Follow DISCARDEDteenz.com' ); ?>&nbsp;</p>
							</li>
							<li><?php  $this->widget('application.components.LangBox'); ?>
							</li>
						</ul>
					</div>
					<div class="clearfloat" ></div>
					<div id="navicons">
						<ul >
							<li>
								<a href="http://twitter.com/DISCARDEDteenz" title="<?php echo Yii::t('lan',  'Follow me on Twitter' ); ?>"
									class="myicon">
									<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/22_twitter.png",
												Yii::t('lan',  'twitter' ) , array("title"=>Yii::t('lan',  'Follow me on Twitter' ) ,"class"=>"myicon")
												); ?>
								</a>
							</li>
							<li><?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/22_facebook.png",
												Yii::t('lan',  'facebook' ) , array("title"=>Yii::t('lan',  'Facebook' ) )
												);?>
							</li>
							<li>
								<a href="<?php echo Yii::app()->request->baseUrl; ?>/site/postFeed" title="<?php echo Yii::t('lan',  'Subscribe RSS' ); ?>"
									class="myicon">
									<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/22_rss.png",
												Yii::t('lan',  'rss' ) , array("title"=>Yii::t('lan',  'Subscribe to Rss' ) )
												); ?>
								</a>
							</li>
							<li>
								<a href="http://feedburner.google.com/fb/a/mailverify?uri=PostFeedForDiscardedteenzcom&amp;loc=en_US"
									class="myicon">
									<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/22_letter.png",
												Yii::t('lan',  'newsletter' ) , array("title"=>Yii::t('lan',  'Subscribe to Post Feed for DiscardedTeenz.com by Email' ) )
												); ?>
								</a>
							</li>
							<li style="float:right;margin-right: 20px;">
								<?php echo CHtml::link(Yii::t('lan',  'Registration' ) , array('user/registration'),
												array("title"=>Yii::t("lan",  "Register the website" ) ,
													"style"=>" font-weight: bold; font-size: 1.6em;" )); ?>
							</li>
						</ul>
					</div>
					<ul>
						<li>
							<div id="welcome">
								<div class="cleared"></div>
								<p><?php echo Yii::t('lan',  'Support DISCARDEDdev by reading ' ); ?><b>Moïra</b>!</p>
								<p>
									<ul style="text-align: left; padding-left: 20px;">
									<li><a href="http://www.DISCARDEDteenz.com/site/moira/#intro">Introduction</a>&nbsp;
										<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/flakex16.gif",
												Yii::t('lan',  'Available' ) , array("title"=>Yii::t('lan',  'This section was published.' ) )
												); ?>
									</li>
									<li><a href="http://www.DISCARDEDteenz.com/site/moira/#ch1">Ch1. Sunsets and Super Nova's</a>&nbsp;
										<a class="myicon" href="/page/chapter1">
										<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/flakex16.gif",
												Yii::t('lan',  'Available' ) , array("title"=>Yii::t('lan',  'This section was published.' ) )
												); ?>
										</a>
									</li>
									<li><a href="http://www.DISCARDEDteenz.com/site/moira/#ch2">Ch2. Ice Salt Water</a>&nbsp;
										<a class="myicon" href="/page/chapter2">
												<?php echo CHtml::image(Yii::app()->theme->baseUrl."/images/newx12.gif",
												Yii::t('lan',  'New' ) , array("title"=>Yii::t('lan',  'New section. Read online.' ), )
												); ?>
										</a>
									</li>
									<li>... </li>
									</ul>
								</p>
							</div><!-- welcome -->
						</li>


					</ul>
				</div><!-- sidebar_full -->

				<div id="sidebar_left">

					<ul>
						<li>
							<div class="sidebarbox">
								<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/img1x125.jpg"/>
							</div>
						</li>
					</ul>

					<ul>
						<li>
								<?php $this->widget('Calendar'); ?>
						</li>
					</ul>

				</div><!-- sidebar_left-->

				<div id="sidebar_right">

					<ul>
						<li>
							<div class="sidebarbox">
								<?php $this->widget('TagCloud'); ?>
							</div>
						</li>
					</ul>
					<ul>
						<li>
							<div class="sidebarbox">
								<?php $this->widget('RecentComments'); ?>
							</div>
						</li>
					</ul>
					<ul>
						<li>
							<div class="sidebarbox" style="padding: 8px 2px 8px 2px; ">
							</div>
						</li>
					</ul>
					<ul>
						<li>
							<div class="sidebarbox" style="padding: 8px 2px 8px 2px; ">
								<?php echo Yii::app()->params['script_sideright_1']; ?>
							</div>
						</li>
					</ul>
				</div><!-- sidebar_right -->
						<div class="cleared"></div>
			</div><!-- sidebars -->
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

<?php echo Yii::app()->params['ganalytics_tracker']; ?>
</body>

</html>
