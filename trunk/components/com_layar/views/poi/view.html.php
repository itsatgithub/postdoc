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
class LayarViewPoi extends JView {
	function display($tpl = null) {
		global $mainframe, $option;

		$document =& JFactory::getDocument();
		$document->addScript(JURI::base() . 'includes/js/joomla.javascript.js');

		// Get some objects
		$model =& JModel::getInstance( 'poi', 'layarmodel' );
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$uri =& JFactory::getURI();
		$params =& $mainframe->getParams();

		//Check to be authenticated
		if (!$user->id) {
			echo JText::_( 'ALERTNOTAUTH' );
			return;
		}
	
		$id = JRequest::getVar( 'id' );

		//$iamadministrator = JHTML::_('helper.isAdministrator');
		//$iamviewer = JHTML::_('helper.isViewer');

		/*if ($id && $iamviewer) {
			$rights = 'read';
		} else {
			$rights = 'write';
		}*/
		$rights = 'write';

		if ($id) {
			$model->setId( $id );
			$poi =& $model->getData();
		} else {
			$poi->layer_id = '0';
		}

		$javascript_check = ( $rights == 'write') ? "class='required validate-numeric'" : "";

		// build list of layers
		$query = 'SELECT l.id AS value, l.short_description AS text'
		. ' FROM `#__layar_layers` AS l'
		. ' LEFT JOIN `#__layar_user_layers` AS ul ON ul.layer_id = l.id'
		. ' WHERE ul.username = \'' . $user->username . '\''
		. ' ORDER BY l.order'
		;
		$db->setQuery($query);
		$layerslist[] = JHTML::_('select.option',  '', JText::_( '- Select Layer -' ), 'value', 'text');
		$layerslist = array_merge( $layerslist, $db->loadObjectList() );
		if ((count($db->loadObjectList()) == '1') && (!isset($poi->layer_id))){
			$list = $db->loadObjectList();
			$poi->layer_id= $list[0]->value;
		} 
		$lists['layerslist'] = JHTML::_('select.genericlist', $layerslist, 'layer_id', '', 'value', 'text', $poi->layer_id );

		// build list of type (activity type) FILTER
		$query = "SELECT t.id AS value, t.description AS text"
		. " FROM `#__layar_types` AS t"
		. " WHERE layer_id=".$poi->layer_id
		. " ORDER BY t.description"
		;
		$db->setQuery($query);
		$typelist[] = JHTML::_('select.option',  '', JText::_( '- Select Type -' ), 'value', 'text');
		$typelist = array_merge( $typelist, $db->loadObjectList() );
		$lists['typelist'] = JHTML::_('select.genericlist', $typelist, 'activity_id', '', 'value', 'text', $poi->activity_id );

		// build list of type (1-> Ajuntament, 2->ASIC)
		$query = "SELECT t.id AS value, t.description AS text"
		. " FROM `#__layar_poi_types` AS t"
		. " WHERE layer_id=".$poi->layer_id
		. " ORDER BY t.description"
		;
		$db->setQuery($query);
		$poitypelist[] = JHTML::_('select.option',  '', JText::_( '- Select Type -' ), 'value', 'text');
		$poitypelist = array_merge( $poitypelist, $db->loadObjectList() );
		$lists['poitypelist'] = JHTML::_('select.genericlist', $poitypelist, 'type', '', 'value', 'text', $poi->type );

		// build list of action type
		$query = "SELECT at.id AS value, at.description AS text"
		. " FROM `#__layar_action_types` AS at"
		. " ORDER BY at.order"
		;
		$db->setQuery($query);
		$actiontypelist[] = JHTML::_('select.option',  '', JText::_( '- Select Action Type -' ), 'value', 'text');
		$actiontypelist = array_merge( $actiontypelist, $db->loadObjectList() );
		$lists['actiontypelist'] = JHTML::_('select.genericlist', $actiontypelist, 'actiontype_id', $javascript_check, 'value', 'text', '' );
		
		//$link = 'index.php?option=com_jobs&view=job&codi=' . $poi->codi;
		//$linktomodify = $params->get('jobsConfig_LiveSite') . DS . $link ;
		//$this->assignRef('linktomodify', $linktomodify);

		//$this->assignRef('iamadministrator', $iamadministrator);
		//$this->assignRef('iamviewer', $iamviewer);
		$this->assignRef('poi', $poi);
		$this->assign('rights', $rights);
		$this->assign('action', $uri->toString());
		$this->assignRef('user', $user);
		$this->assignRef('lists', $lists);
		$this->assignRef('uri', $uri);
		$this->assignRef('params', $params);
		
		parent::display($tpl);
	}
}
?>