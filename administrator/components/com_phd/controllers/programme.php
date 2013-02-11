<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Phd Programme Controller
 *
 */
class PhdControllerProgramme extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display( )
	{
		JRequest::setVar('view' , 'programme');
		parent::display();
	}

	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$post = JRequest::get('post');
		$model = $this->getModel('programme');

		if ($model->store($post)) {
			$msg = JText::_( 'Programme Saved' );
		} else {
			$msg = JText::_( 'Error saving programme' );
		}

		$link = 'index.php?option=com_phd';
		$this->setRedirect($link, $msg);
	}

	function cancel()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$this->setRedirect( 'index.php?option=com_phd' );
	}


}
?>