<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Programme Table class
 *
 * @package		Joomla
 * @subpackage	Phd
 * @since 1.0
 */
class TableProgramme extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $short_description = null;

	/**
	 * @var string
	 */
	var $user_username = null;

	/**
	 * @var id
	 */
	var $order = null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__phd_programmes', 'id', $db);
	}

}
