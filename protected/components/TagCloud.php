<?php

class TagCloud extends Portlet
{
    public $title='Tags';

    public function getTagWeights()
    {
        return Tag::model()->findTagWeights();
    }

    protected function renderContent()
    {
        $this->title=Yii::t('lan',$this->title);
        $this->render('tagCloud');
    }
}
