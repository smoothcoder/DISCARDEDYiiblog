 <?php if(!$search->hasErrors()): ?>
    <h3><?php echo Yii::t('lan','Search Results'); ?> "<?php echo CHtml::encode($search->keyword); ?>"</h3>
<?php else: ?>
    <h3><?php echo CHtml::error($search,'keyword'); ?></h3>
<?php endif; ?>

<?php foreach($posts as $post): ?>
<?php
    $pizza=explode('>',$post->contentshort);

    $s='';
    for($i=0;$i<count($pizza); $i++)
    {
        $piece=explode('<',$pizza[$i]);
        if(count($piece)==2)
        {
            $replace=preg_replace('/('.CHtml::encode($search->keyword).')/i','<b><span style="background:yellow;">${1}</span></b>',$piece[0]);
            $s.=$replace.'<'.$piece[1].'>';
        }
    }

    $post->contentshort=$s;
    $this->renderPartial('_post',array('post'=>$post));
?>
<?php endforeach; ?>

<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
