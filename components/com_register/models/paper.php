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
class RegisterModelPaper extends JModel
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
	 * Abstract data
	 *
	 * @var array
	 */
	var $_authors = null;

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
	 * Method to set the abstract identifier
	 *
	 * @access	public
	 * @param	int Abstract identifier
	 */
	function setId($id)
	{
		// Set weblink id and wipe data
		$this->_id	= $id;
		$this->_data	= null;
		$this->_authors	= null;
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
		$row =& $this->getTable('papers');

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
	 * Method to delete a paper
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
			$query = 'DELETE FROM #__reg_papers'
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
			$query = "SELECT p . * , pt.description AS paper_type, s.description AS session , a.name AS name, a.initials AS initials, CONCAT( a.name, ', ', a.initials ) AS presenting_author"
			. " FROM #__reg_papers AS p"
			. " LEFT JOIN #__reg_paper_type AS pt"
			. " ON p.paper_type_id = pt.id"
			. " LEFT JOIN #__reg_sessions AS s"
			. " ON p.session_id = s.id"
			. " LEFT JOIN #__reg_authors AS a"
			. " ON p.presenting_author_id = a.id"
			. " WHERE p.id = " . $this->_id
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
			$paper = new stdClass();
			$paper->id = 0;
			$paper->congress_id = 0;
			$paper->session_id = null;
			$paper->paper_type_id = null;
			$paper->filename = null;
			$paper->abstract = null;
			$paper->modified = null;
			$paper->title = null;
			$paper->presenting_author_id = null;
			$paper->accepted = null;
			$paper->paper_type_id = null;
			$paper->institution = null;
			$paper->email = null;
			$this->_data = $paper;
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to get authors
	 *
	 * @since 1.5
	 */
	function &getOtherAuthors()
	{
		$query = 'SELECT a.*'.
		' FROM #__reg_authors AS a'.
		' WHERE a.paper_id = ' . $this->_id .
		' AND a.id != ' . $this->_data->presenting_author_id .
		' ORDER BY a.order'
		;
		$this->_db->setQuery($query);
		$authors = $this->_db->loadObjectList();
		return $authors;
	}

	/**
	 * Method to replace labels by values
	 *
	 * @access	public
	 * @return	text
	 * @since	1.5
	 */
	function replace_values($paper_id,$text) {

		$original = array('{title}', '{presenting_author}','{id}','{paper_type}','{institution}','{session}');
		$transformed   = array($this->_data->title,$this->_data->presenting_author,$this->_data->id,$this->_data->paper_type,$this->_data->institution,$this->_data->session);

		$clean_text = str_replace($original, $transformed, $text);
		return $clean_text;
	}


	/**
	 * Method to get authors
	 *
	 * @since 1.5
	 */
	function &messageConfirmation($paper_id)
	{
		$query = 'SELECT p.*, pt.description as paper_type, s.description as session, a.name as presenting_author_name, a.initials as presenting_author_initials' .
			' FROM #__reg_papers AS p' .
			' LEFT JOIN #__reg_authors AS a ON p.presenting_author_id = a.id' .
			' LEFT JOIN #__reg_paper_type AS pt ON p.paper_type_id = pt.id' .
			' LEFT JOIN #__reg_sessions AS s ON p.session_id = s.id' .
			' WHERE p.id = ' . $paper_id	
		;
		$this->_db->setQuery($query);
		$paper = $this->_db->loadObject();

		$type_paper = ($paper->paper_type)?"Type of presentation: ". $paper->paper_type ."\n":"";

		$message= "This mail is to confirm the reception of your document for the ACC 2009 congress.\n\n" .
		"Title: ". $paper->title ."\n".
		"Presenting author: ". $paper->presenting_author_name . ', ' . $paper->presenting_author_initials ."\n".
		$type_paper.
		"Session: ". $paper->session ."\n\n".
		"Thanyou for your submission, \n".
		"ACC 2009 organization. \n";

		return $message;
	}

	/**
	 * Method to GET UPLOAD PAPERS
	 *
	 * @access	public
	 * @return	text
	 * @since	1.5
	 */
	function getUploadPapers($congress_id) {
		$query = "SELECT COUNT(*)".
		" FROM #__reg_papers AS p" .
		" WHERE p.submission_date IS NOT NULL" .
		" AND p.submission_date != '0000-00-00'" .
		" AND p.congress_id = " . $congress_id	
		;

		$this->_db->setQuery($query);
		$num = $this->_db->loadResult();

		return $num;
	}
}
