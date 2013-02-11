<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');

/**
 * Applicant Controller
 *
 * @package		Joomla
 * @subpackage	Science
 */
class PhdControllerReferee extends JController
{

	/**
	 * Display data
	 *
	 * @since	1.5
	 */
	function display() {
		parent::display();
	}

	/**
	 * Save file data
	 *
	 * @since	1.5
	 */
	function upload_file() {
		global $mainframe;
		$params =& $mainframe->getParams();

		$phdConfig_DocsPath = $params->get('phdConfig_DocsPath');

		//get data from the request
		$post = JRequest::get( 'post' );

		$file = JRequest::getVar('uploaded_file', '', 'FILES', 'array');
		$file['name']  = JFile::makeSafe($file['name']);
		$filepath = JPath::clean(JPATH_ROOT.DS.$phdConfig_DocsPath.DS.$post['id'].DS.$file['name']);

		if (JFile::exists($filepath)) {
			echo JText::_('FILE_EXISTS');
			return;
		}

		if (!JFile::upload($file['tmp_name'], $filepath)){
			//handle failed upload
			return;
		}

		$model =& $this->getModel('applicant');
		$data['filename'] = $file['name'];
		$data['id'] = $post['referee_id'];
		$model->saveReferee($data);

		if ($model->saveReferee($data)) {
			$mainframe->enqueueMessage( JText::_('THANKS_UPLOAD') );
			return;
		} else {
			$mainframe->enqueueMessage( JText::_('ERROR_UPLOAD') );
			return;
		}
	}

	/**
	 * Send Mail to a referee
	 *
	 * @return bool True if done
	 */
	function email_referee()
	{
		global $mainframe;
		$params =& $mainframe->getParams();

		//get data from the request
		$get = JRequest::get( 'get' );
		$applicant_id = $get['id'];
		$referee_id = $get['referee_id'];

		$model =& $this->getModel('applicant');
		$model->setId( $applicant_id );
		$applicant =& $model->getData();

		$now = JFactory::getDate();

		//Get mails from referees and sent email to them
		foreach($applicant->referees as $referee)
		{
			// this condition has been added to allow to send an email just to one referee
			if ($referee->id == $referee_id)
			{
				$message = new stdClass();
				$message->subject = $params->get('phdConfig_EmailRefereeSubject');
				$message->body = $params->get('phdConfig_EmailRefereeBody');
				$message->body = str_replace("#referee#", $referee->firstname . " " . $referee->lastname, $message->body);
				$message->body = str_replace("#name#", $applicant->firstname . " " . $applicant->lastname, $message->body);
				$link = 'index.php?option=com_phd&view=referee&upload_code=' . $referee->upload_code;
				$myurl = $params->get('phdConfig_LiveSite') . JRoute::_( $link );
				//$message->body = str_replace("#link#", "<a href='" . $myurl . "'>link</a>", $message->body);
				$message->body = str_replace("#link#", $myurl, $message->body);
				
				$mailer =& JFactory::getMailer();
				$mailer->setSender(array($params->get('phdConfig_AdminEmail'), $params->get('phdConfig_AdminName')));
				$mailer->setSubject($message->subject);
				$mailer->setBody($message->body);
				$mailer->IsHTML(1);

				// Add recipients
				$mailer->addRecipient($referee->email);
				// 8/3/2011 A copy is sent to the applicant
				// 29/9/2011 Roberto. Elimino el envio de la copia al applicant
				//$mailer->addCC($applicant->email);
				
				// BCC to the administrator if configured
				if ($params->get('phdConfig_SendBCC')) {
					$mailer->addBCC($params->get('phdConfig_AdminEmail'));
				}

				if ($mailer->Send())
				{
					// saving the log file register
					$log_model =& $this->getModel('log');
					$logdata = array();
					$logdata['applicant_id'] = $applicant_id;
					$logdata['text'] = $message_text;
					$logdata['old_status_id'] = '1';
					$logdata['new_status_id'] = '2';
					/*$auxlog = $log_model->store($logdata);
					 if (!$auxlog) {
						$msg = JText::_('LOG_STORE_KO');
						$this->setRedirect('index.php?option=com_phd', $msg);
						}*/
						
					$data['id'] = $referee->id;
					$data['sent_mail']= $now->toMySQL();
					$model->saveReferee($data);
						
					// the following code is added to allow to send an email just to one referee
					$mainframe->enqueueMessage( JText::_('MAIL_CORRECTLY_SEND') );
					JRequest::setVar('view', 'applicant' );
					JRequest::setVar('id', $applicant_id );
					JRequest::setVar('active_tab', '3' );
					parent::display();
						
				} else {
					$msg = JText::_('MAIL_UNCORRECTLY_SEND');
					$this->setRedirect('index.php?option=com_phd', $msg);
				}
			}
		}

		/* Commented when sending to just one referee
		 if ($store) {
			$mainframe->enqueueMessage( JText::_('SUBMIT_OK') );
			JRequest::setVar('view', 'applicant' );
			JRequest::setVar('id', $applicant_id );
			JRequest::setVar('active_tab', '3' );
			parent::display();
			} else {
			$msg = JText::_('SUBMIT_KO');
			$this->setRedirect('index.php?option=com_phd', $msg);
			}
			*/

		return true;
	}
}
?>