<?php
/**
 * Joomla! 1.5 component register
 *
 * @version $Id: view.html.php 2009-07-07 09:14:21 svn $
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

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the register component
 */
class RegisterViewRegistrations extends JView {

	function display($tpl = null) {

		global $mainframe;

		// Initialize some variables
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();

		$filter_institution = $mainframe->getUserStateFromRequest( $option.'filter_institution', 'filter_institution', '', 'string' );
		$filter_registration_type = $mainframe->getUserStateFromRequest( $option.'filter_registration_type', 'filter_registration_type', '', 'int' );

		// Get the page/component configuration
		$params =& $mainframe->getParams();

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();
		$registration->congress_id = $menu_params->get('id_congress');

		if (empty($registration->congress_id)){
			$get = JRequest::get( 'get' );
			$registration->congress_id = $get['id'];
		}

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($registration->congress_id);
		$congress =& $model_2->getData();

		$model =& JModel::getInstance('registrations', 'registermodel');
		$model->setId($registration->congress_id);
		$items =& $model->getData();

		// Get some data from the model
		//$items =& $this->get('data');
		//$pagination	=& $this->get('pagination');
		$pagination	=& $model->getPagination();

		// prepare list array
		$lists = array();
		$javascript = 'onchange="document.adminForm.submit();"';

		// filtering institution
		$query = 'SELECT DISTINCT institution AS value, institution AS text'
		. ' FROM #__reg_registrations AS r'
		. ' WHERE r.institution != \'\''
		. ' ORDER BY r.institution'
		;
		$db->setQuery( $query );
		// add first 'select' option
		$options = array();
		$options[] = JHTML::_('select.option', '', '- '.JText::_('Select a institution').' -');
		// append database results
		$options = array_merge($options, $db->loadObjectList());
		// build form control
		$lists['institution'] = JHTML::_('select.genericlist', $options, 'filter_institution', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_institution);

		// filtering registration type
		$query = 'SELECT id AS value, description AS text'
		. ' FROM #__reg_registration_type AS t'
		. ' ORDER BY t.description'
		;
		$db->setQuery( $query );
		// add first 'select' option
		$options = array();
		$options[] = JHTML::_('select.option', '', '- '.JText::_('Select a type').' -');
		// append database results
		$options = array_merge($options, $db->loadObjectList());
		// build form control
		$lists['registration_type'] = JHTML::_('select.genericlist', $options, 'filter_registration_type', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_registration_type);

		// set the values
		$lists['search'] = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search');
		$lists['order_Dir'] = $mainframe->getUserStateFromRequest($option.'filter_order_Dir', 'filter_order_Dir');
		$lists['order'] = $mainframe->getUserStateFromRequest($option.'filter_order', 'filter_order');

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

		$this->assignRef('menu_params',$menu_params);

		// push data into the template
		$this->assignRef('lists', $lists);
		$this->assignRef('params', $params);
		$this->assignRef('items', $items);
		//$this->assignRef('total', $total);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('user', $user);
		$this->assignRef('congress', $congress);

		// ordering action
		$this->assign('action',	$uri->toString());

		parent::display($tpl);
	}
}
?>