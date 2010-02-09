<?php
////DISCARDEDyiiblog

class UserController extends BaseController
{
    const PAGE_SIZE=10;

    /**
     * @var string specifies the default action to be 'list'.
     */
    public $defaultAction='list';

    /**
     * @var CActiveRecord the currently loaded data model instance.
     */
    private $_model;

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }


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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     * *: any user, including both anonymous and authenticated users.
     * ?: anonymous users.
     * @: authenticated users.
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'list' and 'show' actions
                'actions'=>array('registration','captcha','lostpass','login','setlang','download'),
                'users'=>array('*'),
            ),
	array('allow',  // allow authenticated users to perform 'list' and 'show' actions
                'actions'=>array('show'),
                'users'=>array('@'),
            ),
	array('allow',  // allow authenticated users to perform 'list' and 'show' actions
                'actions'=>array('list'),
                'roles'=>array('admin'),
            ),
	    array('deny',  // MFM
              'actions'=>array('show','list'),
               'users'=>array('?'),
           ),
            array('allow',
                'expression'=>'Yii::app()->user->status=='.User::STATUS_ADMIN,
            ),
            array('allow',
                'actions'=>array('update'),
                'expression'=>'Yii::app()->user->id=='.$_GET['id'],
            ),
            array('allow',
                'actions'=>array('bookmarks','logout'),
                'users'=>array('@'),
            ),

            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Shows a particular model.
     */
    public function actionShow()
    {
        $model=$this->loadUser();
	//  if(Yii::app()->user->isGuest ) return;
	//  if( !strcmp(Yii::app()->user->name, $model->username) )
	$params=Yii::app()->params;

        $this->pageTitle=Yii::t('lan','View User').' '.$model->username;
        $this->render('show',
            array('model'=>$model));
    }

    /**
     * Creates a new model. (creation if for admin )
     * If creation is successful, the browser will be redirected to the 'show' page.
     */
    public function actionCreate()
    {
        $model=new User;
        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->password && $model->validate())
                $model->password=md5($model->password);

            $model->avatar=CUploadedFile::getInstance($model,'avatar');
            if($model->avatar && $model->validate())
            {
                $imagename=User::getRIN().'.'.$model->avatar->getExtensionName();
                $image=Yii::app()->image->load($model->avatar->getTempName());
                $image->resize(Yii::app()->params['avatarWidth'],Yii::app()->params['avatarHeight']);
                $image->save(Yii::app()->params['avatarPath'].$imagename);
                $model->avatar=$imagename;
            }
            if($model->save())
                $this->redirect(array('show','id'=>$model->id));
        }
        $this->pageTitle=Yii::t('lan','New User');
        $this->render('create',array('model'=>$model));
    }

    /**
     * Registration a new user.
     * If creation is successful, the browser will be redirected to the 'home' page.
     */
    public function actionRegistration()
    {

        if(isset($_GET['code']))
        {
		$user=User::model()->find('confirmRegistration=:confirmRegistration',
			array(':confirmRegistration'=>$_GET['code']));
		if($user===null)
			throw new CHttpException(404,'The requested page does not exist.');
		$user->confirmRegistration='';
		$message=Yii::t('lan','Thank you for confirming your email. You can login with your username and password.');
		$message .= '';
		Yii::app()->user->setFlash('message', $message );

		$user->save();

		$this->redirect(Yii::app()->homeUrl);
        }

        $model=new User;
        if(isset($_POST['User']))
        {
		$model->attributes=$_POST['User'];
		$model->status=User::STATUS_VISITOR;
		$model->banned=User::BANNED_NO;
		$model->newsletter=User::NEWSLETTER_NO;

		if($model->validate('registration'))
		{
			if(Yii::app()->params['confirmRegistration'])
			{
				$model->confirmRegistration=$code=User::getRIN(); //Random name for avatar
				$email = array();
				$email= Yii::app()->WB_Email ;
				$email->init() ;
				$email->setFrom( Yii::app()->params['adminEmail'],Yii::app()->params['emailFrom']);

				$search = array ( '{name}', '{email}' );
				$replace = array ( 'My name', 'myemail@mydomain.com' );
				$email->addRecipient ($model->email,$model->username );

				// Retrieve params that are stored in DB:Config
				Yii::app()->params['smtp_server']	=Yii::app()->config->get('smtp_server');
				Yii::app()->params['smtp_address']=Yii::app()->config->get('smtp_address');
				Yii::app()->params['smtp_username']=Yii::app()->config->get('smtp_username');
				Yii::app()->params['smtp_password']=Yii::app()->config->get('smtp_password');
				Yii::app()->params['smtp_port']	=Yii::app()->config->get('smtp_port');		//587
				Yii::app()->params['smtp_secure']	=Yii::app()->config->get('smtp_secure'); 	//secure

				//      Adding this line will force the emailer to use smtp for authentication,
				//      otherwise it will use sendmail or the mail function
				$email->setSmtp ( Yii::app()->params['smtp_server'],
									Yii::app()->params['smtp_address'], Yii::app()->params['smtp_password'],
									Yii::app()->params['smtp_port'], Yii::app()->params['smtp_secure']);

				$email->subject=Yii::t('lan','Registration ?').' - '.Yii::app()->params['emailFrom'];

				$email->message=$this->renderPartial(
									'../email/confirmregistration',
									array('model'=>$model,'code'=>$code),
									true);
				$email->send($email->subject,$email->message);
				unset($email);$email=array();

				//Now notify Admin
				if (Yii::app()->params['NotifyAdminOnRegistration'])
				{
					$admin_mail=Yii::app()->WB_Email;
					$admin_mail->init() ;
					$admin_mail->setFrom ( Yii::app()->params['adminEmail'],Yii::app()->params['emailFrom']);
					$admin_mail->addRecipient (Yii::app()->params['adminEmail'], Yii::app()->params['emailFrom']);

					$admin_mail->setSmtp ( Yii::app()->params['smtp_server'],
									Yii::app()->params['smtp_address'], Yii::app()->params['smtp_password'],
									Yii::app()->params['smtp_port'], Yii::app()->params['smtp_secure']);
					$admin_mail->subject=Yii::t('lan','User Registration Admin Notification.').' - '.Yii::app()->params['emailFrom'];

					$admin_mail->message=$this->renderPartial(
									'../email/adminnotifyregistration',
									array('model'=>$model,'code'=>$code),
									true);

					$admin_mail->send($admin_mail->subject,$admin_mail->message);
					unset($admin_mail);$admin_mail=array();
				}

				Yii::app()->user->setFlash('message',Yii::t('lan','Thank you for registration but you have to confirm your email. You\'ll receive an email with instructions on the next step.'));

			}
			else
				Yii::app()->user->setFlash('message',Yii::t('lan','Thank you for registration. You can login with your username and password.'));

			$model->password=md5($model->password);
			$model->save();
			$this->redirect(Yii::app()->homeUrl);
		}
        }
        $this->pageTitle=Yii::t('lan','Registration');
        $this->render('registration',array('model'=>$model));
    }

    /**
     * Lost password.
     */
    public function actionLostpass()
    {
        if(isset($_GET['code']))
        {
		$user=User::model()->find('passwordLost=:passwordLost',array(':passwordLost'=>$_GET['code']));
		if($user===null)
			throw new CHttpException(404,'The requested page does not exist.');
		//Generate a new password for print_r($user->username);
		$user->passwordLost='';
		$password=User::getRIN();
		$user->password=md5($password);
		$user->save();
	   //
		$flashmessage= Yii::t('lan','Your password has been updated. Your username: {username} Your new password: {password}',array('{username}'=>$user->username,'{password}'=>$password));
		$flashmessage .= '&nbsp;'. CHtml::image(Yii::app()->theme->baseUrl."/images/close.gif",
										Yii::t('lan',  'close' ) , array("id"=>"close_btn", "title"=>Yii::t('lan',  'Click to close message.' ) )
												);
		Yii::app()->user->setFlash('message',$flashmessage);
		// here I could send again email with new password
		$this->redirect(Yii::app()->homeUrl);
        }

	//Then sends him a email
        $model=new User;
        if(isset($_POST['User']))
        {
		$model->attributes=$_POST['User'];
		if($model->validate('lostpass'))
		{
			$user=User::model()->find('username=:username',array(':username'=>$model->usernameoremail));
			if($user===null)
				$user=User::model()->find('email=:email',array(':email'=>$model->usernameoremail));
			$user->passwordLost=$code=User::getRIN();
			$user->save();
				$email=Yii::app()->WB_Email;

				$email->setFrom ( Yii::app()->params['adminEmail'],Yii::app()->params['emailFrom']);

				$search = array ( '{name}', '{email}' );
				$replace = array ( 'My name', 'myemail@mydomain.com' );
				$email->addRecipient ($user->email,$user->username );

				// Retrieve params that are stored in DB:Config
				Yii::app()->params['smtp_server']	=Yii::app()->config->get('smtp_server');
				Yii::app()->params['smtp_address']=Yii::app()->config->get('smtp_address');
				Yii::app()->params['smtp_username']=Yii::app()->config->get('smtp_username');
				Yii::app()->params['smtp_password']=Yii::app()->config->get('smtp_password');
				Yii::app()->params['smtp_port']	=Yii::app()->config->get('smtp_port');		//587
				Yii::app()->params['smtp_secure']	=Yii::app()->config->get('smtp_secure'); 	//secure

				//      Adding this line will force the emailer to use smtp for authentication,
				//      otherwise it will use sendmail or the mail function
				$email->setSmtp ( Yii::app()->params['smtp_server'],
									Yii::app()->params['smtp_address'], Yii::app()->params['smtp_password'],
									Yii::app()->params['smtp_port'], Yii::app()->params['smtp_secure']);

				$email->subject=Yii::t('lan','Lost password ?').' - '.Yii::app()->params['emailFrom'];

				$email->message=$this->renderPartial(
									'../email/lostpass',
									array('model'=>$user,'code'=>$code),
									true);
				$email->send($email->subject,$email->message);
				unset($email);$email=array();

				$flashmessage=Yii::t('lan','You\'ll receive an email with instructions on the next step.');
				$flashmessage .= '&nbsp;'. CHtml::image(Yii::app()->theme->baseUrl."/images/close.gif",
										Yii::t('lan',  'close' ) , array("id"=>"close_btn", "title"=>Yii::t('lan',  'Click to close message.' ) )
												);
				Yii::app()->user->setFlash('message',$flashmessage);
				$this->redirect(Yii::app()->homeUrl);
		}
	}

        $this->pageTitle=Yii::t('lan','Lost password ?');
        $this->render('lostpass',array('model'=>$model));
    }


    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'show' page.
     */
    public function actionUpdate()
    {
        $model=$this->loadUser();
        if(isset($_POST['User']))
        {
		$model->attributes=$_POST['User'];
// var_dump($_POST['User']);echo "<br/>";
// var_dump($model->attributes);echo "<br/>";
		if($model->password && $model->validate())
			$model->password=md5($model->password);
		elseif(!$model->password)
			unset($model->password);
		// special treatment for admin
		if($model->id==1)
			$model->banned=User::BANNED_NO;

		$model->avatar=CUploadedFile::getInstance($model,'avatar');
/*echo $model->avatar."<br/>";*/
		if($model->avatar && $model->validate())
		{
			$imagename=User::getRIN().'.'.$model->avatar->getExtensionName();
			$image=Yii::app()->image->load($model->avatar->getTempName());
			$image->resize(Yii::app()->params['avatarWidth'],Yii::app()->params['avatarHeight']);
			$image->save(Yii::app()->params['avatarPath'].$imagename);
			$model->avatar=$imagename;
			@unlink(Yii::app()->params['avatarPath'].User::model()->findbyPk($model->id)->avatar);
		}
		else unset($model->avatar);

/*var_dump($model->attributes);echo "<br/>";*/
		if($_POST['avatar'])
		{
			@unlink(Yii::app()->params['avatarPath'].User::model()->findbyPk($model->id)->avatar);
			$model->avatar='';
		}
// var_dump($_POST);
// var_dump($model->attributes);echo "<br/>";
		if($model->save())
		{
			$flashmessage= Yii::t('lan','Account updated');
			$flashmessage .= '&nbsp;'. CHtml::image(Yii::app()->theme->baseUrl."/images/close.gif",
										Yii::t('lan',  'close' ) , array("id"=>"close_btn", "title"=>Yii::t('lan',  'Click to close message.' ) )
												);
			Yii::app()->user->setFlash('message',$flashmessage);

			$this->redirect(array('user/update','id'=>$model->id));
		}
	}
        if($model->id==Yii::app()->user->id) $this->pageTitle=Yii::t('lan','My account');
        else $this->pageTitle=Yii::t('lan','Update User');

        $this->render('update',array('model'=>$model));
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
            if($_GET['id']!=1)
            {
                @unlink(Yii::app()->params['avatarPath'].User::model()->findbyPk($_GET['id'])->avatar);
                $this->loadUser()->delete();
            }
            $this->redirect(array('list'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionList()
    {
        $criteria=new CDbCriteria;

        $pages=new CPagination(User::model()->count($criteria));
        $pages->pageSize=self::PAGE_SIZE;
        $pages->applyLimit($criteria);

        $models=User::model()->findAll($criteria);

        $this->pageTitle=Yii::t('lan','Users List');
        $this->render('list',array(
            'models'=>$models,
            'pages'=>$pages,
        ));
    }

    /**
     * Lists all bookmarks.
     */
    public function actionBookmarks()
    {
        $criteria=new CDbCriteria;

        $pages=new CPagination(User::model()->count($criteria));
        $pages->pageSize=Yii::app()->params['postsPerPage'];
        $pages->applyLimit($criteria);

	 $models=$this->loadUser(Yii::app()->user->id);

        $this->render('bookmarks',array(
            'models'=>$models->bookmarks,
            'pages'=>$pages,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
     */
    public function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null || isset($_GET['id']))
                $this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    /**
     * Change banned with AJAX.
     */
    public function actionAjaxBanned()
    {
        $model=$this->loadUser();
        $options=User::getBannedOptions();
        $model->banned=(count($options)==($model->banned+1))?0:($model->banned+1);
        if($model->id==1)
            $model->banned=User::BANNED_NO;
        $model->save();
        echo $model->bannedText;
    }

	/**
	* User Login.
	* If login is successful, the browser will be redirected to the 'home' page.
	*/
	public function actionLogin()
	{
		//why ask login if you're not a guest huh !!
		if (!Yii::app()->user->isGuest)
		{
			$model=$this->loadUser(Yii::app()->user->getId());
			$model->lastlogin=time();
			$model->save();
 			$this->redirect(Yii::app()->homeUrl);
		}
		else
		{
			$form=new LoginForm;
			if(isset($_POST['LoginForm']) && isset($_POST['loginController']))
			{
				$form->attributes=$_POST['LoginForm'];
				if($form->validate())
				{
	 			$this->redirect(Yii::app()->homeUrl);
				}
			}
			$this->pageTitle=Yii::t('lan','Login');
			$this->render('login',array('model'=>$form));
		}
	}

    public function actionLogout()
	{

		if(isset($_POST['command']) && $_POST['command']==='logout')
		{
			Yii::app()->user->logout();
			$this->redirect(Yii::app()->homeUrl);
		}
		if(!Yii::app()->user->isGuest)
			$model->title=CHtml::encode(Yii::app()->user->username);
			$this->pageTitle=Yii::t('lan','Logout');
		$this->render('../user/logout');
	}

	/**
	* Executes any command triggered on the admin page.
	*/
	public function actionsetlang()
	{

		$app = Yii::app();
		if (isset($_POST['_lang']))
		{
		$app->language = $_POST['_lang'];
		$app->session['_lang'] = $app->language;
		}
		else if (isset($app->session['_lang']))
		{
		$app->language = $app->session['_lang'];
		}

		if (isset($_SERVER['HTTP_REFERER']))
			//goes back to the page that initiated the chage of language
			$this->redirect($_SERVER['HTTP_REFERER']);
		else $this->redirect(Yii::app()->homeUrl);

	}

	/**
	* Executes any command triggered on the admin page.
	*/
	public function actiondownload()
	{

		if(isset($_GET['name']))
		{
		$downloadfilename=$_GET['name'];

		// is there an associated downloadable  file ?
			if (strlen($downloadfilename)>0 )
			{
				$history=new History;
				$history->file=$downloadfilename;
				if(isset($_POST['downloadfrom']))
					$history->category=$_POST['downloadfrom'];
				else $history->category='DOWNLOAD_PUBLIC';
				if ($history->validate())
					$history->save();

				$d_downloadurl=Yii::app()->baseUrl.'/uploads/'.Yii::app()->params['sitefileName'].'/'.$downloadfilename;
				$d_loaderpathname=Yii::app()->lib_tools->get_downloader();
				$d_loaderFullUrl =$d_loaderpathname.'?filename='.$downloadfilename;
				$this->redirect($d_loaderFullUrl);
			} // end downloadable
		}
	}
}
