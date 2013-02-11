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
class IrbtoolsControllerFilemanager extends JController
{
	function send()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// get the data
		$model =& $this->getModel('filemanager');
		$data = $model->getData();
		
		// excepciones
		$exceptions_model =& JModel::getInstance( 'exceptions', 'irbtoolsmodel' );
		$lines = $exceptions_model->getFullData();
		
		$irbpeopleFile = JHTML::_('irbtoolshelper.getIrbpeopleFile', $data, $lines);

		// making the file
		$filename = JPATH_SITE.DS.'tmp'.DS.'irbpeople_'.date("Ymd").'.csv';
		JFile::write($filename, $irbpeopleFile);	
				
		// sending the email
		$mailer =& JFactory::getMailer();
		$sender = array( 'roberto.bartolome@irbbarcelona.org', 'Roberto Bartolome' );
		$mailer->setSender($sender);
		$recipient = array( 'alvaro.cornago@biko2.com', 'cristina.mendez@irbbarcelona.org', 'ocer@irbbarcelona.org', 'its@irbbarcelona.org' );
		//$recipient = array( 'roberto.bartolome@irbbarcelona.org' );
		$mailer->addRecipient($recipient);		
		$mailer->setSubject('Data from IRBPeople');		
        $body = 'Please find attached to this mail the IRBpeople data file.';
		$mailer->setBody($body);
		$mailer->addAttachment($filename);		
		$send =& $mailer->Send();
		// delete the file
		JFile::delete($filename);		
		
		if ( $send !== true ) {
			$msg = JText::_('SEND_KO');
			$this->setRedirect('index.php?option=com_irbtools&view=filemanager', $msg);
		} else {
			$mainframe->enqueueMessage( JText::_('SEND_OK') );
			JRequest::setVar('view', 'filemanager' );
			parent::display();
		}
	}
}

?>