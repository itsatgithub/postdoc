<?php
/**
 * Joomla! 1.5 component register
 *
 * @version $Id: controller.php 2009-07-07 09:14:21 svn $
 * @author
 * @package Joomla
 * @subpackage register
 * @license GNU/GPL
 *
 * Manages the registration in congresses.
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.utilities.date');

/**
 * register Component Controller
 */
class RegisterController extends JController {

	function display() {

		//get data from the request
		$post = JRequest::get( 'post' );

		if( !empty($post['id_registration']) ) {
			JRequest::setVar('registration_id', $post['id_registration'] );
		}

		// Make sure we have a default view
		if( !JRequest::getVar( 'view' )) {
			// JRequest::setVar('view', 'register' ); comentado para elegir la vista
			JRequest::setVar('view', 'registration' );
		}

		parent::display();
	}

	function save_registration() {
		global $mainframe;
		$user		=& JFactory::getUser();

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		//get data from the request
		$post = JRequest::get( 'post' );

		// store data. the function returns the saved id
		$model =& $this->getModel('registration');
		$registration_id = $model->store($post);

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();

		if ($menu_params->get('check_usedemail')) {
			//check if the email has been already used for doing a registration
			if (!$model->checkEmail($post['email'])){
				$msg = JText::_( 'This Email address has already been used for another registration.' );
				$this->setRedirect('index.php?option=com_register', $msg);
			}
		}

		if ($post['editing_registration']){
			JRequest::setVar('registration_id', $registration_id );
			$mainframe->enqueueMessage('Registration modified correctly.');
			parent::display();
			return true;
		}
		/*if (($user->gid == '25') && ($paper_id)){
			$mainframe->enqueueMessage('Registration modified correctly.');
			parent::display();
			}*/
		if ($registration_id) {
			// show the confirmation
			require_once (JPATH_COMPONENT.DS.'views'.DS.'registration'.DS.'view.html.php');
			$view = new RegisterViewRegistration();
			$view->display_confirmation($registration_id);
				
		} else {
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
		}

	}

