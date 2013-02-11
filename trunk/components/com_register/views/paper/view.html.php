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
class RegisterViewPaper extends JView {

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

		$editing_paper = JRequest::getVar( 'editing_paper' , false);
		$this->assignRef('editing_paper', $editing_paper);

		$paper_id = JRequest::getVar( 'paper_id' );

		//get the paper data using the model
		$model =& JModel::getInstance('paper', 'registermodel');
		$model->setId($paper_id);
		$paper =& $model->getData();
		$this->assignRef('paper', $paper);

		$authors =& $model->getOtherAuthors();
		$this->assignRef('authors', $authors);

		$model_author =& JModel::getInstance('author', 'registermodel');
		$model_author->setId($paper->presenting_author_id);
		$presenting_author =& $model_author->getData();
		$this->assignRef('presenting_author', $presenting_author);

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();

		if (empty($paper->congress_id)) {
			$paper->congress_id = $menu_params->get('id_congress');
		}

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($paper->congress_id);
		$congress =& $model_2->getData();
		$this->assignRef('congress', $congress);

		$num_upload_papers =& $model->getUploadPapers($paper->congress_id);
		$this->assignRef('num_upload_papers', $num_upload_papers);

		$dateNow = new JDate();
		$submit_date = $dateNow->toMySQL();
		$this->assignRef('submission_date',$submit_date);
		$this->assignRef('modified',$submit_date);

		if ( $menu_params->get('paper_session')=='2') {
			$paper_session_javascript = "class='required validate-numeric '";
		} else {
			$paper_session_javascript = "";
		}

		if ( $menu_params->get('paper_typeofpresentation')=='2') {
			$paper_typeofpresentation_javascript = "class='required validate-numeric '";
		} else {
			$paper_typeofpresentation_javascript = "";
		}

		// build list of paper_type
		$query = "SELECT `jos_reg_paper_type`.id AS value, `jos_reg_paper_type`.description AS text "
		. "\n FROM `jos_reg_paper_type`"
		. "\n INNER JOIN `jos_reg_congress-paper_type`"
		. "\n ON `jos_reg_paper_type`.id = `jos_reg_congress-paper_type`.paper_type_id"
		. "\n AND `jos_reg_congress-paper_type`.congress_id = '". (int) $paper->congress_id."'";
		$db->setQuery($query);
		$papertypelist[] = JHTML::_('select.option',  '', JText::_( '- Select Paper Type -' ), 'value', 'text');
		$papertypelist = array_merge( $papertypelist, $db->loadObjectList() );
		$lists['paper_type'] = JHTML::_('select.genericlist', $papertypelist, 'paper_type_id', $paper_typeofpresentation_javascript,'value', 'text', $paper->paper_type_id );

		// build list of sessions
		$query = "SELECT `jos_reg_sessions`.id AS value, `jos_reg_sessions`.description AS text "
		. "\n FROM `jos_reg_sessions`"
		. "\n WHERE `jos_reg_sessions`.congress_id = '". (int) $paper->congress_id."'";
		$db->setQuery($query);
		$sessionlist[] = JHTML::_('select.option',  '', JText::_( '- Select Session -' ), 'value', 'text');
		$sessionlist = array_merge( $sessionlist, $db->loadObjectList() );
		$lists['session_type'] = JHTML::_('select.genericlist', $sessionlist, 'session_id', $paper_session_javascript,'value', 'text', $paper->session_id );

		$accepted_value = ($paper->accepted)?$paper->accepted:null;
		// build boolean lists for chice gender, member, accounting and presentation
		$lists['choice_accepted'] = JHTML::_('select.booleanlist', 'accepted' , '', $paper->accepted ,'Yes', 'No');

		//Get Menu Item Parameters
		$menu_params =& $mainframe->getPageParameters();
		$this->assignRef('menu_params',$menu_params);

		$this->assign('action',$uri->toString());
		$this->assignRef('user',$user);
		$this->assignRef('lists',$lists);
		$this->assignRef('params',$params);

		parent::display($tpl);
	}

}
?>