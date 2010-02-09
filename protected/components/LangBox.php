<?php
class LangBox extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language;
        $this->render('langBox', array('currentLang' => $currentLang));
	//print_r($viewFile=$this->getViewPath());
    }
}