<?php
/**
 * @package		Register
 * Register allows the registration to congresses
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Register Component Congress Model
 *
 * @package		Register
 * @since 1.5
 */
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

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	/**
	 * Method to set the congress identifier
	 *
	 * @access	public
	 * @param	int Congress identifier
	 */
	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
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
			// Nothing to be done in our case
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
		$row =& $this->getTable('congresses');

		// Bind the form fields to the web link table
		if (!$row->bind($data)) {
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
			$query = 'SELECT c.*, co.printable_name' .
					' FROM #__reg_congresses AS c' .
					' LEFT JOIN #__reg_countries AS co ON c.country_id = co.id' .
					' WHERE c.id = ' . $this->_id
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
			$congress = new stdClass();
			$congress->id = 0;
			$congress->description = null;
			$congress->start_date = null;
			$congress->end_date = null;
			$congress->city = null;
			$congress->country_id = 0;
			$congress->date_early_registration = null;
			$congress->date_limit = null;
			$congress->picture = null;
			$this->_data = $congress;
			return (boolean) $this->_data;
		}
		return true;
	}
}
