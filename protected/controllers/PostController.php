<?php

class PostController extends BaseController
{
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_post;

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image
            // this is used by the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }



public function validate_gravatar($email)
	{
		//SC MFM
		// Craft a potential url and test its headers
		$hash = md5($email);
		$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = @get_headers($uri);
		if (!preg_match("|200|", $headers[0])) {
			$has_valid_avatar = FALSE;
		} else {
			$has_valid_avatar = TRUE;
		}
		return $has_valid_avatar;
	}

public function get_gravatar($email)
	{
		//SC MFM
		if($this->validate_gravatar($email))
		{
			$grav_url = "http://www.gravatar.com/avatar.php?gravatar_id=" .
			md5($email) . "&default=" . urlencode($default) . "&size=" . $size;
			echo '<img class="gravatar" src="'.$grav_url.'" width="80px" height="80px"/>';
		}
		else if ($user=User::model()->findByAttributes(array('email'=>$email) ))
		{//show local avatars if the user has no gravatar
		echo '<img class="gravatar" src="'.Yii::app()->request->baseUrl.'/uploads/avatar/'.$user->avatar.'" width="80px" height="80px"/>';
		}
		else echo '<img class="gravatar" src="'.Yii::app()->theme->baseUrl.'/images/nogravatar.jpg" width="80px" height="80px"/>';

		// todo use params['noAvatar'] with params['avatarPath"]
	}


    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('list','show','captcha','PostedInMonth','PostedOnDate', 'search'),
                'users'=>array('*'),
            ),
            array('allow',
                'actions'=>array('ajaxBookmark','create'),
                'users'=>array('@'),
            ),
            array('allow',
                'expression'=>'Yii::app()->user->status=='.User::STATUS_ADMIN.
                    '||Yii::app()->user->status=='.User::STATUS_WRITER,
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Shows a particular post.
     */
    public function actionShow()
    {
        $post=$this->loadPostSlug();
        $newComment=$this->newComment($post);

        $this->pageTitle=$post->title.(($post->category)?' / '.$post->category->name:'');
        $this->render('show',array(
            'post'=>$post,
            'comments'=>$post->comments,
            'newComment'=>$newComment,
        ));
    }

    /**
     * Creates a new post.
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate()
    {
	$this->layout='wide';
        $post=new Post;
        if(isset($_POST['Post']))
        {
            $post->attributes=$_POST['Post'];
            if(isset($_POST['previewPost']))
                $post->validate();
            else if(isset($_POST['submitPost']) && $post->save())
            {
                if(Yii::app()->user->status==User::STATUS_VISITOR)
                {
                    Yii::app()->user->setFlash('message','Thank you for your post. Your post will be posted once it is approved.');
                    $this->redirect(Yii::app()->homeUrl);
                }
                $this->redirect(array('show','slug'=>$post->slug));
            }
        }
        $this->pageTitle=Yii::t('lan','New Post');
        $this->render('create',array('post'=>$post));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate()
    {
	$this->layout='wide';
        $post=$this->loadPost();
        $post->content=($post->contentbig)?$post->contentbig:$post->contentshort;

        if(isset($_POST['Post']))
        {
            $post->attributes=$_POST['Post'];
            if(isset($_POST['previewPost']))
                $post->validate();
            else if(isset($_POST['submitPost']) && $post->save())
                $this->redirect(array('show','slug'=>$post->slug));
        }
        $this->pageTitle=Yii::t('lan','Update Post');
        $this->render('update',array('post'=>$post));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     */
    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadPost()->delete();
            $this->redirect(array('list'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all posts.
     */
    public function actionList()
    {
        $criteria=new CDbCriteria;
        $criteria->condition='status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time();// MFM 1.1 migration Post to t.publishTime
        $criteria->order='createTime DESC';


        if(!empty($_GET['tag']))
        {
            $this->pageTitle=Yii::t('lan','Posts Tagged with').' "'.CHtml::encode($_GET['tag']).'"';
            $withOption['tagFilter']['params'][':tag']=$_GET['tag'];
            $postsCount=Post::model()->with($withOption)->count($criteria);
        }
        else
        {
            $this->pageTitle=Yii::app()->name . ' - Posts';
            $postsCount=Post::model()->count($criteria);
        }
        $pages=new CPagination($postsCount);
        $pages->pageSize=Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

        $posts=Post::model()->with($withOption)->findAll($criteria);
		// SC MFM :

		$this->render('list',array(
			'posts'=>$posts,
			'pages'=>$pages,
		));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $this->processAdminCommand();

        $criteria=new CDbCriteria;

        $pages=new CPagination(Post::model()->count($criteria));
        $pages->applyLimit($criteria);

        $sort=new CSort('Post');
        $sort->defaultOrder='status ASC, createTime DESC';
        $sort->applyOrder($criteria);

        $posts=Post::model()->findAll($criteria);

        $this->pageTitle=Yii::t('lan','Manage Posts');
        $this->render('admin',array(
            'posts'=>$posts,
            'pages'=>$pages,
            'sort'=>$sort,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadPost($id=null)
    {
        if($this->_post===null)
        {
            if($id!==null || isset($_GET['id']))
                $this->_post=Post::model()->findbyPk($id!==null ? $id : $_GET['id']);
            if($this->_post===null ||
			Yii::app()->user->status!=User::STATUS_ADMIN
			&& Yii::app()->user->status!=User::STATUS_WRITER
			&& $this->_post->status!=Post::STATUS_PUBLISHED
			&& $this->_post->publishTime<time() )
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_post;
    }

    /**
     * Returns the data model based on the slug given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param string the slug value. Defaults to null, meaning using the 'slug' GET variable
     */
    public function loadPostSlug($slug=null)
    {
        if($this->_post===null)
        {
            if($id!==null || isset($_GET['slug']))
                $this->_post=Post::model()->find('slug=:slug',array('slug'=>$slug!==null ? $slug : $_GET['slug']));
            if($this->_post===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }

        return $this->_post;
    }

    /**
     * Creates a new comment.
     * This method attempts to create a new comment based on the user input.
     * If the comment is successfully created, the browser will be redirected
     * to show the created comment.
     * @param Post the post that the new comment belongs to
     * @return Comment the comment instance
     */
    protected function newComment($model)
    {
        $comment=new Comment;
        if(isset($_POST['Comment']))
        {
        $comment->attributes=$_POST['Comment'];
        if(!Yii::app()->user->isGuest)
	{
		$comment->authorName=Yii::app()->user->username;
		$comment->email=Yii::app()->user->email;
		$comment->authorId=Yii::app()->user->id;
	}
	else
	{	 //MFM
		$comment->authorName=$comment->attributes['authorName'];
		$comment->email=$comment->attributes['email'];
	}
	$comment->content=$comment->attributes['content'];
	$comment->url=$comment->attributes['url'];

            if(Yii::app()->user->isGuest && Yii::app()->params['commentNeedApproval'])
                $comment->status=Comment::STATUS_PENDING;
            else
                $comment->status=Comment::STATUS_APPROVED;

            $comment->postId=$model->id;

            if(isset($_POST['previewComment']))
                $comment->validate();
            else
                if(isset($_POST['submitComment']) && $comment->save())
                {
                    if($comment->status==Comment::STATUS_PENDING)
                    {
                        Yii::app()->user->setFlash('commentSubmittedMessage',Yii::t('lan','Thank you for your comment. Your comment will be posted once it is approved.'));
                        $this->refresh();
                    }
                    else
                        $this->redirect(array('show','slug'=>$model->slug,'#'=>'c'.$comment->id));
                }
        }
        return $comment;
    }

    /**
     * Executes any command triggered on the admin page.
     */
    protected function processAdminCommand()
    {
        if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
        {
            $this->loadPost($_POST['id'])->delete();
            // reload the current page to avoid duplicated delete actions
            $this->refresh();
        }
    }

    /**
     * Add/Delete Bookmark with AJAX.
     */
    public function actionAjaxBookmark()
    {
        $post=$this->loadPost();
	$post->refresh();

        echo (Bookmark::addDel($post->id))?Yii::t('lan','Delete'):Yii::t('lan','Add');

     }

    /**
     * Collect posts issued in specific month
     */
    public function actionPostedInMonth()
    {
        $criteria=new CDbCriteria;
        $criteria->condition='status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time();// MFM 1.1 migration Post to t.publishTime
        $criteria->order='createTime DESC';

        $criteria->condition.=' AND createTime > :time1 AND createTime < :time2';

	if (isset($_GET['month']))
	{
		$month = intval($_GET['month']);
		$year = intval($_GET['year']);//	var_dump($_GET); echo $month."#".$year."<br/>";
	}
	if (isset($_GET['time']))
	{
		$month = date('n', $_GET['time']);
		$year = date('Y', $_GET['time']);	//	var_dump($_GET); echo $month."#".$year."<br/>";
	}

          if ($_GET['pnc'] == 'n') $month++;
          if ($_GET['pnc'] == 'p') $month--;
          $criteria->params[':time1']= $firstDay = mktime(0,0,0,$month,1,$year);
          $criteria->params[':time2']= mktime(0,0,0,$month+1,1,$year);

        $pages=new CPagination(Post::model()->count($criteria));
        $pages->pageSize=Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

        $models=Post::model()->findAll($criteria);
//         $models=Post::model()->with('author')->findAll($criteria);

        $this->pageTitle=Yii::t('lan','Posts Issued on').' "'.Yii::t('lan',date('F',$firstDay)).date(', Y',$firstDay).'"';
        $this->render('month',array(
            'posts'=>$models,
            'pages'=>$pages,
            'firstDay'=> $firstDay,
        ));
    }




    /**
     * Collect posts issued in specific date http://--------------/post/PostedOnDate/time/1263389366
     */
    public function actionPostedOnDate()
    {
        $criteria=new CDbCriteria;
        $criteria->condition='status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time();// MFM 1.1 migration Post to t.publishTime
        $criteria->order='createTime DESC';

        $criteria->condition.=' AND createTime > :time1 AND createTime < :time2';
        $month = date('n', $_GET['time']);
        $date = date('j', $_GET['time']);
        $year = date('Y', $_GET['time']);

        $criteria->params[':time1']=$theDay = mktime(0,0,0,$month,$date,$year);
        $criteria->params[':time2']=mktime(0,0,0,$month,$date+1,$year);

        $pages=new CPagination(Post::model()->count($criteria));
        $pages->pageSize=Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

        $models=Post::model()->findAll($criteria);
// 	$models=Post::model()->with('author')->findAll($criteria);

        $this->pageTitle=Yii::t('lan','Posts Issued on').' "'.Yii::t('lan',date('F',$theDay)).date(' j, Y',$theDay).'"';
        $this->render('date',array(
            'posts'=>$models,
            'pages'=>$pages,
            'theDay'=> $theDay,
        ));
    }

    /**
     * Sitewide search.
     * Shows a particular post searched.
     */
    public function actionSearch()
    {
        $search=new SiteSearchForm;

        if(isset($_POST['SiteSearchForm']))
        {
            $search->attributes=$_POST['SiteSearchForm'];
            $_GET['searchString']=$search->keyword;
        }
        else
            $search->keyword=$_GET['searchString'];

        if($search->validate())
        {

            $criteria=new CDbCriteria;
            $criteria->condition='status='.Post::STATUS_PUBLISHED.' AND t.publishTime<'.time();// MFM 1.1 migration Post to t.publishTime
            $criteria->order='createTime DESC';

            $criteria->condition.=' AND contentshort LIKE :keyword';
            $criteria->params=array(':keyword'=>'%'.CHtml::encode($search->keyword).'%');

            $postCount=Post::model()->count($criteria);
            $pages=new CPagination($postCount);
            $pages->pageSize=Yii::app()->params['postsPerPage'];
            $pages->applyLimit($criteria);

            $posts=Post::model()->findAll($criteria);
        }

        $this->pageTitle=Yii::t('lan','Search Results').' "'.CHtml::encode($_GET['searchString']).'"';
        $this->render('search',array(
            'posts'=>($posts)?$posts:array(),
            'pages'=>$pages,
            'search'=>$search,
        ));
    }

    /**
     * Change status with AJAX.
     */
    public function actionAjaxStatus()
    {
        $model=$this->loadPost();
        $options=Post::getStatusOptions();
        $model->status=(count($options)==($model->status+1))?0:($model->status+1);
        $model->save(false);
        echo $model->statusText;
    }
}
