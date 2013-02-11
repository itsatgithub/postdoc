<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Register Component Papers Model
 *
 * @package		Register
 * @since 		1.5
 */

class RegisterModelPapers extends JModel
{
	/**
	 * Frontpage data array
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Frontpage total
	 *
	 * @var integer
	 */
	var $_total = null;

	/**
	 * Pagination object
	 *
	 * @var object
	 */
	var $_pagination = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		global $mainframe, $option;

		// Get pagination request variables
		$limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int');
		$limitstart = JRequest::getVar('limitstart', 0, '', 'int');

		// In case limit has been changed, adjust it
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
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
	 * Method to get paper item data for the congress
	 *
	 * @access public
	 * @return array
	 */
	function getData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
	}

	/**
	 * Method to get the total number of papers items for the congress
	 *
	 * @access public
	 * @return integer
	 */
	function getTotal()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}

	/**
	 * Method to get the pagination object
	 *
	 * @access public
	 * @return object
	 */
	function getPagination()
	{
		// Load the content if it doesn't already exist
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination($this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}

		return $this->_pagination;
	}

	function _buildQuery()
	{
		$query = 'SELECT p.*, s.description as session'
		. ' FROM #__reg_papers AS p'
		. ' LEFT JOIN #__reg_sessions AS s ON s.id = p.session_id'
		. ' LEFT JOIN #__reg_congresses AS c ON c.id = p.congress_id'
		. $this->_buildQueryWhere()
		. $this->_buildQueryOrderBy();
		;

		return $query;
	}


	/**
	 *
	 *
	 * Builds the WHERE part of a query
	 *
	 * @return string Part of an SQL query
	 */
	function _buildQueryWhere()
	{
		global $mainframe, $option;

		// get the search field
		$filter_search = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search');
		$filter_session = $mainframe->getUserStateFromRequest($option.'filter_session', 'filter_session');
		$filter_paper_type = $mainframe->getUserStateFromRequest($option.'filter_paper_type', 'filter_paper_type');
	  
		//$congress_id = '1'; // para TEST <----------------------------- Quitar !!
		$congress_id =  $this->_id;
		// first condition
		$where[] = 'c.id = '.$congress_id;

		// Determine search terms
		if ($filter_search = trim($filter_search))
		{
			$filter_search = JString::strtolower($filter_search);
			$db =& $this->_db;
			$filter_search = $db->getEscaped($filter_search);
			$where[] = '(LOWER(title) LIKE "%'.$filter_search.'%"'
			. ' OR LOWER(filename) LIKE "%'.$filter_search.'%")'
			. ' OR p.id = '.$filter_search
			;
		}

		if ($filter_session)
		{
			$where[] = 'p.session_id = ' . $filter_session;
		}

		if ($filter_paper_type)
		{
			$where[] = 'p.paper_type_id = ' . $filter_paper_type;
		}

		// return the WHERE clause
		return (count($where)) ? ' WHERE '.implode(' AND ', $where) : '';
	}

	/**
	 * Builds the ORDER part of a query
	 *
	 * @return string Part of an SQL query
	 */
	function _buildQueryOrderBy()
	{
		global $mainframe, $option;

		// get the order field and direction
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'title' );
		$filter_order_Dir = strtoupper($mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC'));

		// if order column is unknown use the default
		if (!$filter_order)
		{
			$filter_order = 'p.title';
		}

		// validate the order direction, must be ASC or DESC
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC')
		{
			$filter_order_Dir = 'ASC';
		}

		// return the ORDER BY clause
		return ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
	}

}
?>
