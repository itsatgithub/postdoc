<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Phd Component Log Model
 *
 */
class PhdModelLog extends JModel
{
	/**
	 * Log id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * log data
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
	}

	/**
	 * Method to set the log identifier
	 *
	 * @param int $id log identifier
	 * @return None
	 */
	function setId($id)
	{
		// Set programme id and wipe data
		$this->_id = $id;
		$this->_data = null;
	}

	/**
	 * Method to get a log record
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the weblink data
		if ($this->_loadData())
		{
			/* Validations
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
	 * Method to store the log record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function store($data)
	{
		$row =& $this->getTable('logs');

		// Bind the form fields to the programme table
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
	 * Method to load content log data
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
			$query = 'SELECT l.*'
			. ' FROM #__phd_logs AS l'
			. ' WHERE l.id = '.(int) $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the log data
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
			$item->text = null;
			$item->old_status_id = null;
			$item->new_status_id = 0;
			$this->_data = $item;
			return (boolean) $this->_data;
		}
		return true;
	}
}