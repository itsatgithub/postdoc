<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

jimport( 'joomla.filesystem.file' );

/**
 * Exception Controller
 *
 * @package		Joomla
 * @subpackage	Irbtools
 */
class IrbtoolsControllerPrivatefiles extends JController
{
	function send()
	{
		global $mainframe;

		// Check for request forgeries
		//JRequest::checkToken( 'get' ) or jexit( 'Invalid Token' );

		$params =& $mainframe->getParams();
		$filesFolder = $params->get('irbtoolsConfig_PrivateFilesFolder');
		
		$user =& JFactory::getUser();
		
		//get data from the request
		$filename = JRequest::getVar( 'filename' );
		$userCode = substr($filename, 0, 5);
		
		// complete path
		$filename = $filesFolder.DS.$filename;
				
		// busco el usuario en el directorio
		$edir = ldap_connect("irbsvr4.irb.pcb.ub.es");
		$ldaprdn  = 'cn=admin,o=irbbarcelona';
		$ldappass = 'irbbarcelona';  // associated password
    	$edir_bind = ldap_bind($edir, $ldaprdn, $ldappass);   	
    	$filter = "(&(objectclass=organizationalPerson)(IRB-UserCode=" . $userCode . "))"; 
    	$edir_sr = ldap_search($edir, "o=irbbarcelona", $filter);
    	$info = ldap_get_entries($edir, $edir_sr);

    	if ($info["count"] != 1)
	    {
	    	$mainframe->redirect('index.php?option=com_irbtools&view=privatefiles', JText::_('USER_DIRECTORY_KO'));    		
	    }

	    $mailAddress = $info[0]['mail'][0];
		
		// sending the email
		$mailer =& JFactory::getMailer();
		$sender = array( 'its@irbbarcelona.org', 'its' );
		$mailer->setSender($sender);
		$recipient = array( $mailAddress );
		//$recipient = array( 'roberto.bartolome@irbbarcelona.org' );
		$mailer->addRecipient($recipient);		
		$mailer->setSubject( JText::_('PRIVATEFILES_MAIL_SUBJECT') );		
		$mailer->setBody( JText::_('PRIVATEFILES_MAIL_BODY') );
		$mailer->addAttachment($filename);		
		$send =& $mailer->Send();
		
		if ( $send !== true ) {
			$msg = JText::_('SEND_KO');
			$this->setRedirect('index.php?option=com_irbtools&view=privatefiles', $msg);
		} else {
			$msg = JText::_('SEND_OK');
			$this->setRedirect('index.php?option=com_irbtools&view=privatefiles', $msg);
			/*
			$mainframe->enqueueMessage( JText::_('SEND_OK') );
			JRequest::setVar('view', 'privatefiles' );
			parent::display();
			*/
		}
	}
}

?>