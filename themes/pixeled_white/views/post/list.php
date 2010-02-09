<?php if(!empty($_GET['tag'])): ?>
<h3>Posts Tagged with "<?php echo CHtml::encode($_GET['tag']); ?>"</h3>
<?php endif; ?>

<?php foreach($posts as $post): ?>

	<?php $this->renderPartial('_post',array(
		'post'=>$post,));
	?>
	<?php  $this->widget('application.components.sociable.sociable',
			array(
				'post'=>$post,
				'active_sites'=>array(
				'Print',
				'Digg',
				'豆瓣',
				'del.icio.us',
				'Facebook',
				'Mixx',
				'Google',
				'Twitter',
				'Scoopeo',
				'MySpace',
				'Posterous',
				'Technorati',
				'StumbleUpon',
				'Yahoo! Bookmarks',
				'QQ书签'
					),
				)
			);
	?>

<?php endforeach; ?>

<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>