<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Phd Programmes Controller
 *
 */
class PhdControllerApplicants extends JController
{
	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display()
	{
		JRequest::setVar( 'layout', 'raw' );
		JRequest::setVar( 'view', 'applicants' );

		parent::display();
	}

}
?>