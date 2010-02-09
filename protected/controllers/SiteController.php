<?php
//MFM CController

class SiteController extends BaseController
{
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	public function actionMoira()
	{
		$this->layout='main';
		$this->render('moira');
	}
	public function actionCharacters()
	{
		$this->layout='main';
		$this->render('characters');
	}
	public function actionGraphic()
	{
		$this->layout='wide';
		$this->render('graphic');
	}
	public function actionAbout()
	{
		$this->layout='main';
		$this->render('about');
	}
	public function actionCopyrights()
	{
		$this->layout='main';
		$this->render('copyrights');
	}

	public function actionThanksforpayment()
	{
		$this->layout='main';
		$this->render('thanksforpayment');
	}
	public function actionPaymentcancelled()
	{
		$this->layout='main';
		$this->render('paymentcanceled');
	}

    /**
     * Generate Post feed.
     */
    public function actionPostFeed()
    {
        Yii::import('application.vendors.*');
        require_once('Zend/Feed/Rss.php');

        // retrieve the latest 20 models
        $models=Post::model()->findAll(array(
            'order'=>'createTime DESC',
            'condition'=>'status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time(),// MFM 1.1 migration Post to t.publishTime
            'limit'=>20,
        ));

        // convert to the format needed by Zend_Feed
        $entries=array();
        foreach($models as $model)
        {
           $excerptfeed= Post::sc_getexcerpt($model->contentshort,' ... ', 100);
            $entries[]=array(
                'title'=>$model->title,
                'link'=>CHtml::encode($this->createAbsoluteUrl('post/show',array('slug'=>$model->slug))),
                'description'=>$excerptfeed,
                'lastUpdate'=>$model->createTime,
            );
        }

        // generate and render RSS feed
        $feed=Zend_Feed::importArray(array(
            'title'=>Yii::t('lan','Post Feed for ').Yii::app()->params['title'],
            'description'=>Yii::app()->params['description'],
            'link'=>$this->createAbsoluteUrl(''),
            'charset'=>'UTF-8',
            'entries'=>$entries,
        ), 'rss');
        $feed->send();
    }

    /**
     * Generate Comment feed.
     */
    public function actionCommentFeed()
    {
        Yii::import('application.vendors.*');
        require_once('Zend/Feed/Rss.php');

        // retrieve the latest 20 models
        $models=Comment::model()->findRecentComments(20);

        // convert to the format needed by Zend_Feed
        $entries=array();
        foreach($models as $model)
        {
	    $excerptfeed= Post::sc_getexcerpt($model->contentDisplay,' ... ', 100);
            $entries[]=array(
                'title'=>(($model->author)?$model->author->username:$model->authorName).' '.Yii::t('lan','on').' '.CHtml::encode($model->post->title),
                'link'=>CHtml::encode($this->createAbsoluteUrl('post/show',array('slug'=>$model->post->slug,'#'=>'c'.$model->id))),
                'description'=>$excerptfeed,
                'lastUpdate'=>$model->createTime,
            );
        }

        // generate and render RSS feed
        $feed=Zend_Feed::importArray(array(
            'title'=>Yii::t('lan','Comment Feed for ').Yii::app()->params['title'],
            'description'=>Yii::app()->params['description'],
            'link'=>$this->createAbsoluteUrl(''),
            'charset'=>'UTF-8',
            'entries'=>$entries,
        ), 'rss');
        $feed->send();
    }

    /**
     * Generate sitemap.
     */
    public function actionSitemapxml()
    {

        $posts=Post::model()->findAll(array(
            'order'=>'createTime DESC',
            'condition'=>'status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time(), // MFM 1.1 migration Post to t.publishTime
        ));


        $pages=Page::model()->findAll(array(
            'order'=>'createTime DESC',
            'condition'=>'status='.Page::STATUS_PUBLISHED // TODO add publishtime on Page too
        ));
// foreach($posts as $model) echo $this->createAbsoluteUrl('post/show',array('slug'=>$model->slug))."#<br/>";
// foreach($pages as $model) echo $this->createAbsoluteUrl('page',array('slug'=>$model->slug))."$<br/>";
        header('Content-Type: application/xml');
        $this->renderPartial('../site/sitemapxml',array('posts'=>$posts,'pages'=>$pages));
    }
}