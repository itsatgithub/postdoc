<?php
/**
 * Joomla! 1.5 component layar
 *
 * @version $Id: layar.php 2011-01-13 06:34:34 svn $
 * @author GPL@avui
 * @package Joomla
 * @subpackage layar
 * @license GNU/GPL
 *
 * 
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
define( 'COM_LAYAR_DIR', 'images'.DS.'layar'.DS );
define( 'COM_LAYAR_BASE', JPATH_ROOT.DS.COM_LAYAR_DIR );
define( 'COM_LAYAR_BASEURL', JURI::root().str_replace( DS, '/', COM_LAYAR_DIR ));

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

// Require the base controller
require_once JPATH_COMPONENT.DS.'helpers'.DS.'helper.php';

// Initialize the controller
$controller = new LayarController( );

// Perform the Request task
$controller->execute( JRequest::getCmd('task'));
$controller->redirect();
?>