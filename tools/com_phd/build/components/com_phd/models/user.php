<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');

/**
 * Phd Component User Model
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */

class PhdModelUser extends JModel
{
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
	 * Method to check the Administrator condition
	 *
	 * @access public
	 * @params string $username User name
	 * @return TRUE, FALSE
	 */
	function isAdministrator($username)
	{
		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $username . '\''
		;
		$this->_db->setQuery($query);
		$role_id = $this->_db->loadResult();
		if ($role_id == 1) { // role 1 is administrator
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Method to check the Group Leader condition
	 *
	 * @access public
	 * @params string $username User name
	 * @return TRUE, FALSE
	 */
	function isGroupLeader($username)
	{
		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $username . '\''
		;
		$this->_db->setQuery($query);
		$role_id = $this->_db->loadResult();
		if ($role_id == 2) { // role 2 is group leader
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Method to check the Committee condition
	 *
	 * @access public
	 * @params string $username User name
	 * @return TRUE, FALSE
	 */
	function isCommittee($username)
	{
		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $username . '\''
		;
		$this->_db->setQuery($query);
		$role_id = $this->_db->loadResult();
		if ($role_id == 3) { // role 3 is committee
			return true;
		} else {
			return false;
		}
	}

}
?>
