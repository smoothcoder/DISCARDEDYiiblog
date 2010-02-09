<?php

/**
 * Generic class for sending emails
 * @author manilodisan
 *		MFM toDo or Check
 * 		$mailer->FromName = 'xxxxxxxxxxx';
		$mailer->CharSet = 'utf-8';
		$mailer->ContentType = 'text/html';
		$mailer->AddAddress($mail);
		$mailer->Subject = 'Yii rulez!';
		$mailer->GetView ('register_ok');
		$mailer->Send();
 */

class WB_Email   {

        public $phpMailerPath;

        //      TRUE/FALSE to use SMTP authentication or not
        private $_bUseSMTP = FALSE;
        //      Keeping it to TRUE, will throw exceptions if something bad
        //      happens. On FALSE, it will try to ignore errors and continue
        //      it's task
        public $bThrowExceptions = TRUE;
        //      Alternative body message for text only recipients
        public $sAltMessage = "To view the message, please use an HTML compatible email viewer!";

        //      Holds the recipients of the email
        private $_aRecipients = array ();
        //      Holds the attachments of the email, if any
        private $_aAttachments = array ();
        //      Sender's name
        private $_sFromName = null;
        //      Sender's email address
        private $_sFromEmail= null;
        //      Reply-to name
        private $_sReplyToName;
        //      Reply-to email address
        private $_sReplyToEmail;
        //      Default Smtp host
        private $_sSmtpHost;
        //      Default Smtp username
        private $_sSmtpUser;
        //      Default Smtp password
        private $_sSmtpPassword;
        //      Default Smtp port
        private $_sSmtpPort;
        //      Smtp authentication type: ssl, tls
        private $_sSmtpSecure;

        //      Sent messages counter
        private $_iSent = 0;
        //      Failed messages counter
        private $_iFailed = 0;
        //      Holds the errors
        private $_aErrors = array ();

	private $_bccemail;
	private $_bccname;
//***************************************************************************
   // Configuration
   //***************************************************************************

   /**
    * The path to the directory where the view for getView is stored. Must not
    * have ending dot.
    *
    * @var string
    */
	protected $pathViews = 'application.views.email';

   /**
    * The path to the directory where the layout for getView is stored. Must
    * not have ending dot.
    *
    * @var string
    */
	protected $pathLayouts = 'application.views.email.layouts';


   //***************************************************************************
   // Initialization
   //***************************************************************************

   /**
    * Init method for the application component mode.
    */
	public function init()
	{
		$this->_sFromName=null;
		$this->_sFromEmail=null;
		$this->_aRecipients = array ();
		$this->_aAttachments = array ();
		$this->_sReplyToName = array ();

	}

   /**
    * Constructor. Here the instance of WB_mail is created.
    */
	public function __construct ()
	{
                //      set a default path
                $this->phpMailerPath = realpath ( dirname ( __FILE__ ) ).DIRECTORY_SEPARATOR.'../mailer/phpmailer'.DIRECTORY_SEPARATOR;
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

   /**
    * Setter
    *
    * @param string $value pathViews
    */
   public function setPathViews($value)
   {
      if (!is_string($value) && !preg_match("/[a-z0-9\.]/i"))
         throw new CException(Yii::t('WB_Email', 'pathViews must be a Yii alias path'));
      $this->pathViews = $value;
   }

   /**
    * Getter
    *
    * @return string pathViews
    */
   public function getPathViews()
   {
      return $this->pathViews;
   }




        /**
         * Used to send the email. Should be called last
         * @param string $subject The email subject
         * @param string $message The email body
         * @return boolean TRUE/FALSE
         */
        public function send ( $subject, $message ) {
                if ( ! count ( $this->_aRecipients ) ) {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "No recipients found. Email failed" );
                        }
                        return FALSE;
                }

                if ( ! file_exists ( $this->phpMailerPath . 'class.phpmailer.php' ) ) {
                        throw new CException ( "PHPMailer library file not found" );
                }

                require_once ( $this->phpMailerPath . 'class.phpmailer.php' );

		$mail = array();
                $mail = new PHPMailer ( );

                if ( $this->_bUseSMTP ) {
                        $mail->IsSMTP ();
                        if ( $this->_sSmtpSecure != '' ) {
                                $mail->SMTPSecure = $this->_sSmtpSecure;
                        }
                        $mail->SMTPAuth = TRUE;
                        $mail->SMTPKeepAlive = TRUE;
                        $mail->Host = $this->_sSmtpHost;
                        $mail->Port = $this->_sSmtpPort;
                        $mail->Username = $this->_sSmtpUser;
                        $mail->Password = $this->_sSmtpPassword;
                }

                $mail->SetFrom ( $this->_sFromEmail, $this->_sFromName );

                if ( $this->_sReplyToEmail != '' && $this->isValidEmail ( $this->_sReplyToEmail ) ) {
                        $mail->AddReplyTo ( $this->_sReplyToEmail, $this->_sReplyToName );
                }

                $mail->Subject = $subject;

