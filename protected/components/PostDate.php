<?php
   /*  @version $Id: PostDate.php 5 2009-02-22 11:37:40Z choco.moca.colon $
   *     example of use with php formats: 'M' is short month (Dec) , 'F' is long month (December)
   *  $this->widget('PostDate', array('ct'=>date($p.'M'.$p.'<\b\r>j', $post->createTime)));
  */
class PostDate extends Portlet {
  public $cssClass='postdate';
  public $ct;

  protected function renderContent()
  {
    //echo "<center><font size=\"3\">\n";
    print $this->ct;
    //echo "</font></center>\n";
  }
}