	function confirm_registration() {

		//get data from the request
		$post = JRequest::get( 'post' );

		//if no post, get via get
		if(empty($post['id'])) {
			$post = JRequest::get( 'get' );
		}

		// store data. the function returns the saved id
		$model =& $this->getModel('registration');
		$registration_id = $model->store($post);
		if ($registration_id) {
			// show the confirmation
			require_once (JPATH_COMPONENT.DS.'views'.DS.'registration'.DS.'view.html.php');
			$view = new RegisterViewRegistration();
			$view->display_confirmation($registration_id);
				
		} else {
			$msg = JText::_( 'Error confirming the registration.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function save_confirmation() {
		global $mainframe;

		$uri =& JFactory::getURI();

		//get data from the request
		$post = JRequest::get( 'post' );
		//if no post, get via get
		if(empty($post['id'])) {
			$post = JRequest::get( 'get' );
		}

		$dateNow = new JDate();
		$post['registration_date'] = $dateNow->toMySQL();

		// store data. the function returns the saved id
		$model_r =& $this->getModel('registration');
		$registration_id = $model_r->store($post);
		//$model_r->setId($registration_id);
		$registration =& $model_r->getData();

		if ($registration_id) {
			//Get Active Congress using the model
			$model_c =& JModel::getInstance('congress', 'registermodel');
			$model_c->setId($registration->congress_id);
			$congress =& $model_c->getData();

			$link_payment = $uri->toString()."?option=com_register&task=paid_inscription&paid=1&id=".$registration_id;

			$mailer =& JFactory::getMailer();
			$sender = array($congress->email,$congress->short_name);
			$mailer->setSender($sender);

			if ($registration->payment_type_id =='1') { //Transfer
				$mainframe->enqueueMessage($congress->registration_complete_transfer_text);

				$mailer->setSubject($congress->mail_transfer_subject);

				$mail_body = $model_r->replace_values($registration_id,$congress->mail_transfer_body);
				$mailer->setBody($mail_body);

				$mailer->addRecipient($registration->email);

				if (stripos($congress->mail_transfer_additional_email, ';') !== false) {
					$additionals_mails = explode(';',$congress->mail_transfer_additional_email);
					foreach($additionals_mails as $additionals_mail){
						$mailer->addRecipient($additionals_mail);
					}
				} else {
					$mailer->addRecipient($congress->mail_transfer_additional_email);
				}

				if ($congress->debug) {
					$mainframe->enqueueMessage('Mail sent to confirm Bank Transfer.');
				} else {
					if ($mailer->Send() !== true){
						$mainframe->enqueueMessage('Error sending mail.','error');
					}
				}

			} else if ($registration->payment_type_id =='2') { //Credit Card

				$mainframe->enqueueMessage($congress->registration_complete_transfer_text);
				$mainframe->enqueueMessage('The process has finished. Now you can close both windows.');

				$post['paid'] = '1';
				$registration_id = $model_r->store($post);

				$mailer->setSubject($congress->credit_card_mail_subject);
				$mail_body = $model_r->replace_values($registration_id,$congress->credit_card_mail_body);
				$mailer->setBody($mail_body);

				$mailer->addRecipient($registration->email);

				if (stripos($congress->credit_card_additional_email, ';') !== false) {
					$additionals_mails = explode(';',$congress->credit_card_additional_email);
					foreach($additionals_mails as $additionals_mail){
						$mailer->addRecipient($additionals_mail);
					}
				} else {
					$mailer->addRecipient($congress->credit_card_additional_email);
				}

				$mailer->addRecipient($registration->email);

				if ($congress->debug) {
					$mainframe->enqueueMessage('Mail sent to confirm Credit Card.');
				} else {
					if ($mailer->Send() !== true){
						$mainframe->enqueueMessage('Error sending mail.','error');
					}
				}

			} else { //Alternative method
				$mainframe->enqueueMessage($congress->registration_complete_alt_text);

				$mailer->setSubject($congress->mail_alt_subject);

				$mail_body = $model_r->replace_values($registration_id,$congress->mail_alt_body);
				$mailer->setBody($mail_body);

				$mailer->addRecipient($registration->email);

				if (stripos($congress->mail_alt_additional_email, ';') !== false) {
					$additionals_mails = explode(';',$congress->mail_alt_additional_email);
					foreach($additionals_mails as $additionals_mail){
						$mailer->addRecipient($additionals_mail);
					}
				} else {
					$mailer->addRecipient($congress->mail_alt_additional_email);
				}

				if ($congress->debug) {
					$mainframe->enqueueMessage('Mail sent to confirm Registration.');
				} else {
					if ($mailer->Send() !== true){
						$mainframe->enqueueMessage('Error sending mail.','error');
					}
				}
			}
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function del_registration() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get('get');
		$cid = $get['cid'];

		$model =& $this->getModel('registration');
		$model->setId($cid[0]);
		$registration =& $model->getData();

		//Modificacion solo para esta implementación, habria que recoger el numero de congreso
		JRequest::setVar('id', 1 );

		if ($model->delete($cid)) {
			$mainframe->enqueueMessage('Registration deleted correctly.');
			parent::display();
		} else {
			$msg = JText::_('Error deleting the registration.');
			$this->setRedirect('index.php?option=com_register&view=registrations', $msg);
		}
	}

	function edit_registration() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get('get');
		$cid = $get['cid'];

		JRequest::setVar('registration_id', $cid[0] );
		JRequest::setVar('editing_registration', true );

		JRequest::setVar('view', 'registration' );
		parent::display();
	}

	function email_registration()
	{
		global $mainframe;
		$params =& $mainframe->getParams();

		// get data from the request
		$get = JRequest::get('get');
		$id = $get['id'];

		// get the registrant data
		$model =& $this->getModel('registration');
		$model->setId( $id );
		$registration =& $model->getData();

		// making the message
		$message = new stdClass();
		$message->subject = "Phylofrontiers 2010 Registration Deletion";
		$message->body = "Dear colleague,<br><br>

Due to the limited capacity of the symposium venue, we cannot secure registration unless the registration fee has been paid. After ten days, we have not received your payment. Therefore, we have proceeded to delete your registration. Please, if you are still interested in attending the symposium, do register again and pay the registration fee.<br><br>

Best regards,<br>
Phylofrontiers 2010 

";

		// making the mailer
		$mailer =& JFactory::getMailer();
		$mailer->setSender(array("phylofrontiers2010@gmail.com", "Phylofrontiers 2010"));
		$mailer->setSubject($message->subject);
		$mailer->setBody($message->body);
		$mailer->IsHTML(1);
		$mailer->addRecipient($registration->email);

		//Modificacion solo para esta implementación, habria que recoger el numero de congreso
		JRequest::setVar('id', 1 );

		if ($mailer->Send())
		{
			// update the date
			$now = JFactory::getDate();
			$data = array();
			$data['id']= $id;
			$data['email_sent_date']= $now->toMySQL();
			$model->store($data);
				
			$mainframe->enqueueMessage( JText::_('MAIL_CORRECTLY_SEND') );
			JRequest::setVar('view', 'registrations' );
			parent::display();
				
		} else {
				
			$mainframe->enqueueMessage( JText::_('ERROR_SENDING_MAIL') );
			JRequest::setVar('view', 'registrations' );
			parent::display();
				
		}
	}

	function paid_inscription() {
		global $mainframe;

		//get data from the request (paid and id)
		$get = JRequest::get( 'get' );

		// store data. the function returns the saved id
		$dateNow = new JDate();
		$get['registration_date'] = $dateNow->toMySQL();

		$model =& $this->getModel('registration');
		$registration_id = $model->store($get);
		$registration =& $model->getData();

		$paid_text = ($get['paid'] == '1')?'paid':'no paid';

		if ($registration_id) {
			$mainframe->enqueueMessage($registration->firstname." ".$registration->lastname."  with id: ".$registration_id." has change his/her status to $paid_text");
			//parent::display();
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}
	}

	function save_paper_data() {
		global $mainframe;
		$params = &$mainframe->getParams();
		$menu_params =& $mainframe->getPageParameters();

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		//get data from the request
		$post = JRequest::get( 'post' );

		//Check Email has been already used
		if ($menu_params->get('check_usedemail')) {
			$model_registration =& $this->getModel('registration');
			if (!$model_registration->checkEmail($post['email'],$post['congress_id'])){
				echo JText::_( 'EMAIL_NOT_USED' );
				if (isset($post['id'])){
					JRequest::setVar('paper_id', $post['id'] );
				}
				parent::display();
				return false;
			}
		}

		//Check Abstract is not empty
		if (empty($post['abstract'])) {
			$mainframe->enqueueMessage(JText::_( 'ABSTRACT_ERROR' ),'error');
			parent::display();
			return false;
		}

		// store data. the function returns the saved id
		$model =& $this->getModel('paper');
		$paper_id = $model->store($post);

		$file = JRequest::getVar('filename','','FILES', 'array');
		$filename = JFile::makeSafe($file['name']);
		$src = $file['tmp_name'];

		$post['abstract'] = JRequest::getVar('abstract', '', 'post', 'string', JREQUEST_ALLOWHTML);

		$model_c =& JModel::getInstance('congress', 'registermodel');
		$model_c->setId($post['congress_id']);
		$congress =& $model_c->getData();


		$dest = JPATH_BASE . DS . $congress->papers_directory . DS . $paper_id.'_'.$filename;
		$old_filename = $post['old_filename'];

		if ( $menu_params->get('paper_file') ) {
			if (!empty($filename)) {
				if ($old_filename){
					if (!JFile::delete(JPATH_BASE . DS . $congress->papers_directory . DS . $paper_id.'_'.$old_filename)){
						$mainframe->enqueueMessage('Error uploading file.','error');
					}
				}
				//esborra antinc
				if (!JFile::upload($src, $dest)){
					$mainframe->enqueueMessage('Error uploading file.','error');
				}
				$post['filename'] = $filename;
			} else {
				if (!$old_filename) {
					$mainframe->enqueueMessage('Empty File.','error');
					JRequest::setVar('paper_id', $paper_id );
				}
			}
		}

		//store rest of data
		$post['id'] = $paper_id;
		$paper_id = $model->store($post);

		if ($paper_id) {
			$mainframe->enqueueMessage(JText::_( 'PAPER_STORE_OK' ));
			JRequest::setVar('paper_id', $paper_id );
			parent::display();
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function save_presenting_author() {
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		//get data from the request
		$post = JRequest::get( 'post' );

		// store data. the function returns the saved id
		$model =& $this->getModel('author');
		$presenting_author_id = $model->store($post);

		$post['presenting_author_id']=$presenting_author_id;
		$post['id'] = $post['paper_id'];
		$model_paper =& $this->getModel('paper');
		//$model_paper->setId($paper_id);
		$paper_id = $model_paper->store($post);

		if ($paper_id) {
			$mainframe->enqueueMessage(JText::_( 'PAPER_AUTHOR_STORE_OK' ));
			JRequest::setVar('paper_id', $paper_id );
			parent::display();
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function add_author() {
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		//get data from the request
		$post = JRequest::get( 'post' );

		// store data. the function returns the saved id
		$model =& $this->getModel('author');
		$author_id = $model->store($post);

		$paper_id = $post['paper_id'];

		if ($paper_id) {
			$mainframe->enqueueMessage('Author added correctly.');
			JRequest::setVar('paper_id', $paper_id );
			parent::display();
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function del_author() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get( 'get' );
		$author_id = $get['id'];
		$paper_id = $get['paper_id'];

		JRequest::setVar('editing_paper', $get['editing_paper'] );

		// store data. the function returns the saved id
		$model =& $this->getModel('author');
		$model->delete($author_id);

		if ($paper_id) {
			$mainframe->enqueueMessage(JText::_( 'AUTHOR_DELETED_OK' ));
			JRequest::setVar('paper_id', $paper_id );
			parent::display();
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function confirm_paper() {
		global $mainframe;

		$user		=& JFactory::getUser();

		//get data from the request
		$post = JRequest::get( 'post' );

		// store data. the function returns the saved id
		$model =& $this->getModel('paper');
		$paper_id = $model->store($post);
		$paper =& $model->getData();
		//$message = $model->messageConfirmation($paper_id);

		$model_c =& JModel::getInstance('congress', 'registermodel');
		$model_c->setId($paper->congress_id);
		$congress =& $model_c->getData();

		if (($user->gid == '25') && ($paper_id)){
			$mainframe->enqueueMessage(JText::_( 'PAPER_MODIFIED_OK' ));
			parent::display();
		} else if ($paper_id) {
			$mainframe->enqueueMessage(JText::_( 'PAPER_SUBMITED_OK' ));

			$mailer =& JFactory::getMailer();
			$sender = array($congress->email,$congress->short_name);
			$mailer->setSender($sender);

			$mainframe->enqueueMessage($congress->paper_completion_text);

			$mailer->setSubject($congress->paper_mail_subject);

			$mail_body = $model->replace_values($paper_id,$congress->paper_mail_body);
			$mailer->setBody($mail_body);

			$mailer->addRecipient($paper->email);

			if (stripos($congress->paper_additional_email, ';') !== false) {
				$additionals_mails = explode(';',$congress->paper_additional_email);
				foreach($additionals_mails as $additionals_mail){
					$mailer->addRecipient($additionals_mail);
				}
			} else {
				$mailer->addRecipient($congress->paper_additional_email);
			}

			if ($mailer->Send() !== true){
				$mainframe->enqueueMessage('Error sending mail.','error');
			}
			JRequest::setVar('paper_id', $paper_id );
			$mainframe->enqueueMessage('A message has been sent to the mail account provided.');
		} else {
				
			$msg = JText::_( 'Error saving your settings.' );
			$this->setRedirect('index.php?option=com_register', $msg);
				
		}

	}

	function del_paper() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get('get');
		$cid = $get['cid'];

		$model =& $this->getModel('paper');
		$model->setId($cid[0]);
		$paper =& $model->getData();

		$model_c =& JModel::getInstance('congress', 'registermodel');
		$model_c->setId($paper->congress_id);
		$congress =& $model_c->getData();

		if($paper->filename){
			JFile::delete(JPATH_BASE . DS . $congress->papers_directory . DS . $paper->id . "_" . $paper->filename);
		}

		if ($model->delete($cid)) {
			$mainframe->enqueueMessage('Paper deleted correctly.');
			parent::display();
		} else {
			$msg = JText::_('Error deleting the paper.');
			$this->setRedirect('index.php?option=com_register&view=papers', $msg);
		}
	}

	function edit_paper() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get('get');
		$cid = $get['cid'];

		JRequest::setVar('paper_id', $cid[0] );
		JRequest::setVar('editing_paper', true );
		JRequest::setVar('view', 'paper' );

		parent::display();
	}

	function publish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to publish' ) );
		}

		$model = $this->getModel('registration');
		if(!$model->publish($cid, 1)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_register' );
	}


	function unpublish()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to unpublish' ) );
		}

		$model = $this->getModel('registration');
		if(!$model->publish($cid, 0)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_register' );
	}

}
?>