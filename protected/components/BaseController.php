<?php

class BaseController extends CController
{
    function init()
    {
	// MFM CController
	parent::init();
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




	//-----------------------------
        if(!Yii::app()->user->isGuest)
        {
            $identity=new UserIdentity(Yii::app()->user->username,Yii::app()->user->password);
            $identity->authenticate(false);
            if($identity->errorCode!=ERROR_NONE)
            {
                Yii::app()->user->logout();
                Yii::app()->user->setState('status',User::STATUS_GUEST);
                $this->redirect(Yii::app()->homeUrl);
            }
        }
        else
            Yii::app()->user->setState('status',User::STATUS_GUEST);

    }




}
