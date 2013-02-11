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
class TableRegistrations extends JTable {

	var $id = null;
	var $congress_id = null;
	var $registration_type_id = null;
	var $firstname = null;
	var $lastname = null;
	var $gender = 0;
	var $member = 0;
	var $title = null;
	var $presentation = null;
	var $paper_type_id = null;
	var $institution = null;
	var $address = null;
	var $city = null;
	var $postalcode = null;
	var $country_id = null;
	var $telephone1 = null;
	var $telephone2 = null;
	var $email = null;
	var $invoice_cif = null;
	var $invoice_institution = null;
	var $invoice_address = null;
	var $invoice_city = null;
	var $invoice_zip = null;
	var $invoice_country_id = null;
	var $registration_date = null;
	var $payment_type_id = null;
	var $order = null;
	var $cost = null;
	var $paid = 0;
	var $extrafield_1 = null;
	var $extrafield_2 = null;
	var $extrafield_3 = null;
	var $extrafield_bool_1 = null;
	var $invoice = null;
	var $invoice_date = null;
	var $invoice_client_code = null;
	var $invoice_payment_reference = null;
	var $email_sent_date = null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__reg_registrations', 'id', $db);
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
