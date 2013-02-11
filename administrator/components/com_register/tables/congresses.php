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
class TableCongresses extends JTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $short_name = null;

	/**
	 * @var string
	 */
	var $long_name = null;
	/**
	 * @var string
	 */
	var $description = null;
	/**
	 * @var string
	 */
	var $email = null;

	/**
	 * @var date
	 */
	var $start_date = null;

	/**
	 * @var date
	 */
	var $end_date = null;

	/**
	 * @var string
	 */
	var $address = null;

	/**
	 * @var string
	 */
	var $city = null;

	/**
	 * @var int
	 */
	var $country_id = null;

	/**
	 * @var date
	 */
	var $early_registration_date = null;

	/**
	 * @var date
	 */
	var $limit_date = null;

	/**
	 * @var string
	 */
	var $registration_text = null;

	/**
	 * @var string
	 */
	var $summary_transfer_text = null;

	/**
	 * @var string
	 */
	var $registration_complete_transfer_text = null;

	/**
	 * @var string
	 */
	var $registration_limit = null;

	/**
	 * @var string
	 */
	var $registration_limit_text = null;

	/**
	 * @var string
	 */
	var $papers_limit = null;

	/**
	 * @var string
	 */
	var $papers_limit_text = null;

	/**
	 * @var string
	 */
	var $mail_transfer_subject = null;

	/**
	 * @var string
	 */
	var $mail_transfer_body = null;

	/**
	 * @var string
	 */
	var $mail_transfer_additional_email = null;

	/**
	 * @var string
	 */
	var $end_reception_date = null;

	/**
	 * @var string
	 */
	var $end_reception_message = null;

	/**
	 * @var string
	 */
	var $paper_instructions = null;

	/**
	 * @var string
	 */
	var $paper_completion_text = null;

	/**
	 * @var string
	 */
	var $papers_directory = null;

	/**
	 * @var string
	 */
	var $paper_mail_subject = null;

	/**
	 * @var string
	 */
	var $paper_mail_body = null;

	/**
	 * @var string
	 */
	var $paper_additional_email = null;

	/**
	 * @var string
	 */
	var $credit_card_summary_text = null;

	/**
	 * @var string
	 */
	var $credit_card_complete_text = null;

	/**
	 * @var string
	 */
	var $credit_card_mail_subject = null;

	/**
	 * @var string
	 */
	var $credit_card_mail_body = null;

	/**
	 * @var string
	 */
	var $credit_card_additional_email = null;

	/**
	 * @var string
	 */
	var $picture = null;

	/**
	 * @var string
	 */
	var $params = null;

	/**
	 * @var string
	 */
	var $latex_template = null;
	/**
	 * @var string
	 */
	var $latex_directory = null;
	/**
	 * @var string
	 */
	var $latex_email = null;

	/**
	 * @var string
	 */
	var $tpv_url_tpvv = null;
	/**
	 * @var string
	 */
	var $tpv_clave = null;
	/**
	 * @var string
	 */
	var $tpv_name = null;
	/**
	 * @var string
	 */
	var $tpv_code = null;
	/**
	 * @var string
	 */
	var $tpv_terminal = null;
	/**
	 * @var string
	 */
	var $tpv_currency = null;
	/**
	 * @var string
	 */
	var $tpv_transaction_type = null;
	/**
	 * @var string
	 */
	var $tpv_url_merchant = null;
	/**
	 * @var string
	 */
	var $tpv_url_merchant_ok = null;
	/**
	 * @var string
	 */
	var $tpv_language = null;
	/**
	 * @var string
	 */
	var $tpv_producto = null;
	/**
	 * @var string
	 */
	var $cost_javascript = null;

	/**
	 * @var string
	 */
	var $summary_alt_text = null;
	/**
	 * @var string
	 */
	var $registration_complete_alt_text = null;
	/**
	 * @var string
	 */
	var $mail_alt_subject = null;
	/**
	 * @var string
	 */
	var $mail_alt_body = null;
	/**
	 * @var string
	 */
	var $mail_alt_additional_email = null;
	/**
	 * @var string
	 */
	var $debug = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__reg_congresses', 'id', $db);
	}


	/**
	 * Overloaded bind function
	 *
	 * @acces public
	 * @param array $hash named array
	 * @return null|string	null is operation was satisfactory, otherwise returns an error
	 * @see JTable:bind
	 * @since 1.5
	 */
	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] ))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
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