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
class RegisterViewPapers extends JView {

	function display($tpl = null) {

		global $mainframe, $option;

		// Initialize some variables
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$params = &$mainframe->getParams();

		$filter_session = $mainframe->getUserStateFromRequest( $option.'filter_session', 'filter_session', '', 'int' );

		// Get the page/component configuration
		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();
		$congress_id = $menu_params->get('id_congress');

		if (empty($congress_id)){
			$get = JRequest::get( 'get' );
			$congress_id = $get['id'];
		};

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($congress_id);
		$congress =& $model_2->getData();

		// Get some data from the model
		$model =& JModel::getInstance('papers', 'registermodel');
		$model->setId($congress_id);
		$items =& $model->getData();

		$pagination	=& $model->getPagination();

		// prepare list array
		$lists = array();
		$javascript = 'onchange="document.adminForm.submit();"';

		// filtering session
		if ($menu_params->get('use_sessions')){
			$query = 'SELECT id AS value, description AS text'
			. ' FROM #__reg_sessions AS s'
			. ' WHERE s.congress_id = '.$congress_id
			. ' ORDER BY s.description'
			;
			$db->setQuery( $query );
			// add first 'select' option
			$options = array();
			$options[] = JHTML::_('select.option', '0', '- '.JText::_('Select a session').' -');
			// append database results
			$options = array_merge($options, $db->loadObjectList());
			// build form control
			$lists['session'] = JHTML::_('select.genericlist', $options, 'filter_session', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_session);
		}

		// filtering paper_type
		if ($menu_params->get('use_paper_type')){
			$query = 'SELECT id AS value, description AS text'
			. ' FROM #__reg_paper_type AS t'
			. ' ORDER BY t.description'
			;
			$db->setQuery( $query );
			// add first 'select' option
			$options = array();
			$options[] = JHTML::_('select.option', '0', '- '.JText::_('Select a paper type').' -');
			// append database results
			$options = array_merge($options, $db->loadObjectList());
			// build form control
			$lists['paper_type'] = JHTML::_('select.genericlist', $options, 'filter_paper_type', 'class="inputbox" size="1" '.$javascript, 'value', 'text', $filter_paper_type);
		}

		// set the values
		//$lists['institution'] = JHTML::_('grid.institution', $filter_institution);
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