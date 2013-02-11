<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * PhD component Applicants Model
 *
 * This is the file describing data access to the Applicant model
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */
class PhdModelApplicants extends JModel
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
	 * @param none
	 * @return none
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
	 * @param none
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
		$query = 'SELECT DISTINCT a.id AS id, a.firstname AS firstname'
		. ', a.lastname AS lastname, a.submit_date AS submit_date, st.short_description AS status'
		. ' FROM `#__phd_applicants` AS a'
		. ' LEFT JOIN `#__phd_status` AS st ON st.id = a.status_id'
		. ' LEFT JOIN `#__phd_applicant_programme` AS ap ON ap.applicant_id = a.id'
		. ' LEFT JOIN `#__phd_programmes` AS pro ON pro.id = ap.programme_id'
		. ' LEFT JOIN `#__phd_applicant_user_committee` AS uc ON uc.applicant_id = a.id'
		. $this->_buildQueryWhere()
		. $this->_buildQueryOrderBy();
		;

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

		$user =& JFactory::getUser();
		$app_user =& JModel::getInstance( 'user', 'phdmodel' );

		// empty condition
		$where = array();

		// if the user is administrator only some applicants must be shown.
		if ($app_user->isAdministrator($user->username)) {
			$where[] = 'a.status_id != 1';
		}
		
		$params =& $mainframe->getParams();
		$phdConfig_FirstChoice = $params->get('phdConfig_FirstChoice');
		
		// if the user is a group leader only some applicants must be shown.
		if ($app_user->isGroupLeader($user->username)) {
			$where[] = 'a.status_id = 2'; // only submitted
			$where[] = 'pro.user_username = \'' . $user->username . '\'';
			// 2011-02-16 List only first choice
			if ($phdConfig_FirstChoice == '1') {
				$where[] = 'ap.order = 1'; // just first choice
			}
		}

		// if the user is a committee only some applicants must be shown.
		if ($app_user->isCommittee($user->username)) {
			$where[] = 'a.status_id != 1'; // not editing
			$where[] = 'a.status_id != 3'; // not not invited for interviews
			$where[] = 'a.status_id != 5'; // not acepted
			$where[] = 'a.status_id != 7'; // not discarded
			$where[] = 'uc.user_committee_username = \'' . $user->username . '\''; // only assigned to this committee
		}

		// get the search field
		$filter_search = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search');

		// Determine search terms
		if ($filter_search = trim($filter_search))
		{
			$filter_search = JString::strtolower($filter_search);
			$db =& $this->_db;
			$filter_search = $db->getEscaped($filter_search);
			$where[] = '(LOWER(firstname) LIKE "%' . $filter_search . '%"'
			. ' OR LOWER(lastname) LIKE "%' . $filter_search . '%")'
			. ' OR submit_date LIKE "%' . $filter_search . '%"'
			;
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

		// Array of allowable order fields
		$orders = array('id', 'firstname', 'lastname', 'status', 'submit_date');

		// get the order field and direction
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'id' );
		$filter_order_Dir = strtoupper($mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'DESC'));

		// if order column is unknown use the default
		if (!in_array($filter_order, $orders)) {
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
