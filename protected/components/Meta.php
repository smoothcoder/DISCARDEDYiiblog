<?php

class Meta  extends Portlet
{
    public $title='Meta';

    protected function renderContent()
    {
        $this->title=Yii::t('lan',$this->title);
        $this->render('meta');
    }
}
