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

/*
 * Define constants for all pages
 */
define( 'COM_REGISTER_DIR', 'images'.DS.'register'.DS );
define( 'COM_REGISTER_BASE', JPATH_ROOT.DS.COM_REGISTER_DIR );
define( 'COM_REGISTER_BASEURL', JURI::root().str_replace( DS, '/', COM_REGISTER_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Require the base controller
require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

// Initialize the controller
$controller = new RegisterController( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();
?>