                foreach ( $this->_aRecipients as $aRecipient ) {
                        //      use generic or a custom method wich extracts the text from html. Default: generic message
                        $mail->AltBody = $this->sAltMessage;
                        //      sets the body, also replace tokens and other recipient defined search/replace operations
                        $mail->MsgHTML ( $this->processTokens ( $message, $aRecipient [ 'search' ], $aRecipient [ 'replace' ] ) );
                        $mail->AddAddress ( $aRecipient [ "email" ], $aRecipient [ "name" ] );

                        foreach ( $this->_aAttachments as $aAttachment ) {
                                switch ( $aAttachment [ 'type' ] ) {
                                        case 'inline' :
                                                $mail->AddStringAttachment ( $aAttachment [ "path" ] );
                                                break;
                                        default :
                                        case 'attachment' :
                                                $mail->AddAttachment ( $aAttachment [ "path" ] );
                                                break;
                                }

                        }

                        if ( $mail->Send () ) {
                                $this->_iSent ++;
                        }
                        else {
                                $this->_iFailed ++;
                                //      log the failed email and error. We may use this list to clean our mailing list
                                $this->logError ( $aRecipient [ "email" ], $mail->ErrorInfo );
                        }


			$mail->ClearAddresses ();
                        $mail->ClearAttachments ();
                }
        }

        /**
         * Adds a recipient/receiver
         * @param string $name The name of our recipient: e.g John Doe
         * If the recipient name is not provided, the email is used instead
         * @param string $email The email recipient
         * @param array $search Should we look for things to replace? Maybe some tokens, e.g. {name}, {username}
         * @param array $replace Replace values for the above searches
         * @return void
         */
        public function addRecipient ( $email, $name = FALSE, $search = array (), $replace = array () ) {
                if ( $this->isValidEmail ( $email ) ) {
                        $this->_aRecipients [ ] = array (

                                'email' => $email,
                                'name' => ( $name ) ? $name : $email,
                                'search' => $search,
                                'replace' => $replace
                        );
                }
                else {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "Email $email is not a valid recipient" );
                        }
                }
        }

        /**
         * Adds an attachment to our email
         * @param string $path Full path to our attachment file
         * @param string $type Type of attachment (attachment/inline)
         * @return void
         */
        public function addAttachment ( $path, $type = 'attachment' ) {
                if ( @file_exists ( $path ) ) {
                        $this->_aAttachments [ ] = array (

                                'path' => $path,
                                'type' => $type
                        );
                }
                else {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "Attachment at $path does not exist. Check your path" );
                        }
                }
        }

        /**
         * Sets the 'reply to' headers. The receiver of replies should be defined here
         * @param string $email The reply-to email address
         * @param string $name The reply-to name: e.g John Doe
         * If the reply-to name is not provided, the reply-to email is used instead
         * @return void
         */
        public function setReplyTo ( $email, $name = '' ) {
                if ( $this->isValidEmail ( $email ) ) {
                        $this->_sReplyToEmail = $email;
                        $this->_sReplyToName = ( $name != '' ) ? $name : $email;
                }
                else {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "Email $email is not a valid reply-to email" );
                        }
                }
        }

        /**
         * Sets the 'from' headers. The sender should be set here
         * @param string $email The sender's email address
         * @param string $name The sender's name: e.g John Doe
         * @return void
         */
        public function setFrom ( $email, $name = '' ) {
                if ( $this->isValidEmail ( $email ) ) {
                        $this->_sFromEmail = $email;
                        $this->_sFromName = ( $name != '' ) ? $name : $email;
                }
                else {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "Email $email is not a valid From email" );
                        }
                }
        }

        /**
         * Returns the number of successfully sent messages
         * @return int
         */
        public function getSentCount () {
                return ( int ) $this->_iSent;
        }

        /**
         * Returns the number of failed messages
         * @return int
         */
        public function getFailedCount () {
                return ( int ) $this->_iFailed;
        }

        /**
         * Sets the SMTP settings. If this is not set, the mailer will use sendmail or @mail
         * @param string $host SMTP host
         * @param string $user SMTP username
         * @param string $pass SMTP password
         * @param integer $port SMTP port, default 25
         * @return void
         */
        public function setSmtp ( $host, $user, $pass, $port = 25, $authType = '' ) {
                if ( $authType != '' ) {
                        $this->_sSmtpSecure = $authType;
                }
                $this->_bUseSMTP = TRUE;
                $this->_sSmtpHost = $host;
                $this->_sSmtpPort = $port;
                $this->_sSmtpUser = $user;
                $this->_sSmtpPassword = $pass;
        }

        /**
         * Search replace for tokens. Either way, should output the message body
         * @param string $message Message body
         * @param mixed $search Array of tokens. Could be added as string as well
         * @param mixed $replace Array of replacements. Should be string if search is string
         * @return void
         */
        private function processTokens ( $message, $search, $replace ) {
                if ( ( is_array ( $search ) && ! is_array ( $replace ) ) || ( is_array ( $replace ) && ! is_array ( $search ) ) || count ( $replace ) != count ( $search ) ) {
                        if ( $this->bThrowExceptions ) {
                                throw new CException ( "Tokens are not well formatted" );
                        }
                        return $message;
                }

                if ( is_array ( $search ) ) {
                        ksort ( $search );
                        ksort ( $replace );

                        foreach ( $search as $k => $v ) {
                                $search [ $k ] = '/' . preg_quote ( $v ) . '/';
                        }
                        return preg_replace ( $search, $replace, $message );
                }
                return preg_replace ( '/' . preg_quote ( $search ) . '/', $replace, $message );
        }

        /**
         * Private method for validating email addresses
         * @param string $email The email address to be validated
         * @return boolean TRUE/FALSE based on the result
         */
        private function isValidEmail ( $email ) {
                return ( ! preg_match ( "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email ) ) ? FALSE : TRUE;
        }

        /**
         * If an email fails to one of the recipients, call this function to log the error
         * We might use this to clean our mailing lists
         * @param string $email The email address associated with this error
         * @param string $error The error message
         * @return void
         */
        private function logError ( $email, $error ) {
                $this->_aErrors [ $email ] = $error;
        }

}