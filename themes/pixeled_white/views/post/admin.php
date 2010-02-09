<h2><?php echo Yii::t('lan','Manage Posts'); ?> <?php echo CHtml::link(Yii::t('lan','New Post'), array('create')); ?></h2>

<table class="dataGrid">
    <tr>
        <th><?php echo $sort->link('status'); ?></th>
        <th><?php echo $sort->link('categoryId'); ?></th>
        <th><?php echo $sort->link('title'); ?></th>
        <th><?php echo $sort->link('author'); ?></th>
        <th><?php echo $sort->link('createTime'); ?></th>
        <th><?php echo $sort->link('updateTime'); ?></th>
        <th><?php echo $sort->link('commentCount'); ?></th>
        <th><?php echo Yii::t('lan','Actions'); ?></th>
    </tr>
    <?php foreach($posts as $n=>$post): ?>
        <tr class="<?php echo $n%2?'even':'odd';?>">
            <td>
                <?php echo CHtml::ajaxLink($post->statusText,
                    $this->createUrl('post/ajaxStatus',array('id'=>$post->id)),
                    array('success'=>'function(msg){ pThis.html(msg); }'),
                    array('onclick'=>'var pThis=$(this);')); ?>
            </td>
            <td><?php echo CHtml::link(CHtml::encode($post->category->name),array('category/show','slug'=>$post->category->slug)); ?></td>
            <td><?php echo CHtml::link(CHtml::encode($post->title),array('show','slug'=>$post->slug)); ?></td>
            <td><?php echo (($post->author->username) ? CHtml::link($post->author->username,array('user/show', 'id'=>$post->authorId)):$post->authorName); ?></td>
            <td><?php echo Yii::t('lan',date('F',$post->createTime)).date(' j, Y',$post->createTime); ?></td>
            <td><?php echo Yii::t('lan',date('F',$post->updateTime)).date(' j, Y',$post->updateTime); ?></td>
            <td><?php echo $post->commentCount; ?></td>
            <td>
                <?php echo CHtml::link(Yii::t('lan','Update'),array('update','id'=>$post->id)); ?>
                <?php echo CHtml::linkButton(Yii::t('lan','Delete'),array(
                    'submit'=>'',
                    'params'=>array('command'=>'delete','id'=>$post->id),
                    'confirm'=>Yii::t('lan','Are you sure to delete')." {$post->title} ?")); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<br/>
<?php $this->widget('CLinkPager',array('pages'=>$pages)); ?>
