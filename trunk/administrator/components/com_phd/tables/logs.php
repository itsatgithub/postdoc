<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * The class contains the table to store logs.
 *
 * @package PhD Programme
 */
class TableLogs extends JTable {

	var $id = null;
	var $applicant_id = null;
	var $text = null;
	var $old_status_id = null;
	var $new_status_id = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__phd_logs', 'id', $db);
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