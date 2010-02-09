<?php

class SiteSearch extends Portlet {

    public $title='Site Search';

    public function renderContent() {
        $form=new SiteSearchForm;
        if(isset($_POST['LoginForm']))
        {
            $form->attributes=$_POST['LoginForm'];
            if($form->validate())
                $this->controller->refresh();
        }
        $this->title=Yii::t('lan',$this->title);
        $this->render('siteSearch', array('form'=>$form));
    }
}

