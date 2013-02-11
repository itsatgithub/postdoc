<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Applicants Controller
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */
class PhdControllerApplicants extends JController
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

	function delete()
	{
		//get data from the request
		$get = JRequest::get( 'get' );
		$id = $get['id'];

		$model = $this->getModel( 'applicant' );
		if( $model->delete( $id ) ) {
			$msg = JText::_('APPLICANT_DEL_OK');
		} else {
			$msg = JText::_('APPLICANT_DEL_KO');
		}
		$this->setRedirect(JRoute::_('index.php?option=com_phd&view=applicants', false), $msg);
	}
}
?>