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
class TablePersonaldata extends JTable {

	var $id = null;
	var $firstname = null;
	var $lastname = null;
	var $gender_id = null;
	var $passport = null;
	var $birth_date = null;
	var $birth_country_id = null;
	var $street = null;
	var $city = null;
	var $postalcode = null;
	var $country_id = null;
	var $telephone = null;
	var $email = null;
	var $wheredidu_id = null;
	var $other_fellowships = null;
	var $other_fellowships_text = null;
	var $career_breaks = null;
	var $career_breaks_text = null;
	var $career_breaks_filename = null;
	var $additional_info = null;
	var $additional_info_filename = null;
	var $phd_thesis = null;
	var $expected_lecture = null;
	var $research_experience = null;
	var $ethical_issue = null;
	var $ethical_issue_text = null;
	var $user_username = null;
	var $status_id = null;
	var $submit_date = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__phd_applicants', 'id', $db);
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