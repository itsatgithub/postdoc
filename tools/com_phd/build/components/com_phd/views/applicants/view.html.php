<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * PhD component Applicants View
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */
class PhdViewApplicants extends JView
{
	/**
	 * Display the templante
	 *
	 * @param	string $tpl The optional template.
	 * @return	none
	 */
	function display($tpl = null)
	{
		global $mainframe, $option;

		// Initialize some variables
		$db =& JFactory::getDBO();
		$uri =& JFactory::getURI();
		$user =& JFactory::getUser();
		$params =& $mainframe->getParams();

		// checking the user privileges
		$iamadministrator = JHTML::_('phdhelper.isAdministrator');
		$iamgroupleader = JHTML::_('phdhelper.isGroupLeader');
		$iamcommittee = JHTML::_('phdhelper.isCommittee');
		if (!$iamadministrator && !$iamgroupleader && !$iamcommittee) {
			echo JText::_( 'ALERTNOTAUTH' );
			return;
		}

		$filter_order = $mainframe->getUserStateFromRequest( $option.'filter_order', 'filter_order', 'id', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $option.'filter_order_Dir', 'filter_order_Dir', 'ASC', 'word' );
		$filter_search = $mainframe->getUserStateFromRequest( $option.'filter_search', 'filter_search', '', 'string' );
		$filter_search = JString::strtolower( $filter_search );

		// Get some data from the model
		$items =& $this->get('data');
		$total =& $this->get('total');
		$pagination	=& $this->get('pagination');

		// prepare list array
		$lists = array();

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
		$this->assignRef('iamadministrator', $iamadministrator);
		$this->assignRef('iamgroupleader', $iamgroupleader);
		$this->assignRef('iamcommittee', $iamcommittee);
		$this->assignRef('user', $user);
		$this->assignRef('lists', $lists);
		$this->assignRef('params', $params);
		$this->assignRef('items', $items);
		$this->assignRef('total', $total);
		$this->assignRef('pagination', $pagination);

		parent::display($tpl);
	}
}
?>