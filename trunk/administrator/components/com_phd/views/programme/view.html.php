<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * Programme View class for the Phd component
 *
 */
class PhdViewProgramme extends JView
{
	function display($tpl = null)
	{
		$model =& JModel::getInstance( 'programme', 'phdmodel' );

		// set the id. 0 = new
		$id = JRequest::getVar('id');
		if (!$id) {
			$id = 0;
		}

		// set the id
		$model->setId( $id );

		// Get data from the model
		$item =& $model->getData();

		$this->assignRef('item', $item);
		parent::display($tpl);
	}
}
