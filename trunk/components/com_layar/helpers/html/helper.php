<?php
/**
 * PhD Helper file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * The class contains the functions used on different parts of the PhD application.
 * 
 * @package PhD Programme
 */
class JHTMLHelper
{
	/**
	 * Check if logged user is an Administrator
	 *
	 * @return boolean True => Administrator
	 */	
	/*function isAdministrator()
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__jobs_users'
		. ' WHERE user_username = \'' . $user->username . '\'' 
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 1) { // role 1 is administrator
			return true;
		} 

		//If not direct role check via category_id
		//Get Category_id
		$model_ddbb =& JModel::getInstance('icmab_ddbb', 'jobsmodel');
		$category_id = $model_ddbb->getCategoryId($user->username);

		$query = 'SELECT role_id'
		. ' FROM #__jobs_categories'
		. ' WHERE cat_id = \'' . $category_id . '\'' 
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 1) { // role 1 is administrator
			return true;
		} else {
			return false;
		}

	}*/

	/**
	 * Check if logged user is an Viewer
	 *
	 * @return boolean True => Viewer
	 */	
	/*function isViewer()
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__jobs_users'
		. ' WHERE user_username = \'' . $user->username . '\'' 
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 2) { // role 2 is viewer
			return true;
		} 

		//If not direct role check via category_id
		//Get Category_id
		$model_ddbb =& JModel::getInstance('icmab_ddbb', 'jobsmodel');
		$category_id = $model_ddbb->getCategoryId($user->username);

		$query = 'SELECT role_id'
		. ' FROM #__jobs_categories'
		. ' WHERE cat_id = \'' . $category_id . '\'' 
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 2) { // role 2 is viewer
			return true;
		} else {
			return false;
		}
	}*/

	function createActivityFilter($filter_activity)
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		
		$javascript = 'onchange="document.adminForm.submit();"';

		// build list of years
		$query = "SELECT DISTINCT t.id AS value, CONCAT(t.description,' - ',ll.description) AS text"
		. " FROM `#__layar_types` AS t"
		. " LEFT JOIN `jos_layar_user_layers` AS ul "
		. " ON ul.layer_id = t.layer_id"
		. " LEFT JOIN `jos_layar_layers` AS ll "
		. " ON ul.layer_id = ll.id"
		. " WHERE ul.username = \"" . $user->username . "\""
		. " ORDER BY ll.description, t.description"
		;

		$db->setQuery($query);
		$activitylist[] = JHTML::_('select.option',  '', JText::_( '- Select Activity -' ), 'value', 'text');
		$activitylist = array_merge( $activitylist, $db->loadObjectList() );
		return JHTML::_('select.genericlist', $activitylist, 'filter_activity', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_activity);
	}

	function createPOITypeFilter($filter_poi_type)
	{
		$db    =& JFactory::getDBO();
		$user =& JFactory::getUser();
		
		$javascript = 'onchange="document.adminForm.submit();"';

		// build list of years
		$query = "SELECT DISTINCT pt.id AS value, CONCAT(pt.description,' - ',ll.description) AS text"
		. " FROM `jos_layar_poi_types` AS pt"
		. " LEFT JOIN `jos_layar_user_layers` AS ul "
		. " ON ul.layer_id = pt.layer_id"
		. " LEFT JOIN `jos_layar_layers` AS ll "
		. " ON ul.layer_id = ll.id"
		. " WHERE ul.username = \"" . $user->username . "\""
		. " ORDER BY ll.description, pt.description"
		;
		$db->setQuery($query);
		$poitypelist[] = JHTML::_('select.option',  '', JText::_( '- Select POI Type -' ), 'value', 'text');
		$poitypelist = array_merge( $poitypelist, $db->loadObjectList() );
		return JHTML::_('select.genericlist', $poitypelist, 'filter_poi_type', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_poi_type);
	}

}