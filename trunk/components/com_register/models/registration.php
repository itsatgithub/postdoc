<?php
/**
 * @package		Register
 * Register allows the registration to congresses
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Register Component Registration Model
 *
 * @package		Register
 * @since 1.5
 */
class RegisterModelRegistration extends JModel
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

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	/**
	 * Method to set the registration identifier
	 *
	 * @access	public
	 * @param	int Registration identifier
	 */
	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id	= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a registration
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the registration data
		if ($this->_loadData())
		{
			// Nothing to be done in our case
		}
		else  $this->_initData();

		return $this->_data;
	}

	/**
	 * Method to store the registration
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$row =& $this->getTable('registrations');

		// Bind the form fields to the web link table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} else {
			// returns the id
			return $row->id;
		}

	}

	/**
	 * Method to check if the email has been already used for doing a registration
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function checkEmail($email,$congress_id)
	{
		$query = "SELECT r.*"
		. " FROM #__reg_registrations AS r"
		. " WHERE email = '" . $email . "'"
		. " AND congress_id = ".$congress_id
		;

		$this->_db->setQuery($query);
		$this->_data = $this->_db->loadObject();
		return (boolean) $this->_data;
		if(count($this->_data)<=0) {
			return false;
		}
		return true;
	}

	/**
	 * Method to load registration data
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
			$query = 'SELECT r.*, co.printable_name, c.long_name, coi.printable_name as invoice_country, rt.description as registration_type, pt.description as payment_type, ppt.description as paper_type'.
			' FROM #__reg_registrations AS r' .
			' LEFT JOIN #__reg_congresses AS c ON r.congress_id = c.id' .
			' LEFT JOIN #__reg_countries AS co ON r.country_id = co.id' .
			' LEFT JOIN #__reg_countries AS coi ON r.invoice_country_id = coi.id' .
			' LEFT JOIN #__reg_registration_type AS rt ON r.registration_type_id = rt.id' .
			' LEFT JOIN #__reg_payment_type AS pt ON r.payment_type_id = pt.id' .

			' LEFT JOIN #__reg_paper_type AS ppt ON r.paper_type_id = ppt.id' .
			' WHERE r.id = ' . $this->_id	
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the congress data
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
			$registration = new stdClass();
			$registration->id = 0;
			$registration->congress_id = null;
			$registration->registration_type_id = null;
			$registration->firstname = null;
			$registration->lastname = null;
			$registration->gender = null;
			$registration->member = false;
			$registration->title = null;
			$registration->presentation = null;
			$registration->paper_type_id = null;
			$registration->institution = null;
			$registration->address = null;
			$registration->city = null;
			$registration->postalcode = null;
			$registration->country_id = 0;
			$registration->telephone1 = null;
			$registration->telephone2 = null;
			$registration->email = null;
			$registration->invoice_cif = null;
			$registration->invoice_institution = null;
			$registration->invoice_address = null;
			$registration->invoice_city = null;
			$registration->invoice_zip = null;
			$registration->invoice_country_id = 0;
			$registration->registration_date = null;
			$registration->payment_type_id = null;
			$registration->order = null;
			$registration->cost = 0;
			$registration->paid = 0;
			$registration->extrafield_1 = null;
			$registration->extrafield_2 = null;
			$registration->extrafield_3 = null;
			$registration->extrafield_bool_1 = null;
			$registration->invoice = null;
			$registration->invoice_date = null;
			$registration->invoice_client_code = null;
			$registration->invoice_payment_reference = null;
			$registration->payment_justification = null;
			$registration->email_sent_date = NULL;
			$this->_data = $registration;
			return (boolean) $this->_data;
		}
		return true;
	}


	/**
	 * Method to (un)pay a registration
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function paid($cid = array(), $paid = 1)
	{
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );

			$query = 'UPDATE #__reg_registrations'
			. ' SET paid = '.(int) $paid
			. ' WHERE id IN ( '.$cids.' )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	/**
	 * Method to delete a registration
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function delete($cid = array())
	{
		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
			$query = 'DELETE FROM #__reg_registrations'
			. ' WHERE id IN ( '.$cids.' )'
			;
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}
		return true;
	}

	/**
	 * Method to (un)publish a weblink
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function publish($cid = array(), $publish = 1)
	{
		$user 	=& JFactory::getUser();

		if (count( $cid ))
		{
			JArrayHelper::toInteger($cid);
			$cids = implode( ',', $cid );
				
			/*
			 $query = 'UPDATE #__weblinks'
				. ' SET published = '.(int) $publish
				. ' WHERE id IN ( '.$cids.' )'
				. ' AND ( checked_out = 0 OR ( checked_out = '.(int) $user->get('id').' ) )'
				;
				*/
			$query = 'UPDATE #__reg_registrations'
			. ' SET paid = '.(int) $publish
			. ' WHERE id IN ( '.$cids.' )'
			;
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}


	/**
	 * Method to replace labels by values
	 *
	 * @access	public
	 * @return	text
	 * @since	1.5
	 */
	function replace_values($registration_id,$text) {

		$original = array('{lastname}', '{firstname}','{id}','{total}','{invoice_name}','{invoice_address}','{invoice_city}','{invoice_zip}','{invoice_country}');
		$transformed   = array($this->_data->lastname,$this->_data->firstname,$this->_data->id,$this->_data->cost,$this->_data->invoice_institution,$this->_data->invoice_address,$this->_data->invoice_city,$this->_data->invoice_zip,$this->_data->printable_name);

		$clean_text = str_replace($original, $transformed, $text);
		return $clean_text;
	}

	/**
	 * Method to GET REGISTERED PEOPLE
	 *
	 * @access	public
	 * @return	text
	 * @since	1.5
	 */
	function getRegisteredPeople($congress_id) {
		$query = 'SELECT COUNT(*)'.
		' FROM #__reg_registrations AS r' .
		' WHERE r.registration_date IS NOT NULL' .
		' AND r.congress_id = ' . $congress_id	
		;

		$this->_db->setQuery($query);
		$num = $this->_db->loadResult();

		return $num;
	}

}
