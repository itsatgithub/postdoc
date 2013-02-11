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

// Require the base controller
require_once JPATH_COMPONENT.DS.'controller.php';

//Include Helper file
JHTML::addIncludePath( array( JPATH_COMPONENT.DS.'helpers'.DS.'html' ) );

// Initialize the controller
$controller = new LayarController();
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
?>