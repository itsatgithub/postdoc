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
jimport('joomla.utilities.date');

/**
 * HTML View class for the register component
 */
class RegisterViewRegistration extends JView {

	/*function display($tpl=null) {

	//Redirijo a form solo para ver el layout
	$this->_displayForm($tpl);
	return;

	parent::display($tpl);
	}*/

	function display($tpl=null) {
		global $mainframe;
		$db =& JFactory::getDBO();

		// Get some objects from the JApplication
		$pathway	=& $mainframe->getPathway();
		$document	=& JFactory::getDocument();
		$model		=& $this->getModel();
		$user		=& JFactory::getUser();
		$uri     	=& JFactory::getURI();
		$params = &$mainframe->getParams();

		$editing_registration = JRequest::getVar( 'editing_registration' , false);
		$this->assignRef('editing_registration', $editing_registration);


		$registration_id = JRequest::getVar( 'registration_id' );

		//get the registration data
		// get the data using the model
		$model =& JModel::getInstance('registration', 'registermodel');
		$model->setId($registration_id);
		$registration =& $model->getData();
		$this->assignRef('registration', $registration);

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();

		if (empty($registration->congress_id)) {
			$registration->congress_id = $menu_params->get('id_congress');
		}

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($registration->congress_id);
		$congress =& $model_2->getData();
		$this->assignRef('congress', $congress);

		$num_registered_people =& $model->getRegisteredPeople($registration->congress_id);
		$this->assignRef('num_registered_people', $num_registered_people);
		//print_r($congress);die;
		//Get Early Registration data and determine if it is early or late registration
		$now = new JDate();
		$early_registration = new JDate($congress->early_registration_date);
		if (($now->toUnix()-$early_registration->toUnix()) > 0){
			$period_registration = 'after';
		} else {
			$period_registration = 'before';
		}

		// build list of registration type
		$query = "SELECT `jos_reg_registration_type`.id AS value, `jos_reg_registration_type`.description AS text "
		. "\n FROM `jos_reg_registration_type`"
		. "\n INNER JOIN `jos_reg_congress-registration_type`"
		. "\n ON `jos_reg_registration_type`.id = `jos_reg_congress-registration_type`.registration_type_id"
		. "\n AND `jos_reg_congress-registration_type`.congress_id = '". (int) $registration->congress_id."'";

		$db->setQuery($query);
		$regtypelist[] = JHTML::_('select.option',  'null', JText::_( '- Select Registration Type -' ), 'value', 'text');
		$regtypelist = array_merge( $regtypelist, $db->loadObjectList() );

		$javascript_code_calculate = "onchange=\"calculate_price('$period_registration');\"";

		if ( $menu_params->get('registration_type')=='2') {
			$registration_type_javascript = "class='required validate-numeric '".$javascript_code_calculate;
		} else {
			$registration_type_javascript = $javascript_code_calculate;
		}

		$lists['registration_type'] = JHTML::_('select.genericlist', $regtypelist, 'registration_type_id', $registration_type_javascript,'value', 'text', $registration->registration_type_id );


		// build list of payment_type
		$query = "SELECT `jos_reg_payment_type`.id AS value, `jos_reg_payment_type`.description AS text "
		. "\n FROM `jos_reg_payment_type`"
		. "\n INNER JOIN `jos_reg_congress-payment_type`"
		. "\n ON `jos_reg_payment_type`.id = `jos_reg_congress-payment_type`.payment_type_id"
		. "\n AND `jos_reg_congress-payment_type`.congress_id = '". (int) $registration->congress_id."'";
		$db->setQuery($query);
		$paytypelist[] = JHTML::_('select.option',  'null', JText::_( '- Select Payment Type -' ), 'value', 'text');
		$paytypelist = array_merge( $paytypelist, $db->loadObjectList() );

		if ( $menu_params->get('payment_method')=='2') {
			$payment_type_javascript = "class='required validate-numeric '";
		} else {
			$payment_type_javascript = '';
		}

		$registration->payment_type_id = ($registration->payment_type_id)?$registration->payment_type_id:'1';

		$lists['payment_type'] = JHTML::_('select.genericlist', $paytypelist, 'payment_type_id', $payment_type_javascript,'value', 'text', $registration->payment_type_id );

		// build list of paper_type
		$query = "SELECT `jos_reg_paper_type`.id AS value, `jos_reg_paper_type`.description AS text "
		. "\n FROM `jos_reg_paper_type`"
		. "\n INNER JOIN `jos_reg_congress-paper_type`"
		. "\n ON `jos_reg_paper_type`.id = `jos_reg_congress-paper_type`.paper_type_id"
		. "\n AND `jos_reg_congress-paper_type`.congress_id = '". (int) $registration->congress_id."'";
		$db->setQuery($query);
		$papertypelist[] = JHTML::_('select.option',  'null', JText::_( '- Select Paper Type -' ), 'value', 'text');
		$papertypelist = array_merge( $papertypelist, $db->loadObjectList() );

		if ( $menu_params->get('presentation')=='2') {
			$paper_type_javascript = "class='required validate-numeric '".$javascript_code_calculate;
		} else {
			$paper_type_javascript = $javascript_code_calculate;
		}

		$lists['paper_type'] = JHTML::_('select.genericlist', $papertypelist, 'paper_type_id', $paper_type_javascript,'value', 'text', $registration->paper_type_id );


		// build list of countries
		$query = "SELECT id AS value, printable_name AS text "
		. "\n FROM `jos_reg_countries`";
		$db->setQuery($query);
		$countrylist[] = JHTML::_('select.option',  'null', JText::_( '- Select Country -' ), 'value', 'text');
		$countrylist = array_merge( $countrylist, $db->loadObjectList() );

		if ( $menu_params->get('country')=='2') {
			$country_javascript = "class='required validate-numeric'".$javascript_code_calculate;
		} else {
			$country_javascript = $javascript_code_calculate;
		}

		$lists['countries'] = JHTML::_('select.genericlist', $countrylist, 'country_id', $country_javascript,'value', 'text', $registration->country_id );

		// build list of countries for invoice
		$lists['invoice_countries'] = JHTML::_('select.genericlist', $countrylist, 'invoice_country_id', 'class="inputbox" size="1"','value', 'text', $registration->invoice_country_id );

		if ( $menu_params->get('gender')=='2') {
			$gender_javascript = "class='required' ".$javascript_code_calculate;
		} else {
			$gender_javascript = $javascript_code_calculate;
		}

		$gender_value = ($registration->gender)?$registration->gender:null;
		// build boolean lists for chice gender, member, accounting and presentation
		$lists['choice_gender'] = JHTML::_('select.booleanlist', 'gender' , $gender_javascript, $registration->gender ,'Male', 'Female');

		$paid_value = ($registration->paid)?$registration->paid:null;
		// build boolean lists for chice gender, member, accounting and presentation
		$lists['choice_paid'] = JHTML::_('select.booleanlist', 'paid' , '', $registration->paid ,'Paid', 'Not Paid');

		/*if ( $menu_params->get('membership')=='2') {
			$membership_javascript = "class='required validate-selectradio' ".$javascript_code_calculate;
			} else {*/
		$membership_javascript = $javascript_code_calculate;
		/*}*/

		$lists['choice_member'] = JHTML::_('select.booleanlist', 'member' , $membership_javascript, $registration->member ,'Yes', 'No');

		//Create bool extra field 1
		if ( $menu_params->get('extrafield_bool_1')=='2') {
			$extrafield_bool_1_javascript = "class='required validate-selectradio'";
		} else {
			$extrafield_bool_1_javascript = '';
		}
		$lists['extrafield_bool_1'] = JHTML::_('select.booleanlist', 'extrafield_bool_1' , $extrafield_bool_1_javascript, $registration->extrafield_bool_1 ,JText::_( 'EXTRAFIELD_BOOL_1_YES' ), JText::_( 'EXTRAFIELD_BOOL_1_NO' ));

		$javascript_code = "onclick=\"invoice_data_copy();\"";

		$lists['choice_accounting'] = JHTML::_('select.booleanlist', 'choice_accounting' , $javascript_code, null ,'Same as above', 'Not Same');

		$lists['choice_presentation'] = JHTML::_('select.booleanlist', 'choice_presentation' , $javascript_code_calculate, $registration->presentation,'Yes','No');

		$this->assignRef('menu_params',$menu_params);

		$this->assign('action',$uri->toString());

		$this->assignRef('lists',$lists);
		$this->assignRef('registration',$registration);
		$this->assignRef('params',$params);

		parent::display($tpl);
	}

