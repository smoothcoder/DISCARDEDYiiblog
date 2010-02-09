<?php
  // @version $Id: Calendar.php 41 2009-06-20 22:46:12Z mocapapa@g.pugpug.org $
class Calendar extends Portlet
{
  public $title='Calendar';

  protected function renderContent()
  {
    // Set locale
    if (isset(Yii::app()->params['calendarLocale']) && Yii::app()->params['calendarLocale'] == 'Japan') {
      $locale='ja_JP.utf8';
      $setlocale = setlocale(LC_ALL, $locale);
    }

    // Prepare the css style within the calendar widget
    $url=CHtml::asset(Yii::getPathOfAlias('application.components.css.calendar').'.css');
    Yii::app()->getClientScript()->registerCssFile($url);

    // Previous month and next month
    if (!empty($_GET['time'])) {
      $month = date('n', $_GET['time']);
      $year = date('Y', $_GET['time']);
      if (!empty($_GET['pnc']) && $_GET['pnc'] == 'n') $month++;
      if (!empty($_GET['pnc']) && $_GET['pnc'] == 'p') $month--;
    } else {
      $month = date('n');
      $year = date('Y');
    }

    $firstDay = mktime(0,0,0,$month,1,$year);
    $firstDayNextMonth = mktime(0,0,0,$month+1,1,$year);

    $pnc = array('&lt;'=>CHtml::normalizeUrl(array('post/PostedInMonth', 'time'=>$firstDay, 'pnc'=>'p')),
		 '&gt;'=>CHtml::normalizeUrl(array('post/PostedInMonth', 'time'=>$firstDay, 'pnc'=>'n')));

    // Today
    $days = array();
    if ($firstDay <= time() && time() < $firstDayNextMonth) {
      $today = date('j', time());
      $days[$today] = array(NULL,NULL,'<span id="today">'.$today.'</span>');
    }

    // Make the links
    $post = new Post;
    foreach($post->findArticlePostedThisMonth() as $article) {
      $days[date('j', $article->createTime)] = array(CHtml::normalizeUrl(array('post/PostedOnDate', 'time'=>$article->createTime)), 'linked-day');
    }

    if (isset($locale) && $locale == 'ja_JP.utf8') $len = 3;
    else $len = 2;

    //    $url = CHtml::normalizeUrl(array('post/PostedInMonth', 'time'=>$firstDay, 'pnc'=>'c'));
    $this->render('calendar', array('year'=>$year, 'month'=>$month, 'days'=>$days, 'len'=>$len, 'url'=>'', 'pnc'=>$pnc));
  }

}
