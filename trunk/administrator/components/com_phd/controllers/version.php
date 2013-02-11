<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Phd Programme Controller
 *
 */
class PhdControllerVersion extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display( )
	{
		JRequest::setVar('view' , 'version');
		parent::display();
	}

}
?>