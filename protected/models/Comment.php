<?php

class Comment extends CActiveRecord
{

    const STATUS_PENDING=0;
    const STATUS_APPROVED=1;
    const COMMENT_NOT_SPAM=0;
    const COMMENT_IS_SPAM=1;
    /**
     * @var string this property is used to collect user verification code input
     */
    public $verifyCode;

    /**
     * The followings are the available columns in table 'Comment':
     * @var integer $id
     * @var string $content
     * @var string $contentDisplay
     * @var integer $status
     * @var integer $spam
     * @var integer $createTime
     * @var string $authorName
     * @var string $email
     * @var string $url
     * @var integer $postId
     * @var integer $authorId
     * @var integer $authorIp
     */

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'Comment';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('authorName','length','max'=>50),
            array('email','length','max'=>64),
            array('authorName,email,content', 'required'),
	    array('authorIP','length','max'=>64),//MFM
	    //array('spam','spam'), //MFM commented because it search for file spam.php
            array('email','email'),
            array('authorName','match','pattern'=>'/^[\w\s._-]{3,50}$/','message'=>Yii::t('lan','Wrong or small username.')),
            array('verifyCode', 'captcha', 'on'=>'insert',
                'allowEmpty'=>!Yii::app()->user->isGuest || !extension_loaded('gd')),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'post'=>array(self::BELONGS_TO, 'Post', 'postId', 'joinType'=>'INNER JOIN'),
            'author'=>array(self::BELONGS_TO,'User','authorId', 'joinType'=>'INNER JOIN'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'content'=>Yii::t('lan','Comment'),
            'authorName'=>Yii::t('lan','Author'),
            'email'=>Yii::t('lan','Email'),
	    'authorIP'=>Yii::t('lan','Author IP'),
	    'url'=>Yii::t('lan','Url'),
            'verifyCode'=>Yii::t('lan','Verification Code'),
        );
    }

    /**
     * @return array attributes that can be massively assigned
     */
    public function safeAttributes()
    {
        return array('authorName','email','url','content','verifyCode');
    }

    /**
     * @return array comment status names indexed by status IDs
     */
    public function getStatusOptions()
    {
        return array(
            self::STATUS_PENDING=>Yii::t('lan','Pending'),
            self::STATUS_APPROVED=>Yii::t('lan','Approved'),
        );
    }

   /**
     * @return array comment spam names indexed by spam IDs
     */
    public function getSpamOptions()
    {
        return array(
            self::COMMENT_IS_SPAM=>Yii::t('lan','Spam'),
            self::COMMENT_NOT_SPAM=>Yii::t('lan','Neutral'),
        );
    }

    /**
     * @return string the status display for the current comment
     */
    public function getStatusText()
    {
        $options=$this->statusOptions;
        return $options[$this->status];
    }

    /**
     * @return string the status display for the current comment
     */
    public function getSpamText()
    {
       if (Yii::app()->user->status==User::STATUS_ADMIN)
	{
		$options=$this->spamOptions;
		return $options[$this->spam];
	}
	else return false;
    }

    /**
     * @return integer the number of comments that are pending approval
     */
    public function getPendingCommentCount()
    {
        return Comment::model()->count('status='.self::STATUS_PENDING);
    }

   /**
     * @return integer the number of comments that are qualified spams
     */
    public function getSpamCommentCount()
    {
        return Comment::model()->count('spam='.self::COMMENT_IS_SPAM);
    }

    /**
     * @param integer the maximum number of comments that should be returned
     * @return array the most recently added comments
     */
    public function findRecentComments($limit=10)
    {
        $criteria=array(
            'condition'=>'t.status='.self::STATUS_APPROVED,// MFM 1.1 migration Comment to t
            'order'=>'t.createTime DESC',// MFM 1.1 migration comment to t
            'limit'=>$limit,
        );
        return $this->with('post')->findAll($criteria);
    }

    /**
     * Approves a comment.
     */
    public function approve()
    {
        if($this->status==Comment::STATUS_PENDING)
        {
            $this->status=Comment::STATUS_APPROVED;
	    $this->save(false);
            Post::model()->updateCounters(array('commentCount'=>1), "id={$this->postId}");

        }
    }

   /**
     * spams a comment.
     */
    public function spam_comment()
    {
        if($this->spam==Comment::COMMENT_NOT_SPAM)
        {
            $this->spam=Comment::COMMENT_IS_SPAM;
	    $this->save(false);
            //still needs to be approved or unapproved
        }
    }

    /**
     * UnApproves a comment.
     */
    public function unapprove()
    {
        if($this->status==Comment::STATUS_APPROVED)
        {
            $this->status=Comment::STATUS_PENDING;
	   $this->save(false);
            Post::model()->updateCounters(array('commentCount'=>-1), "id={$this->postId}");
        }
    }

   /**
     * unspams a comment.
     */
    public function unspam_comment()
    {
        if($this->spam==Comment::COMMENT_IS_SPAM)
        {
            $this->spam=Comment::COMMENT_NOT_SPAM;
	    $this->save(false);
            //still needs to be approved or unapproved
        }
    }


    /**
     * Prepares attributes before performing validation.
     */
    protected function beforeValidate()
    {
        //$parser=new CMarkdownParser;
        //$this->contentDisplay=$parser->safeTransform($this->content);
	$this->contentDisplay=$this->content;
	$akismet=Yii::app()->CAkismetComponent;
	$akismet->is_spam($this);

        if($this->isNewRecord)
            $this->createTime=time();
        return true;
    }

    /**
     * @return string the hyperlink display for the current comment's author
     *                  (user link)
     */
    public function getAuthorLink()
    {
        if(!empty($this->author))
            return CHtml::link($this->author->username,array('user/show','id'=>$this->author->id));
        else
            return $this->authorName;
    }

	public function getAuthorIP()
    {
        if(!empty($this->authorIP) && (Yii::app()->user->status==User::STATUS_ADMIN) )
            return CHtml::link($this->authorIP,$this->url);
        else
            return $this->authorName;
    }
/**
     * @return string the url display for the current comment's author
     *                  (website link)
     */
    public function getAuthorUrl()
    {
        if( !empty($this->url) )
			return CHtml::link($this->authorName,$this->url);
	else
            return $this->authorName;
    }

/**
     * @return string the url display for the current comment's author
     *                  (email) only displayed for admin
     */
    public function getAuthorEmail()
    {
        if( ( !empty($this->email) ) && (Yii::app()->user->status==User::STATUS_ADMIN)  )
			return CHtml::mailto($this->email,$this->email);
	else
            return null;
    }

    /**
     * Postprocessing after the record is saved
     */
    protected function afterSave()
    {
        if($this->isNewRecord && $this->status==Comment::STATUS_APPROVED)
            Post::model()->updateCounters(array('commentCount'=>1), "id={$this->postId}");

    }

    /**
     * Postprocessing after the record is deleted
     */
    protected function afterDelete()
    {
        if($this->status==Comment::STATUS_APPROVED)
            Post::model()->updateCounters(array('commentCount'=>-1), "id={$this->postId}");
    }
}