	function display_confirmation($registration_id) {
		global $mainframe;

		//Get data for the registered person using the model
		$model =& JModel::getInstance('registration', 'registermodel');
		$model->setId($registration_id);
		$registration =& $model->getData();
		$this->assignRef('registration', $registration);

		//Get Active Congress using the model
		$model =& JModel::getInstance('congress', 'registermodel');
		$model->setId($registration->congress_id);
		$congress =& $model->getData();
		$this->assignRef('congress', $congress);

		$uri =& JFactory::getURI();
		$this->assign('action',$uri->toString());

		$params = &$mainframe->getParams();
		$this->assignRef('params',$params);

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();
		$this->assignRef('menu_params',$menu_params);

		parent::display('confirmation');
	}

	function display_details($registration_id) {
		global $mainframe;

		//Get data for the registered person using the model
		$model =& JModel::getInstance('registration', 'registermodel');
		$model->setId($registration_id);
		$registration =& $model->getData();
		$this->assignRef('registration', $registration);

		//Get Active Congress using the model
		/*$model =& JModel::getInstance('congress', 'registermodel');
		 $model->setId($registration->congress_id);
		 $congress =& $model->getData();
		 $this->assignRef('congress', $congress);*/

		$uri =& JFactory::getURI();
		$this->assign('action',$uri->toString());

		$params = &$mainframe->getParams();
		$this->assignRef('params',$params);

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();
		$this->assignRef('menu_params',$menu_params);

		parent::display('details');
	}

	/*function invoice_form() {
		global $mainframe;
		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();

		$congress_id = $menu_params->get('id_congress');

		// build list of registered people
		$query = "SELECT id AS value, CONCAT(firstname,lastname) AS text  "
		"\n FROM `jos_reg_registrations`".
		"\n WHERE `jos_reg_registrations`.congress_id = '". (int) $congress_id."'".
		"AND `jos_reg_registrations`.paid = '1'";
		$db->setQuery($query);
		$peoplelist[] = JHTML::_('select.option',  'null', JText::_( '- Select Person -' ), 'value', 'text');
		$peoplelist = array_merge( $peoplelist, $db->loadObjectList() );

		print_r($peoplelist);

		parent::display('invoice_form');
		}*/
}
?>