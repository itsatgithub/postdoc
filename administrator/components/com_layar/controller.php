<?php
/**
 * Joomla! 1.5 component layar
 *
 * @version $Id: controller.php 2011-01-13 06:34:34 svn $
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

jimport( 'joomla.application.component.controller' );
require_once( JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

/**
 * layar Controller
 *
 * @package Joomla
 * @subpackage layar
 */
class LayarController extends JController {
    /**
     * Constructor
     * @access private
     * @subpackage layar
     */
    function __construct() {
        //Get View
        if(JRequest::getCmd('view') == '') {
            JRequest::setVar('view', 'default');
        }
        $this->item_type = 'Default';
        parent::__construct();
    }
}
?>