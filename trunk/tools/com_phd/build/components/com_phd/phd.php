<?php
/**
 * PhD controller
 *
 * This is the controller file
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Require specific controller if requested
$controller = JRequest::getWord('controller');
if( !$controller ) {
	$controller = 'applicants'; // default controller
}
$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
require_once $path;

//Include Helper file
JHTML::addIncludePath( array( JPATH_COMPONENT.DS.'helpers'.DS.'html' ) );

// Create the controller
$classname	= 'PhdController'.ucfirst($controller);
$controller = new $classname( );

// Perform the Request task
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();

?>