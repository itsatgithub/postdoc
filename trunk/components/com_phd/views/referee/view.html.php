<?php
/**
 * Applicant View HTML file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// no direct access
//defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');


/**
 * HTML View class for the PhD component Applicant view
 */
class PhdViewReferee extends JView
{

	/**
	 * Display view
	 *
	 * @since 1.5
	 */
	function display($tpl = null)
	{
		global $mainframe, $option;

		// Get some objects
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();

		$get = JRequest::get( 'get' );

		$query = "SELECT a.*, r.id AS referee_id"
		. " FROM `#__phd_applicants` AS a"
		. " LEFT JOIN `#__phd_referees` AS r"
		. " ON a.id=r.applicant_id"
		. " WHERE r.upload_code ='".$get['upload_code']."'"
		. " AND  (r.filename IS NULL OR r.filename LIKE '') "
		;

		$db->setQuery($query);
		$applicant = $db->loadObject();

		if (!$applicant->id){
			echo JText::_( 'NON_EXISTING_CODE' );
			return;
		}

		$applicant = JRequest::getVar( 'applicant', $applicant );

		$this->assignRef('applicant', $applicant);
		$this->assign('action', $uri->toString());

		parent::display($tpl);
	}
}
?>