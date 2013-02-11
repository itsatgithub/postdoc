<?php
/**
 * Joomla! 1.5 component register
 *
 * @version $Id: register.php 2009-07-07 09:14:21 svn $
 * @author
 * @package Joomla
 * @subpackage register
 * @license GNU/GPL
 *
 * Manages the registration in congresses.
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

/**
 * register Component register Model
 *
 * @author      notwebdesign
 * @package		Joomla
 * @subpackage	register
 * @since 1.5
 */
class RegisterModelRegister extends JModel {
	/**
	 * Constructor
	 */
	function __construct() {
		parent::__construct();
	}
}
?>