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

jimport( 'joomla.application.component.controller' );
jimport( 'joomla.filsystem.folder' );

require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

/**
 * register Controller
 *
 * @package Joomla
 * @subpackage register
 */
class RegisterController extends JController {
	/**
	 * Constructor
	 * @access private
	 * @subpackage register
	 */
	function __construct() {
		//Get View
		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'congresses');
		}
		$this->item_type = 'Default';

		parent::__construct();
		$this->registerTask( 'apply',           'save');
	}

	function display( )
	{
		switch($this->getTask())
		{
			case 'add'     :
				{
					JRequest::setVar( 'hidemainmenu', 1 );
					JRequest::setVar( 'layout', 'form'  );
					JRequest::setVar( 'view'  , 'congress');
					JRequest::setVar( 'edit', false );
				} break;
			case 'edit'    :
				{
					JRequest::setVar( 'hidemainmenu', 1 );
					JRequest::setVar( 'layout', 'form'  );
					JRequest::setVar( 'view'  , 'congress');
					JRequest::setVar( 'edit', true );
				} break;
		}

		parent::display();
	}

	function save() {
		global $mainframe;
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post	= JRequest::get('post');

		//Variables how can use HTML code
		$post['description'] = JRequest::getVar('description', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['registration_text'] = JRequest::getVar('registration_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['registration_limit_text'] = JRequest::getVar('registration_limit_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['summary_transfer_text'] = JRequest::getVar('summary_transfer_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['registration_complete_transfer_text'] = JRequest::getVar('registration_complete_transfer_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['credit_card_code'] = JRequest::getVar('credit_card_code', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['credit_card_summary_text'] = JRequest::getVar('credit_card_summary_text', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['end_reception_message'] = JRequest::getVar('end_reception_message', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['paper_instructions'] = JRequest::getVar('paper_instructions', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$post['paper_completion_text'] = JRequest::getVar('paper_completion_text', '', 'post', 'string', JREQUEST_ALLOWRAW);

		$post['cost_javascript'] = JRequest::getVar('cost_javascript', '', 'post', 'string', JREQUEST_ALLOWRAW);

		//Create and/or check papers directory is ready to be write
		if ($post['papers_directory']) {
			$folder = JPATH_ROOT . DS . $post['papers_directory'];
			$cleanfolder = JFolder::makesafe($folder);
			if (!JFolder::exists($cleanfolder)){
				$mainframe->enqueueMessage('Directory does not exist, creating directory');
				if (!JFolder::create($cleanfolder, 0775)){
					$mainframe->enqueueMessage('Problem creating directory, check permissions.', 'error');
				} else {
					$mainframe->enqueueMessage('Directory created correctly');
				}
			}
		}

		$cid	= JRequest::getVar( 'cid', array(0), 'post', 'array' );
		$post['id'] = (int) $cid[0];

		$model = $this->getModel('congress');

		if ($model->store($post)) {
			$msg = JText::_( 'Congress Saved' );
		} else {
			$msg = JText::_( 'Error Saving Congress' );
		}

		// Check the table in so it can be edited.... we are done with it anyway
		//$model->checkin();

		switch ($this->_task)
		{
			case 'apply':
				$msg = JText::_( 'Changes to Congress Saved' );
				$link = 'index.php?option=com_register&view=congresses&task=edit&cid[]='. $post['id'] .'';
				break;

			case 'save':
			default:
				$msg = JText::_( 'Congress Saved' );
				$link = 'index.php?option=com_register&view=congresses';
				break;
		}

		//$link = 'index.php?option=com_register&view=congresses';
		$this->setRedirect($link, $msg);
	}


	function remove()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$cid = JRequest::getVar( 'cid', array(), 'post', 'array' );
		JArrayHelper::toInteger($cid);

		if (count( $cid ) < 1) {
			JError::raiseError(500, JText::_( 'Select an item to delete' ) );
		}

		$model = $this->getModel('congress');

		if(!$model->delete($cid)) {
			echo "<script> alert('".$model->getError(true)."'); window.history.go(-1); </script>\n";
		}

		$this->setRedirect( 'index.php?option=com_register&view=congresses' );
	}

	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_register' );
	}


}
?>