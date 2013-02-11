<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Gmail Controller
 *
 * @package		Joomla
 * @subpackage	Irbtools
 */
class IrbtoolsControllerGmail extends JController
{

	/**
	 * Display data
	 *
	 * @param None
	 * @return None
	 */
	function display()
	{
	    // Set the view and the model
	    $view = JRequest::getVar( 'view', 'gmail' );
	    $layout = JRequest::getVar( 'layout', 'default' );
	    $view =& $this->getView( $view, 'html' );
	    $model =& $this->getModel( 'gmail' );
	    $view->setModel( $model, true );
	    $view->setLayout( $layout );
	    
	    // Display the revue
	    parent::display();
	}

	/**
	 * Create the account on Gmail
	 * 
	 * @param None
	 * @return None
	 */
	function createAccount()
	{
		global $mainframe;
		
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// get data from the request
		$post = JRequest::get('post');
		
		// get params
		$params =& JComponentHelper::getParams( 'com_irbtools' );
    	$emailSubject = $params->get( 'irbtoolsConfig_EmailSubject', '' );
    	$emailBody = $params->get( 'irbtoolsConfig_EmailBody', '' );
		
		// busco el usuario en el directorio
		$edir = ldap_connect("irbsvr4.irb.pcb.ub.es");
		$ldaprdn  = 'cn=admin,o=irbbarcelona';
		$ldappass = 'irbbarcelona';  // associated password
    	$edir_bind = ldap_bind($edir, $ldaprdn, $ldappass);   	
    	$filter = "(&(objectclass=organizationalPerson)(givenName=" . $post['name'] . ")(sn=" . $post['surname'] . "))"; 
    	$edir_sr = ldap_search($edir, "o=irbbarcelona", $filter);
    	$info = ldap_get_entries($edir, $edir_sr);
		
    	if ($info["count"] != 1)
    	{
    		$mainframe->redirect('index.php?option=com_irbtools&view=gmail', JText::_('USER_DIRECTORY_KO'));    		
    	}
    	
		// modifico los atributos de IRB-Email, mail, IRB-PasswordInicial
		$new = array();
		$new["IRB-Email"] = "true";
		$new["mail"] = $post['username'] . '@irbbarcelona.org';
		$new["IRB-PasswordInicial"] = $post['password'];
		$dn = $info[0]['dn'];
		ldap_modify($edir, $dn, $new); 
		
    	// cierro la conexión con eDir
    	ldap_close($edir);
		
		// store data. the function returns the saved id
		$model =& $this->getModel('gmail');
		$result = $model->createAccount($post['username'], $post['name'], $post['surname'], $post['password']);

		if ($result)
		{
			$mailer =& JFactory::getMailer();
			$config =& JFactory::getConfig();
			$sender = array( 
			    $config->getValue( 'config.mailfrom' ),
			    $config->getValue( 'config.fromname' ) );
			 
			$mailer->setSender($sender);
			$recipient = array( 'cristina.mendez@irbbarcelona.org', 'its@irbbarcelona.org' );
			$mailer->addRecipient($recipient);
			$mailer->addCC('its@irbbarcelona.org');
			$mailer->addReplyTo('its-support@irbbarcelona.org');
			$mailer->setSubject($emailSubject . " " . $post['name'] . " " . $post['surname']);

			// content
			$mailmsg = $emailBody;			
			// replacement
			$p1 = array("#name", "#username", "#password",  "#uid");
			$p2 = array($post['name'], $post['username'], $post['password'], $info[0]['uid'][0]);
			$mailmsg = str_replace($p1, $p2, $mailmsg);					
			$mailer->setBody($mailmsg);
			
			$send =& $mailer->Send();			
			if ( $send )
			{
				// writing the log table
				$logarray = array();
				$logarray['text'] = $post['name'] . '-' . $mailmsg;
				$logmodel =& $this->getModel('emaillog');
				$logmodel->store($logarray);
						
				// redirecting
				$mainframe->redirect('index.php?option=com_irbtools&view=gmail', JText::_('CREATE_ACCOUNT_OK'));				
			}
		} else {
			$mainframe->redirect('index.php?option=com_irbtools&view=gmail', JText::_('CREATE_ACCOUNT_KO'), 'error');
		}
	}
}

?>