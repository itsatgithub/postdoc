<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * PhD Controller
 *
 * @package		Joomla
 * @subpackage	Phd
 * @since 1.5
 */

class PhdControllerPhd extends JController
{

	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display()
	{
		// Make sure we have a default view
		if( !JRequest::getVar( 'view' )) {
			JRequest::setVar('view', 'applicants' );
		}
		parent::display();
	}

}

?>