<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Science Projects Controller
 *
 * @package		Joomla
 * @subpackage	Science
 * @since 1.5
 */
class ScienceControllerProjects extends JController
{

	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display()
	{
		// Make sure we have a default view
		if( !JRequest::getVar( 'view' )) {
			JRequest::setVar('view', 'projects' );
		}
		parent::display();
	}

	function delete()
	{
		//get data from the request
		$get = JRequest::get( 'get' );
		$id = $get['id'];

		$model = $this->getModel( 'project' );
		if( $model->delete( $id ) ) {
			$msg = JText::_('PROJECT_DEL_OK');
		} else {
			$msg = JText::_('PROJECT_DEL_KO');
		}
		$this->setRedirect(JRoute::_('index.php?option=com_science&view=projects', false), $msg);
	}
}
?>