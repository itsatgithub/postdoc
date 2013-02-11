<?php
/**
 * Joomla! 1.5 component Jobs
 *
 * @version $Id: jobs.php 2010-10-22 10:02:57 svn $
 * @author Albert Moreno
 * @package Joomla
 * @subpackage Jobs
 * @license GNU/GPL
 *
 * Application to apply to ICMAB positions
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * Jobs Component Jobs Model
 *
 * @author      notwebdesign
 * @package		Joomla
 * @subpackage	Jobs
 * @since 1.5
 */
class LayarModelPois extends JModel {
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
	 * Method to get item data
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
	 * Method to get the total number of items
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
	
	/**
	 * Builds the query
	 *
	 * @return an SQL query
	 */
	function _buildQuery()
	{		
		$query = "SELECT p.*, t.description AS activity, pt.description AS poi_type"
		. " FROM `#__layar_pois` AS p"
		. " LEFT JOIN `#__layar_types` AS t ON p.activity_id = t.id"
			. " AND p.layer_id = t.layer_id"
		. " LEFT JOIN `#__layar_poi_types` AS pt ON p.type = pt.id"
		. " LEFT JOIN `#__layar_user_types` AS ut ON ut.type_id = t.id"
		. " LEFT JOIN `#__layar_user_poi_types` AS upt ON upt.poi_type_id = pt.id"
		. " LEFT JOIN `#__layar_user_pois` AS up ON up.poi_id = p.id"
		. " LEFT JOIN `#__layar_user_layers` AS ul ON ul.layer_id = p.layer_id"
		. $this->_buildQueryWhere()
		. $this->_buildQueryOrderBy();
		;

		//echo $query.'<br><br>';
		return $query;
	}

	/**
	 * Builds the WHERE part of a query
	 *
	 * @return string Part of an SQL query
  	 */
	function _buildQueryWhere()
	{
		global $mainframe, $option;
				
		// empty condition
		$where = array();
				
		//Search filter
		$filter_search = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search');
		if ($filter_search = trim($filter_search))
		{
			$filter_search = JString::strtolower($filter_search);
			$db =& $this->_db;
			$filter_search = $db->getEscaped($filter_search);
			$where[] = '(LOWER(title) LIKE "%' . $filter_search . '%"'
			. ' OR LOWER(attribution) LIKE "%' . $filter_search . '%"'
			. ' OR LOWER(line2) LIKE "%' . $filter_search . '%"'
			. ' OR LOWER(line3) LIKE "%' . $filter_search . '%"'
			. ' OR LOWER(line4) LIKE "%' . $filter_search . '%")'
			;
		}

		//Other filters
		$filter_activity = $mainframe->getUserStateFromRequest($option.'filter_activity', 'filter_activity');
		$filter_poi_type = $mainframe->getUserStateFromRequest($option.'filter_poi_type', 'filter_poi_type');
		if ($filter_activity) {
			$where[] = "t.id = '". $filter_activity."'";
		}
		if ($filter_poi_type) {
			$where[] = "p.type = '". $filter_poi_type."'";
		}
		
		// permisions filter
		$user =& JFactory::getUser();
		$where[] = '(ut.username = \'' . $user->username . '\''
		. ' OR upt.username = \'' . $user->username . '\''
		. ' OR up.username = \'' . $user->username . '\''
		. ' OR ul.username = \'' . $user->username . '\')';
		

		//$where[] = "o.time_in IS NOT NULL";
		//$where[] = "o.time_out IS NOT NULL";
		//$where[] = "o.time_accumulated IS NOT NULL";
		//$where[] = " o.ended_order != '0' ";

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

		$orders = array('id');
	
		// get the order field and direction
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'id' );

		$filter_order_Dir = strtoupper($mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC'));

		// if order column is unknown use the default
		if (!in_array($filter_order, $orders))
		{
			$filter_order = 'id';
		}

		// validate the order direction, must be ASC or DESC
		if ($filter_order_Dir != 'ASC' && $filter_order_Dir != 'DESC')
		{
			$filter_order_Dir = 'DESC';
		}

		// return the ORDER BY clause
		return ' ORDER BY '.$filter_order.' '.$filter_order_Dir;
	}

}
?>