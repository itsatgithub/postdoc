<?php
/**
 * Applicant User Committee Model file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * The class contains the functions used to save applicant user committee
 *
 * @package PhD Programme
 */
class PhdModelApplicantUserCommittee extends JModel
{
	/**
	 * id
	 *
	 * @var int
	 */
	var $_applicant_id = null;
	
	/**
	 * Author data
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

		$applicant_id = JRequest::getVar('applicant_id', 0, '', 'int');
		$this->setApplicantId((int)$applicant_id);
	}

	/**
	 * Method to set the identifier
	 *
	 * @access	public
	 * @param	int identifier
	 */
	function setApplicantId($id)
	{
		$this->_applicant_id = $id;
		$this->_data = null;
	}

	/**
	 * Method to get data
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the data
		if ($this->_loadData())
		{
			// Nothing to be done in our case
		}
		else  $this->_initData();

		return $this->_data;
	}
	
	/**
	 * Method to store data
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$row =& $this->getTable('applicantusercommittee');
		
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
	 * Method to delete
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function delete($id)
	{
		$row =& $this->getTable('applicantusercommittee');
		if (!$row->delete($id)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	/**
	 * Method to clean the applicant_user_committee registers
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function cleanCommittee($applicant_id)
	{
		$query = 'DELETE FROM `jos_phd_applicant_user_committee`'
		. ' WHERE `applicant_id` = ' . $applicant_id
		;
		$this->_db->setQuery($query);
		$this->_data = $this->_db->loadObject();
		return (boolean) $this->_data;
	}
	
	/**
	 * Method to load data
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
			$query = 'SELECT uc.*'
			. ' FROM #__phd_applicant_user_committee AS uc'
			. ' WHERE uc.applicant_id = ' . $this->_applicant_id
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the data
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
			$item = new stdClass();
			$item->id = 0;
			$item->applicant_id = null;
			$item->user_committee_username = null;
			$this->_data = $item;
			return (boolean) $this->_data;
		}
		return true;
	}
		
}