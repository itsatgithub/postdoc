<?php
/**
 * Applicant View HTML file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport('joomla.utilities.date');

/**
 * HTML View class for the PhD component Applicant view
 */
class PhdViewApplicant extends JView
{

	/**
	 * Display view
	 *
	 * @since 1.5
	 */
	function display($tpl = null)
	{
		global $mainframe, $option;

		// Get some objects
		$model =& JModel::getInstance( 'applicant', 'phdmodel' );
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();
		$uri =& JFactory::getURI();
		$params =& $mainframe->getParams();

		//Check to be authenticated
		if (!$user->id) {
			echo JText::_( 'ALERTNOTAUTH' );
			return;
		}

		// get id
		$id = JRequest::getVar( 'id' );
		$active_tab = JRequest::getVar( 'active_tab' );

		//if no id, i am an applicant, so get it from the username
		if (!$id) {
			$id = JHTML::_('phdhelper.getIdFromUsername',$user->username);
		}

		// access control
		if (!JHTML::_('phdhelper.canRead', $id)) {
			echo JText::_( 'ALERTNOTAUTH' );
			return;
		}

		//Check if can write and or read
		if (JHTML::_('phdhelper.canWrite', $id) && (!JRequest::getVar( 'readonly' ))) {
			$rights = 'write';
		} else {
			$rights = 'read';
		}

		/*$readonly = JRequest::getVar( 'readonly' );
		 echo $readonly;die;*/


		// set the id
		$model->setId( $id );
		$applicant =& $model->getData();

		$javascript = ( $rights == 'write') ? "class='required validate-numeric'" : "" ;

		// build list of countries
		$query = 'SELECT c.id AS value, c.printable_name AS text'
		. ' FROM `#__phd_countries` AS c'
		. ' ORDER BY c.name'
		;
		$db->setQuery($query);
		$countrieslist[] = JHTML::_('select.option',  '', JText::_( '- Select Country -' ), 'value', 'text');
		$countrieslist = array_merge( $countrieslist, $db->loadObjectList() );
		$lists['countries'] = JHTML::_('select.genericlist', $countrieslist, 'country_id', $javascript, 'value', 'text', $applicant->country_id );

		// build list of committees - panel a
		// Roberto 2013-06-26 Se añaden todos los miembros en todos los paneles
		$committeeslist = '';
		$query = 'SELECT u.user_username AS value, ju.name AS text'
		. ' FROM `#__phd_users` AS u'
		. ' LEFT JOIN `#__users` AS ju ON ju.username = u.user_username'
		. ' WHERE u.role_id = 3'
		//. ' AND u.panel = \'a\''
		. ' AND (u.panel = \'a\' OR  u.panel = \'b\' OR u.panel = \'c\')'
		. ' ORDER BY ju.name'
		;
		$db->setQuery($query);
		$committeeslist[] = JHTML::_('select.option',  '', JText::_( '- Select Committee -' ), 'value', 'text');
		$committeeslist = array_merge( $committeeslist, $db->loadObjectList() );
		$lists['committee_username0'] = JHTML::_('select.genericlist', $committeeslist, 'committee_username0', '', 'value', 'text', $applicant->committee_list[0]->user_committee_username );	
		
		// build list of committees - panel b
		$committeeslist = '';
		$query = 'SELECT u.user_username AS value, ju.name AS text'
		. ' FROM `#__phd_users` AS u'
		. ' LEFT JOIN `#__users` AS ju ON ju.username = u.user_username'
		. ' WHERE u.role_id = 3'
		//. ' AND u.panel = \'b\''
		. ' AND (u.panel = \'a\' OR  u.panel = \'b\' OR u.panel = \'c\')'
		. ' ORDER BY ju.name'
		;
		$db->setQuery($query);
		$committeeslist[] = JHTML::_('select.option',  '', JText::_( '- Select Committee -' ), 'value', 'text');
		$committeeslist = array_merge( $committeeslist, $db->loadObjectList() );
		$lists['committee_username1'] = JHTML::_('select.genericlist', $committeeslist, 'committee_username1', '', 'value', 'text', $applicant->committee_list[1]->user_committee_username );
		
		// build list of committees - panel c
		$committeeslist = '';
		$query = 'SELECT u.user_username AS value, ju.name AS text'
		. ' FROM `#__phd_users` AS u'
		. ' LEFT JOIN `#__users` AS ju ON ju.username = u.user_username'
		. ' WHERE u.role_id = 3'
		//. ' AND u.panel = \'c\''
		. ' AND (u.panel = \'a\' OR  u.panel = \'b\' OR u.panel = \'c\')'
		. ' ORDER BY ju.name'
		;
		$db->setQuery($query);
		$committeeslist[] = JHTML::_('select.option',  '', JText::_( '- Select Committee -' ), 'value', 'text');
		$committeeslist = array_merge( $committeeslist, $db->loadObjectList() );
		$lists['committee_username2'] = JHTML::_('select.genericlist', $committeeslist, 'committee_username2', '', 'value', 'text', $applicant->committee_list[2]->user_committee_username );
		
		// build list of birth countries
		$lists['birthcountries'] = JHTML::_('select.genericlist', $countrieslist, 'birth_country_id', $javascript, 'value', 'text', $applicant->birth_country_id );

		// build list of degree countries
		$lists['degreecountries'] = JHTML::_('select.genericlist', $countrieslist, 'country_id', $javascript, 'value', 'text', '' );

		// build list of genders
		$query = 'SELECT g.id AS value, g.description AS text'
		. ' FROM `#__phd_genders` AS g'
		. ' ORDER BY g.order'
		;
		$db->setQuery($query);
		$genderslist[] = JHTML::_('select.option',  '', JText::_( '- Select Gender -' ), 'value', 'text');
		$genderslist = array_merge( $genderslist, $db->loadObjectList() );
		$lists['genders'] = JHTML::_('select.genericlist', $genderslist, 'gender_id', $javascript, 'value', 'text', $applicant->gender_id );

		// build list of wheredidu
		$query = 'SELECT w.id AS value, w.description AS text'
		. ' FROM `#__phd_wheredidu` AS w'
		. ' ORDER BY w.order'
		;
		$db->setQuery($query);
		$wheredidulist[] = JHTML::_('select.option',  '', JText::_( '- Select One -' ), 'value', 'text');
		$wheredidulist = array_merge( $wheredidulist, $db->loadObjectList() );
		$lists['wheredidu'] = JHTML::_('select.genericlist', $wheredidulist, 'wheredidu_id', $javascript, 'value', 'text', $applicant->wheredidu_id );

		$lists['other_fellowships'] = JHTML::_('select.booleanlist', 'other_fellowships' , '', $applicant->other_fellowships ,'Yes', 'No');

		$lists['career_breaks'] = JHTML::_('select.booleanlist', 'career_breaks' , '', $applicant->career_breaks ,'Yes', 'No');

		$lists['ethical_issue'] = JHTML::_('select.booleanlist', 'ethical_issue' , '', $applicant->ethical_issue ,'Yes', 'No');

		$where_doc = ($params->get('phdConfig_Application') == '2')?' WHERE dt.id != 5':' WHERE dt.id < 5';
		// build list of doc types
		$query = 'SELECT dt.id AS value, dt.description AS text'
		. ' FROM `#__phd_doc_types` AS dt'
		. $where_doc
		. ' ORDER BY dt.order'
		;
		$db->setQuery($query);
		$doctypelist[] = JHTML::_('select.option',  '', JText::_( '- Select One -' ), 'value', 'text');
		$doctypelist = array_merge( $doctypelist, $db->loadObjectList() );
		$lists['doctypelist'] = JHTML::_('select.genericlist', $doctypelist, 'doc_type_id', $javascript, 'value', 'text', '' );

		// status
		$apply_details = JHTML::_('phdhelper.canApply',$applicant);
		// build list of status
		$query = 'SELECT s.id AS value, s.description AS text'
		. ' FROM `#__phd_status` AS s'
		. ' ORDER BY s.order'
		;
		$db->setQuery($query);
		$statuslist[] = JHTML::_('select.option',  '', JText::_( '- Select Status -' ), 'value', 'text');
		$statuslist = array_merge( $statuslist, $db->loadObjectList() );
		$lists['statuslist'] = JHTML::_('select.genericlist', $statuslist, 'status_id', $javascript, 'value', 'text', 'status_id' );

		// build list of programmes
		$query = 'SELECT p.id AS value, p.description AS text'
		. ' FROM `#__phd_programmes` AS p'
		. ' ORDER BY p.order'
		;
		$db->setQuery($query);
		$programmeslist[] = JHTML::_('select.option',  '', JText::_( '- Select Option -' ), 'value', 'text');
		$programmeslist = array_merge( $programmeslist, $db->loadObjectList() );
		if ($applicant->programmes)
		{
			foreach ($applicant->programmes as $p)
			{
				if ($p->order == 1)
				{
					$lists['programmeslist'] = JHTML::_('select.genericlist', $programmeslist, 'first_option_id', $javascript, 'value', 'text', $p->programme_id );
					$applicant->programme_1 = $p->description;
				}
				if ($p->order == 2)
				{
					$lists['programmeslist2'] = JHTML::_('select.genericlist', $programmeslist, 'second_option_id', '', 'value', 'text', $p->programme_id );
					$applicant->programme_2 = $p->description;
				}
			}
		} else {
			$lists['programmeslist'] = JHTML::_('select.genericlist', $programmeslist, 'first_option_id', $javascript, 'value', 'text' );
			$lists['programmeslist2'] = JHTML::_('select.genericlist', $programmeslist, 'second_option_id', '', 'value', 'text' );
		}

		// ethical issues
		$lists['ethical_issues_list'] = JHTML::_('phdhelper.getEthicalIssuesList', $applicant->id, $applicant->ethical_issues_list);

		$iamadministrator = JHTML::_('phdhelper.isAdministrator');
		$iamgroupleader = JHTML::_('phdhelper.isGroupLeader');
		$iamcommittee = JHTML::_('phdhelper.isCommittee');

		$this->assignRef('apply_details', $apply_details);
		$this->assignRef('active_tab', $active_tab);
		$this->assignRef('iamadministrator', $iamadministrator);
		$this->assignRef('iamgroupleader', $iamgroupleader);
		$this->assignRef('iamcommittee', $iamcommittee);
		$this->assignRef('applicant', $applicant);
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