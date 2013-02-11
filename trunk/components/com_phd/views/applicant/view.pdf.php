<?php
/**
 * Joomla! 1.5 component register
 *
 * @version $Id: view.pdf.php 2009-07-07 09:14:21 svn $
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
 * PDF View class for the register component
 */
class PhdViewApplicant extends JView {
	function display($tpl = null) {
		global $mainframe;
		$db 	=& JFactory::getDBO();

		$get = JRequest::get( 'get' );
		$applicant_id = $get['id'];

		//Get Registered Person
		$model =& JModel::getInstance( 'applicant', 'phdmodel' );
		$model->setId($applicant_id);
		$applicant =& $model->getData();

		$document =& JFactory::getDocument();
		$document->setName($applicant->lastname.'_'.$applicant->firstname);
		$document->setTitle($applicant->lastname.', '.$applicant->firstname);
		$document->setDescription('PDF exportation of applicants');
		$document->setMetadata('IRB', 'IRB applicant');
		$document->setGenerator('');

		$params =& $mainframe->getParams();

		echo JText::_( 'NAME' ).': '.$applicant->lastname.', '.$applicant->firstname.'<br>';
		echo JText::_( 'GENDER' ).': '.$applicant->gender.'<br>';
		echo JText::_( 'PASSPORT' ).': '.$applicant->passport.'<br>';
		echo JText::_( 'BIRTHDATE' ).': '.$applicant->birth_date.'<br>';
		echo JText::_( 'BIRTHCOUNTRY' ).': '.$applicant->birth_country.'<br>';
		echo JText::_( 'STREET' ).': '.$applicant->street.'<br>';
		echo JText::_( 'CITY' ).': '.$applicant->city.'<br>';
		echo JText::_( 'POSTALCODE' ).': '.$applicant->postalcode.'<br>';
		echo JText::_( 'COUNTRY' ).': '.$applicant->country.'<br>';
		echo JText::_( 'TELEPHONE' ).': '.$applicant->telephone.'<br>';
		echo JText::_( 'EMAIL' ).': '.$applicant->email.'<br>';
		echo JText::_( 'WHEREDIDU' ).': '.$applicant->wheredidu.'<br>';
		if ($applicant->other_fellowships) {
			echo JText::_( 'OTHERFELLOWSHIPS' ).': '.$applicant->other_fellowships_text.'<br>';
		}
		if ($applicant->career_breaks) {
			echo JText::_( 'CAREERBREAKS' ).': '.$applicant->career_breaks_text.'<br>';
			echo ($applicant->career_breaks_filename)?JText::_( 'CAREER_BREAKS_FILENAME' ).': '.$applicant->career_breaks_filename.'<br>':'';
		}

		if ((count($applicant->academic_data_postdoctoral)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'POSTDOCTORAL_ACADEMIC_TITLE' ).'</b><br><br>';
			foreach($applicant->academic_data_postdoctoral as $academic_data) {
				echo JText::_( 'UNIVERSITY-INSTITUTION' ).': '.$academic_data->university.'<br>';
				echo JText::_( 'STARTING_DATE' ).': '.$academic_data->start_date.'<br>';
				echo JText::_( 'OBTENTION_DATE' ).': '.$academic_data->end_date.'<br>';
				echo JText::_( 'DEGREECOUNTRY' ).': '.$academic_data->country.'<br><br>';
			}
		}

		if ((count($applicant->academic_data_doctoral)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'DOCTORAL_ACADEMIC_TITLE' ).'</b><br><br>';
			foreach($applicant->academic_data_doctoral as $academic_data) {
				echo JText::_( 'DEGREE' ).': '.$academic_data->degree.'<br>';
				echo JText::_( 'UNIVERSITY-INSTITUTION' ).': '.$academic_data->university.'<br>';
				echo JText::_( 'STARTING_DATE' ).': '.$academic_data->start_date.'<br>';
				echo JText::_( 'OBTENTION_DATE' ).': '.$academic_data->end_date.'<br>';
				echo JText::_( 'DEGREECOUNTRY' ).': '.$academic_data->country.'<br>';
				echo JText::_( 'DIRECTOR' ).': '.$academic_data->director_name.'<br><br>';
			}
		}

		if ($params->get('phdConfig_Application') == 1) { //PHD
			if ((count($applicant->academic_data_academic)) > 0){
				echo '<br><hr><br>';
				echo '<b>'.JText::_( 'ACADEMIC_TAB' ).'</b><br><br>';
				foreach($applicant->academic_data_academic as $academic_data) {
					echo JText::_( 'DEGREE' ).': '.$academic_data->degree.'<br>';
					echo JText::_( 'UNIVERSITY' ).': '.$academic_data->university.'<br><br>';
				}
			}
		} else { //POSTDOC
			if ((count($applicant->academic_data_academic)) > 0){
				echo '<br><hr><br>';
				echo '<b>'.JText::_( 'ACADEMIC_TITLE' ).'</b><br><br>';
				foreach($applicant->academic_data_academic as $academic_data) {
					echo JText::_( 'DEGREE' ).': '.$academic_data->degree.'<br>';
					echo JText::_( 'UNIVERSITY' ).': '.$academic_data->university.'<br>';
					echo JText::_( 'DEGREECOUNTRY' ).': '.$academic_data->country.'<br>';
					echo JText::_( 'OBTENTION_DATE' ).': '.$academic_data->end_date.'<br><br>';
				}
			}
		}

		if ((count($applicant->files)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'FILES_TAB' ).'</b><br><br>';
			foreach($applicant->files as $file) {
				echo JText::_( 'TYPE' ).': '.$file->doc_type.'<br>';
				echo JText::_( 'FILE' ).': '.$file->filename.'<br>';
				echo JText::_( 'DESCRIPTION' ).': '.$file->description.'<br><br>';
			}
		}

		if ((count($applicant->referees)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'LETTERS_TITLE' ).'</b><br><br>';
			foreach($applicant->referees as $referee) {
				echo JText::_( 'REFEREE_FIRST_NAME' ).': '.$referee->firstname.'<br>';
				echo JText::_( 'REFEREE_LAST_NAME' ).': '.$referee->lastname.'<br>';
				echo JText::_( 'REFEREE_EMAIL' ).': '.$referee->email.'<br>';
				echo JText::_( 'UPLOAD_FILE' ).': '.$referee->filename.'<br><br>';
			}
		}

		if ((count($applicant->work_experience)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'WORK_TITLE' ).'</b><br><br>';
			foreach($applicant->work_experience as $work_experience) {
				echo $work_experience->experience.'<br><br>';
			}
		}

		if ($applicant->phd_thesis) {
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'PHDTHESIS_TITLE' ).'</b><br><br>';
			echo $applicant->phd_thesis.'<br>';
			echo JText::_( 'PHDLECTURE_DATE' ).': '.$applicant->expected_lecture.'<br><br>';
		}

