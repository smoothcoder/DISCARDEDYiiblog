<?php

class CommentController extends BaseController
{
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_comment;

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
		//SC MFM TODO: unify with POST function
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
		//SC MFM TODO: unify with POST function
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

		//todo else show local avatars if the user has no gravatar
	}
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow admin and writer
                'expression'=>'Yii::app()->user->status=='.User::STATUS_ADMIN.
                    '||Yii::app()->user->status=='.User::STATUS_WRITER,
            ),
            array('deny',  // deny guest users
                'users'=>array('?'),
            ),
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate()
    {
        $comment=$this->loadComment();

        if(isset($_POST['Comment']))
        {
            $comment->attributes=$_POST['Comment'];

            if(isset($_POST['previewComment']))
                $comment->validate();
            else if(isset($_POST['submitComment']) && $comment->save())
                $this->redirect(array('post/show','slug'=>$comment->post->slug,'#'=>'c'.$comment->id));
        }

        $this->pageTitle=Yii::t('lan','Update Comment');
        $this->render('update',array('comment'=>$comment));
    }

    /**
     * Deletes a particular model with AJAX.
     */
    public function actionAjaxDelete()
    {
        $comment=$this->loadComment();
        $comment->delete();
// 	echo 	(  CHtml::ajaxLink('Successfuly suppressed',	$this->createUrl('comment/ajaxDelete',array('id'=>$comment->id)),
// 										array('success'=>'function(msg){ $("#c'.$comment->id.'").animate({ opacity: "hide" }, "slow"); }'),
// 										)
// 			);
	$comment->post->refresh();
    }

    /**
     * Approves a particular comment with AJAX.
     */
    public function actionAjaxApprove()
    {
        $comment=$this->loadComment();
	if ($comment->status==Comment::STATUS_PENDING)
	{
	$comment->approve();
	$appColor='';
	echo 	(  CHtml::ajaxLink('UnApprove',	$this->createUrl('comment/ajaxApprove',array('id'=>$comment->id)),
										array('success'=>'function(msg){ pThis.html(msg); }'),
										array('onclick'=>'var pThis=$(this)','style'=>'color:'.$appColor ))
			);
	}
	else
	{
	$comment->unapprove();
	$appColor='red';
	echo 	(  CHtml::ajaxLink('Approve',	$this->createUrl('comment/ajaxApprove',array('id'=>$comment->id)),
										array('success'=>'function(msg){ pThis.html(msg); }'),
										array('onclick'=>'var pThis=$(this)','style'=>'color:'.$appColor ))
			);
        }

	$comment->post->refresh();
    }


    /**
     * Lists all pending comments.
     */
    public function actionList()
    {
        $criteria=new CDbCriteria;
        $criteria->condition='t.status='.Comment::STATUS_PENDING;// MFM 1.1 migration Comment to t

        $pages=new CPagination(Comment::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $comments=Comment::model()->with('post')->findAll($criteria);

        $this->pageTitle=Yii::t('lan','Comments Pending Approval');
        $this->render('list',array(
            'comments'=>$comments,
            'pages'=>$pages,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadComment($id=null)
    {

        if($this->_comment===null)
        {
            if($id!==null || isset($_GET['id']))
                $this->_comment=Comment::model()->findbyPk($id!==null ? $id : $_GET['id']);
            if($this->_comment===null)
                throw new CHttpException(404,'The requested comment does not exist.');
        }
        return $this->_comment;
    }
}
