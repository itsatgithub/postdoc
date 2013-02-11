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
 * The class contains the table to store personal data.
 * 
 * @package PhD Programme
 */
class TablePoi extends JTable {

	var $id = null;
	var $attribution = null;
	var $title = null;
	var $lat = null;
	var $lon = null;
	var $imageURL = null;
	var $image = null;
	var $line4 = null;
	var $line3 = null;
	var $line2 = null;
	var $type = null;
	var $layer_id = null;
	/*var $dimension = null;
	var $alt = null;
	var $relativeAlt = null;
	var $distance = null;
	var $inFocus = null;
	var $doNotIndex = null;
	var $showSmallBiw = null;
	var $showBiwOnClick = null;*/
	var $activity_id = null;

    /**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__layar_pois', 'id', $db);
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