		if ($applicant->research_experience) {
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'RESEARCH_EXPERIENCE_TITLE' ).'</b><br><br>';
			echo $applicant->research_experience.'<br><br>';
		}

		if ((count($applicant->programmes)) > 0){
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'PROGRAMMES_TAB' ).'</b><br><br>';
			foreach($applicant->programmes as $program) {
				echo JText::_( 'PROGRAMMES' ).': '.$program->description.'<br><br>';
			}
		}

		if ($params->get('phdConfig_Application') == 2) { //Postdoc
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'ETHICAL_ISSUE_TITLE' ).'</b><br><br>';
			echo JText::_('ETHICAL_ISSUE');
			echo ($applicant->ethical_issue) ? JText::_('YES').'<br>': JText::_('NO').'<br>';
			echo $applicant->ethical_issue_text.'<br><br>';
		}

		if ($applicant->additional_info) {
			echo '<br><hr><br>';
			echo '<b>'.JText::_( 'ADDITIONALINFO' ).'</b><br><br>';
			echo $applicant->additional_info.'<br><br>';
			echo ($applicant->additional_info_filename)?JText::_( 'INFO_FILE' ).': '.$applicant->additional_info_filename.'<br>':'';
		}

		echo '<br><hr><br>';
		echo '<br>'.JText::_( 'STATUS_TAB' ).': '.$applicant->status.'<br>';

		//print_r($applicant);

	}
}
?>