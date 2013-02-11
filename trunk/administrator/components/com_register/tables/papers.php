<?php
/**
 * Joomla! 1.5 component Register
 *
 * @version $Id: register.php 2009-07-07 09:14:21 svn $
 * @author
 * @package Joomla
 * @subpackage register
 * @license GNU/GPL
 *
 * Manages the registration in congresses.
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include library dependencies
jimport('joomla.filter.input');

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		Register
 */
class TablePapers extends JTable {

	var $id = null;
	var $congress_id = null;
	var $session_id = null;
	var $paper_type_id = null;
	var $institution = null;
	var $filename = null;
	var $email = null;
	var $modified = null;
	var $title = null;
	var $presenting_author_id = null;
	var $accepted = null;
	var $submission_date = null;
	var $abstract = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__reg_papers', 'id', $db);
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
