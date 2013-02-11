<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Define constants for all pages
 */
define( 'COM_PHD_DIR', 'images'.DS.'phd'.DS );
define( 'COM_PHD_BASE', JPATH_ROOT.DS.COM_PHD_DIR );
define( 'COM_PHD_BASEURL', JURI::root().str_replace( DS, '/', COM_PHD_DIR ));

// Require specific controller if requested
$controller = JRequest::getWord('controller');
if( !$controller )
{
	$controller = 'phd'; // default controller
}
$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
require_once $path;

// Create the controller
$classname	= 'PhdController'.ucfirst($controller);
$controller = new $classname( );

// Perform the Request task
$task = JRequest::getCmd('task');
if (!$task)
{
	$task = 'display';
}

// go
$controller->execute($task);

// Redirect if set by the controller
$controller->redirect();
?>