<?php
/**
 * Joomla! 1.5 component layar
 *
 * @version $Id: view.html.php 2011-01-13 06:34:34 svn $
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the layar component
 */
class LayarViewPois extends JView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		// Initialize some variables
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$document =& JFactory::getDocument();
		$document->addScript( JURI::root(true).'/includes/js/joomla.javascript.js');

		//Manage Rights
		if (empty($user->id)) {
			echo JText::_( 'ALERTNOTAUTH' );
			return false;
		}

		/*//Check the logged person is authorized
		if (!(JHTML::_('helper.isAuthorized',$user->username))) {
			echo JText::_( 'ALERTNOTAUTH' );
			return false;
		}*/
		//$iamadministrator = JHTML::_('helper.isAdministrator');
		$iamadministrator = true;
		$this->assignRef('iamadministrator', $iamadministrator);

		//Order
		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'id');
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC' );

		//Search Filter
		$filter_search = $mainframe->getUserStateFromRequest( $option.'filter_search', 'filter_search', '', 'string' );
		$filter_search = JString::strtolower( $filter_search );

		// Get the page/component configuration
		$params =& $mainframe->getParams();
		
		// Get some data from the model
		$items =& $this->get('data'); 
		$total =& $this->get('total');
		$pagination	=& $this->get('pagination');

		// prepare list array
		$lists = array();

		//Select box filters
		$filter_activity = $mainframe->getUserStateFromRequest( $option.'filter_activity', 'filter_activity', '', 'string' );
		$filter_poi_type = $mainframe->getUserStateFromRequest( $option.'filter_poi_type', 'filter_poi_type', '', 'string' );
		$lists['activity'] = JHTML::_('helper.createActivityFilter',$filter_activity);
		$lists['poi_type'] = JHTML::_('helper.createPOITypeFilter',$filter_poi_type);

		// set the values
		$lists['order'] = $filter_order;
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['search'] = $filter_search;

		// preparing items to display
		$k = 0;
		$count = count($items);
		for($i = 0; $i < $count; $i++)
		{
			$item =& $items[$i];
			$item->odd = $k;
			$item->count = $i;
			$k = 1 - $k;
		}

		// push data into the template
		$this->assignRef('user', $user);
		$this->assignRef('lists', $lists);
		$this->assignRef('params', $params);
		$this->assignRef('items', $items);
	       	$this->assignRef('total', $total);
		$this->assignRef('pagination', $pagination);

		// ordering action
		$this->assign('action',	$uri->toString());
		
		parent::display($tpl);
	}
}
?>