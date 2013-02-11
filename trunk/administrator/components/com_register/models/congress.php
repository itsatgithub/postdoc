<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

class RegisterModelCongress extends JModel
{
	/**
	 * Congress id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Congress data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid', array(0), '', 'array');
		$edit = JRequest::getVar('edit',true);
		if($edit)
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the congress identifier
	 *
	 * @access	public
	 * @param	int congress identifier
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id = $id;
		$this->_data = null;
	}

	/**
	 * Method to get a congress
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the weblink data
		if ($this->_loadData())
		{
			/*
			 // Initialize some variables
			 $user = &JFactory::getUser();

			 // Check to see if the category is published
			 if (!$this->_data->cat_pub) {
				JError::raiseError( 404, JText::_("Resource Not Found") );
				return;
				}

				// Check whether category access level allows access
				if ($this->_data->cat_access > $user->get('aid', 0)) {
				JError::raiseError( 403, JText::_('ALERTNOTAUTH') );
				return;
				}
				*/
		}
		else  $this->_initData();

		return $this->_data;
	}

	/**
	 * Method to store the congress
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		// get de right table to work with
		$row =& $this->getTable( 'congresses' );

		// Bind the form fields to the web link table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the web link table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to remove a congress
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function delete($cid = array())
	{
		$result = false;

		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__reg_congresses'
			. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method to load content congress data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = 'SELECT c.*'
			. ' FROM #__reg_congresses AS c'
			. ' WHERE c.id = ' . (int) $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the weblink data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$congress = new stdClass();
			$congress->id = 0;
			$congress->description = null;
			$congress->start_date = null;
			$congress->end_date	= null;
			$congress->city = null;
			$congress->country_id = 0;
			$congress->early_registration_date = null;
			$congress->limit_date = null;
			$congress->picture = null;

			$congress->short_name;
			$congress->long_name;
			$congress->email;
			$congress->address;
				
			$congress->registration_text;
			$congress->summary_transfer_text;
			$congress->registration_complete_transfer_text;
			$congress->registration_limit;
			$congress->registration_limit_text;
			$congress->papers_limit;
			$congress->papers_limit_text;
			$congress->mail_transfer_subject;
			$congress->mail_transfer_body;
			$congress->mail_transfer_additional_email;
			$congress->end_reception_date;
			$congress->end_reception_message;
			$congress->paper_instructions;
			$congress->paper_completion_text;
			$congress->papers_directory;
			$congress->paper_mail_subject;
			$congress->paper_mail_body;
			$congress->paper_additional_email;
			$congress->credit_card_complete_text;
			$congress->credit_card_summary_text;
			$congress->credit_card_mail_subject;
			$congress->credit_card_mail_body;
			$congress->credit_card_additional_email;
			$congress->latex_template;
			$congress->latex_directory;
			$congress->latex_email;
			$congress->tpv_url_tpvv;
			$congress->tpv_clave;
			$congress->tpv_name;
			$congress->tpv_code;
			$congress->tpv_terminal;
			$congress->tpv_currency;
			$congress->tpv_transaction_type;
			$congress->tpv_url_merchant;
			$congress->tpv_url_merchant_ok;
			$congress->tpv_language;
			$congress->tpv_producto;
			$congress->cost_javascript;

			$congress->summary_alt_text = null;
			$congress->registration_complete_alt_text = null;
			$congress->mail_alt_subject = null;
			$congress->mail_alt_body = null;
			$congress->mail_alt_additional_email = null;
			$congress->debug = 0;

			$this->_data = $congress;
			return (boolean) $this->_data;
		}
		return true;
	}
}