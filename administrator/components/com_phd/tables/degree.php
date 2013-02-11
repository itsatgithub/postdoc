<?php
/**
 * Applicant Table file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * The class contains the table to store degrees.
 *
 * @package PhD Programme
 */
class TableDegree extends JTable {

	var $id = null;
	var $applicant_id = null;
	var $type = null;
	var $degree = null;
	var $university = null;
	var $institution = null;
	var $start_date = null;
	var $end_date = null;
	var $country_id = null;
	var $director_name = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__phd_degrees', 'id', $db);
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