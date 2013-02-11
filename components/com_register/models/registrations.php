<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Register Component Registrations Model
 *
 * @package		Register
 * @since 		1.5
 */

class RegisterModelRegistrations extends JModel
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

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);

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
	 * Method to get registration data
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
	 * Method to get the total number of registrations items for the congress
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

		$query = 'SELECT r.*'
		. ' FROM #__reg_registrations AS r'
		. ' LEFT JOIN #__reg_registration_type AS rt ON rt.id = r.registration_type_id'
		. ' LEFT JOIN #__reg_paper_type AS pt ON pt.id = r.paper_type_id'
		. ' LEFT JOIN #__reg_countries AS c ON c.id = r.country_id'
		. ' LEFT JOIN #__reg_countries AS co ON co.id = r.invoice_country_id'
		. ' LEFT JOIN #__reg_payment_type AS p ON p.id = r.payment_type_id'
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
		$filter_institution = $mainframe->getUserStateFromRequest( $option.'filter_institution', 'filter_institution', '', 'string' );
		$filter_registration_type = $mainframe->getUserStateFromRequest( $option.'filter_registration_type', 'filter_registration_type', '', 'int' );

		//$congress_id = '1'; // para TEST <----------------------------- Quitar !!
		$congress_id =  $this->_id;

		// first condition
		$where[] = 'r.congress_id = '.$congress_id;

		// only valid registrations
		$where[] = 'r.registration_date IS NOT NULL';

		// Determine search terms
		if ($filter_search = trim($filter_search))
		{
			$filter_search = JString::strtolower($filter_search);
			$db =& $this->_db;
			$filter_search = $db->getEscaped($filter_search);
			$where[] = '(LOWER(firstname) LIKE "%'.$filter_search.'%"'
			. ' OR LOWER(lastname) LIKE "%'.$filter_search.'%")'
			. ' OR r.id = '.$filter_search
			;
		}
		 
		if ($filter_institution != '')
		{
			$where[] = 'r.institution = \'' . $filter_institution . '\'';
		}

		if ($filter_registration_type)
		{
			$where[] = 'r.registration_type_id = \'' . $filter_registration_type . '\'';
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
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'r.lastname', 'cmd' );
		$filter_order_Dir = strtoupper($mainframe->getUserStateFromRequest( $option.'filter_order_Dir',	'filter_order_Dir',	'ASC', 'word' ));

		// in case no value is set
		if (!$filter_order)
		{
			$filter_order = 'r.lastname';
		}

		//$filter_order = 'r.lastname';
	  
		// validate the order direction, must be ASC or DESC
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC')
		{
			$filter_order_Dir = 'ASC';
		}

		// return the ORDER BY clause
		return ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
	}

	function publish($cid = array(), $publish = 1) {
		echo "here";
	}


}
?>
