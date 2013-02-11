<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * The table to store the programmes choosen by the applicant
 *
 * @package PhD Programme
 */
class TableApplicantprogramme extends JTable
{
	var $id = null;
	var $applicant_id = null;
	var $programme_id = null;
	var $order = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__phd_applicant_programme', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		return true;
	}
}
?>