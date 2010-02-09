<?php

Yii::import('application.extensions.akismet.Akismet');

/**
 * Description of CImageComponent
 *
 * @author Administrator
 */
class CAkismetComponent
{
	/**
	* @var string
	*/
	public $AkismetPath;
	public $akismet_connectivity_time = 3600;
	public $akismet_available_servers = '';
	public $blogURL;
	public $wordPressAPIKey;
	/**
	* @var array
	*/
	public $params = array();

	/**
	* Init method for the application component mode.
	*/
	public function init()
	{
		/*
		*    $akismet->setCommentAuthor($name);
		*    $akismet->setCommentAuthorEmail($email);
		*    $akismet->setCommentAuthorURL($url);
		*    $akismet->setCommentContent($comment);
		*    $akismet->setPermalink('http://www.example.com/blog/alex/someurl/');
		*    if($akismet->isCommentSpam())
		*      // store the comment but mark it as spam (in case of a mis-diagnosis)
		*    else
		*      // store the comment normally
		*/
	}


	/**
	 *     Constructor. Here the instance of Akismet is created.
	 */
	public function __construct()
	{
		//      set a default path
		$this->AkismetPath = realpath ( dirname ( __FILE__ ) ).DIRECTORY_SEPARATOR.'../akismet/'.DIRECTORY_SEPARATOR;
	}

	//***************************************************************************
	// Setters and getters
	//***************************************************************************

	/**
	* Setter
	*
	* @param string $value pathLayouts
	*/
	public function setPathLayouts($value)
	{
	if (!is_string($value) && !preg_match("/[a-z0-9\.]/i"))
		throw new CException(Yii::t('WB_Email', 'pathLayouts must be a Yii alias path'));
	$this->pathLayouts = $value;
	}

	/**
	* Getter
	*
	* @return string pathLayouts
	*/
	public function getPathLayouts()
	{
	return $this->pathLayouts;
	}


	// Check the server connectivity and store the results in an option.
	// Cached results will be used if not older than the specified timeout in seconds; use $cache_timeout = 0 to force an update.
	// Returns the same associative array as akismet_check_server_connectivity()
	// Matt
	public function akismet_get_server_connectivity( $cache_timeout = 86400 ) {
		$servers = $this->akismet_available_servers;
		if ( (time() - $this->akismet_connectivity_time < $cache_timeout) && $servers !== false )
			return $servers;

		// There's a race condition here but the effect is harmless.
		$servers = $this->akismet_check_server_connectivity();
		 $this->akismet_available_servers = $servers ;
		$this->akismet_connectivity_time = time();
		return $servers;
	}

	public function akismet_check_server_connectivity() {
		global $akismet_api_host, $akismet_api_port, $wpcom_api_key;
// 		 $akismet = new Akismet($this->params['HTTPHOST'], $this->params['APIKEY']);
		 $akismet = new Akismet($this->blogURL, $this->wordPressAPIKey);

		$test_host = 'rest.akismet.com';

		$ips = gethostbynamel($test_host);
		if ( !$ips || !is_array($ips) || !count($ips) )
			return array();

		$servers = array();
		foreach ( $ips as $ip ) {

		if($akismet->isKeyValid()) {
			$servers[$ip] = true;
			}
		else {$servers[$ip] = false;
			}
		}

		return $servers;
	}

	public function is_spam($comment)
	{
		$akismet = new Akismet($this->blogURL, $this->wordPressAPIKey);
		$akismet->setCommentAuthor($comment->authorName);
		$akismet->setCommentAuthorEmail($comment->email);
		$akismet->setCommentAuthorURL($comment->url);
		$akismet->setCommentContent($comment->content);
		$akismet->setPermalink('');
// print_r($akismet->comment['user_ip']);echo "§<br/>";

		if($akismet->isCommentSpam())
			$comment->spam=Comment::COMMENT_IS_SPAM;
		else
			$comment->spam=Comment::COMMENT_NOT_SPAM;
	//let's take this opportunity ...
		$comment->authorIP=$akismet->comment['user_ip'];
		return ($comment);
	}


}
?>
