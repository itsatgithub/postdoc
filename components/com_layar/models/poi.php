<?php
/**
 * Applicant Model file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

/**
 * The class contains the functions used to make all operations related to applicants.
 * 
 * @package PhD Programme
 */
class LayarModelPoi extends JModel
{
	/**
	 * Abstract id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Abstract data
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
	 * Method to set the  identifier
	 *
	 * @access	public
	 * @param	int  identifier
	 */
	function setId($id)
	{
		$this->_id = $id;
		$this->_data = null;
	}

	function getId($codi)
	{
		$query = 'SELECT id'
		. ' FROM `#__jobs_applicants` AS a'
		. ' WHERE a.codi = ' . $codi
		;

		$this->_db->setQuery($query);
		return $this->_db->loadResult();
	}

	/**
	 * Method to get an applicant
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the applicant data
		if ($this->_loadData())
		{
			// Nothing to be done in our case
		}
		else  $this->_initData();

		return $this->_data;
	}

	/**
	 * Method to store an applicant
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _store($data, $tablename)
	{
		$row =& $this->getTable($tablename);

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
	 * Method to delete an applicant
	 *
	 * @param integer $id Applicant id
	 * @return	boolean	True on success, False otherwise
	 */	
	function delete( $id )
	{		
		$this->setId((int)$id);
		$this->_loadData();

		// delete actions
		if (count($this->_data->actions) > 0){
			foreach ($this->_data->actions as $action){
				$this->deleteAction($action->id);
			}
		}
	
		// delete personal data
		$query = 'DELETE FROM `#__layar_pois`'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to load applicant data
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
			// personal data
			$query = 'SELECT p.*, t.description AS activity'
			. ' FROM `#__layar_pois` AS p'
			. ' LEFT JOIN `#__layar_types` AS t ON p.activity_id = t.id'
			. ' WHERE p.id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
	
			// actions
			$query = 'SELECT a.*, at.description as actiontype'
			. ' FROM `#__layar_actions` AS a'
			. ' LEFT JOIN `#__layar_action_types` AS at ON a.activityType = at.id'
			. ' WHERE a.poiID = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data->actions = $this->_db->loadObjectList();

			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the applicant data
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
			$poi = new stdClass();
			$poi->id = 0;
			$poi->attribution = null;
			$poi->type = 0;
			$poi->title = null;
			$poi->lat = null;
			$poi->lon = 0;
			$poi->imageURL = null;
			$poi->image = null;
			$poi->line2 = null;
			$poi->line3 = null;
			$poi->line4 = null;
			$poi->activity_id = 0;
			$poi->layer_id = 0;
			$this->_data = $poi;

			return (boolean) $this->_data;
		}
		return true;
	}


	/**
	 * Method to save Personal Data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */	
	function savePoiData($data){
		$poi_id = $this->_store($data, 'poi');
		if ($poi_id){
			return $poi_id;
		}
		return false;
	}
	
	/**
	* Method to save a File
	*
	* @access	private
	* @return	boolean	True on success
	* @since	1.5
	*/	
	function saveAction($data){
		$store_id = $this->_store($data,'action');
		if ($store_id){
			return $store_id;
		}
		return false;
	}
	

	/**
	 * Method to delete a File
	 *
	 * @param int $id File id 
	 * @return	boolean	True on success, False otherwise
	 */	
	function deleteAction($id)
	{
		global $mainframe;
	
		$query = 'DELETE FROM `#__layar_actions`'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery( $query );
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;

	}

	/*function checkExistEmail($email)
	{
		global $mainframe;
		$db =& JFactory::getDBO();

		$query = "SELECT id"
		. " FROM #__jobs_applicants"
		. " WHERE email = '" . $email ."'"
		;

		$db->setQuery($query);
		return $db->loadResult();
	}*/
	
}