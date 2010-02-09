<h2><?php echo Yii::t('lan','Posts in category'); ?> "<?php echo $model->name; ?>"</h2>

<?php foreach($posts as $post): ?>
    <?php $this->renderPartial('../post/_post',array(
        'post'=>$post,
    )); ?>
<?php endforeach; ?>

<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
