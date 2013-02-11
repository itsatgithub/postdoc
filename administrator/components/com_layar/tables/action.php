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
 * The class contains the table to store docs.
 * 
 * @package PhD Programme
 */
class TableAction extends JTable {

	var $poiID = null;
	var $label = null;
	var $uri = null;
	var $autoTriggerRange = null;
	var $autoTriggerOnly = null;
	var $id = null;
	var $contentType = null;
	var $method = null;
	var $activityType = null;
/*	var $params = null;
	var $closeBiw = null;
	var $showActivity = null;
	var $activityMessage = null;*/

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('LaGarriga_ACTIONS', 'id', $db);
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