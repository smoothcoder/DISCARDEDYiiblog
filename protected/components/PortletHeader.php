<?php

class PortletHeader extends Portlet
{
// 	public $title;
 	public $cssClass='portletHeader';
// 	public $headerCssClass='header';
// 	public $visible=true;

 public function init()
    {
        $this->title=Yii::t('lan',$this->title);

        if(!$this->visible)
	{
		return;
	}
        echo "<div class=\"{$this->cssClass}\">\n";
        if($this->title!==null)
	{
		echo "<div class=\"{$this->headerCssClass}\">{$this->title}</div>\n";
        }
        echo "<div class=\"{$this->contentCssClass}\">\n";

    }

// 	public function run()
// 	{
// 		if(!$this->visible)
// 			return;
// 		$this->renderContent();
// 		echo "</div><!-- {$this->cssClass} -->";
// 	}
//
// 	protected function renderContent()
// 	{
// 	}
}