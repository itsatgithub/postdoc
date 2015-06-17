<?php
/**
 * Applicant Model file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

/**
 * The class contains the functions used to make all operations related to applicants.
 *
 * @package PhD Programme
 */
class PhdModelApplicant extends JModel
{
	/**
	 * Abstract id
	 *
	 * @var int
	 */
	var $_id = null;

	/**
	 * Abstract data
	 *
	 * @var array
	 */
	var $_data = null;

	/**
	 * Constructor
	 *
	 * @since 1.5
	 */
	function __construct()
	{
		parent::__construct();

		$id = JRequest::getVar('id', 0, '', 'int');
		$this->setId((int)$id);
	}

	/**
	 * Method to set the  identifier
	 *
	 * @access	public
	 * @param	int  identifier
	 */
	function setId($id)
	{
		$this->_id = $id;
		$this->_data = null;
	}

	/**
	 * Method to get an applicant
	 *
	 * @since 1.5
	 */
	function &getData()
	{
		// Load the applicant data
		if ($this->_loadData())
		{
			// Nothing to be done in our case
		}
		else  $this->_initData();

		return $this->_data;
	}

	/**
	 * Method to store an applicant
	 *
	 * @access	public
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _store($data, $tablename)
	{
		$row =& $this->getTable($tablename);

		// Bind the form fields to the web link table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the table is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} else {
			// returns the id
			return $row->id;
		}
	}

	/**
	 * Method to delete an applicant
	 *
	 * @param integer $id Applicant id
	 * @return	boolean	True on success, False otherwise
	 */
	function delete( $id )
	{
		$this->setId((int)$id);
		$this->_loadData();

		$query = 'DELETE FROM #__phd_degrees'
		. ' WHERE applicant_id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// delete referees
		if (count($this->_data->referees) > 0){
			foreach ($this->_data->referees as $referee){
				$this->deleteReferee($referee->id);
			}
		}

		// delete work experience
		$query = 'DELETE FROM #__phd_work_experiences'
		. ' WHERE applicant_id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// delete programmes applied
		$query = 'DELETE FROM #__phd_applicant_programme'
		. ' WHERE applicant_id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// delete docs
		if (count($this->_data->files) > 0){
			foreach ($this->_data->files as $file){
				$this->deleteFile($doc->id);
			}
		}

		// delete personal data
		$query = 'DELETE FROM #__phd_applicants'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

	/**
	 * Method to load applicant data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _loadData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			// personal data
			$query = 'SELECT a.*, s.description AS status, co.printable_name AS country, ge.short_description AS gender, cob.printable_name AS birth_country, w.description AS wheredidu'
			. ' FROM `#__phd_applicants` AS a'
			. ' LEFT JOIN `#__phd_status` AS s ON s.id = a.status_id'
			. ' LEFT JOIN `#__phd_countries` AS co ON co.id = a.country_id'
			. ' LEFT JOIN `#__phd_countries` AS cob ON cob.id = a.birth_country_id'
			. ' LEFT JOIN `#__phd_genders` AS ge ON ge.id = a.gender_id'
			. ' LEFT JOIN `#__phd_wheredidu` AS w ON w.id = a.wheredidu_id'
			. ' WHERE a.id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();

			// academic data for academic, doctoral and postdoctoral
			$query = 'SELECT d.*, co.printable_name AS country'
			. ' FROM `#__phd_degrees` AS d'
			. ' LEFT JOIN `#__phd_countries` AS co ON co.id = d.country_id'
			. ' WHERE d.applicant_id = ' . $this->_id
			. ' AND d.type = \'academic\''
			;
			$this->_db->setQuery($query);
			$this->_data->academic_data_academic = $this->_db->loadObjectList();

			$query = 'SELECT d.*, co.printable_name AS country'
			. ' FROM `#__phd_degrees` AS d'
			. ' LEFT JOIN `#__phd_countries` AS co ON co.id = d.country_id'
			. ' WHERE d.applicant_id = ' . $this->_id
			. ' AND d.type = \'doctoral\''
			;
			$this->_db->setQuery($query);
			$this->_data->academic_data_doctoral = $this->_db->loadObjectList();
				
			$query = 'SELECT d.*, co.printable_name AS country'
			. ' FROM `#__phd_degrees` AS d'
			. ' LEFT JOIN `#__phd_countries` AS co ON co.id = d.country_id'
			. ' WHERE d.applicant_id = ' . $this->_id
			. ' AND d.type = \'postdoctoral\''
			;
			$this->_db->setQuery($query);
			$this->_data->academic_data_postdoctoral = $this->_db->loadObjectList();
				
			// files
			$query = 'SELECT d.*, dt.description as doc_type'
			. ' FROM `#__phd_docs` AS d'
			. ' LEFT JOIN `#__phd_doc_types` AS dt ON d.doc_type_id = dt.id'
			. ' WHERE d.applicant_id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data->files = $this->_db->loadObjectList();

			// work experiences
			$query = 'SELECT we.*'
			. ' FROM `#__phd_work_experiences` AS we'
			. ' WHERE we.applicant_id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data->work_experience = $this->_db->loadObjectList();

			// programmes
			$query = 'SELECT ap.programme_id, ap.order, p.description'
			. ' FROM `#__phd_applicant_programme` AS ap'
			. ' LEFT JOIN `#__phd_programmes` AS p'
			. ' ON ap.programme_id = p.id'
			. ' WHERE ap.applicant_id = ' . $this->_id
			. ' ORDER BY ap.order'
			;
			$this->_db->setQuery($query);
			$this->_data->programmes = $this->_db->loadObjectList();
				
			// get referees
			$query = 'SELECT r.*'
			. ' FROM `#__phd_referees` AS r'
			. ' WHERE r.applicant_id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data->referees = $this->_db->loadObjectList();
				
			// get ethical issues
			$query = 'SELECT aei.*, ei.description'
			. ' FROM `#__phd_applicant_ethical_issue` AS aei'
			. ' LEFT JOIN `#__phd_ethical_issues` AS ei ON ei.id = aei.ethical_issue_id'
			. ' WHERE aei.applicant_id = ' . $this->_id
			;
			$this->_db->setQuery($query);
			$this->_data->ethical_issues_list = $this->_db->loadObjectList();
			$this->_data->ethical_issue_text = "";
			foreach($this->_data->ethical_issues_list as $value) {
				$this->_data->ethical_issue_text .= $value->description . ", ";
			}
			// remove the two last characters
			$this->_data->ethical_issue_text = substr($this->_data->ethical_issue_text, 0, -2);
			
			// get committee
			$query = 'SELECT uc.*, u.name'
			. ' FROM `#__phd_applicant_user_committee` AS uc'
			. ' LEFT JOIN `#__users` AS u ON u.username = uc.user_committee_username'
			. ' WHERE uc.applicant_id = ' . $this->_id
			. ' ORDER BY uc.id'
			;
			$this->_db->setQuery($query);
			$this->_data->committee_list = $this->_db->loadObjectList();
				
			return (boolean) $this->_data;
		}
		return true;
	}

	/**
	 * Method to initialise the applicant data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function _initData()
	{
		// Lets load the content if it doesn't already exist
		if (empty($this->_data))
		{
			$applicant = new stdClass();
			$applicant->id = 0;
			$applicant->firstname = null;
			$applicant->lastname = null;
			$applicant->gender_id = null;
			$applicant->passport = null;
			$applicant->birth_date = null;
			$applicant->birth_country_id = null;
			$applicant->street = null;
			$applicant->city = null;
			$applicant->postalcode = null;
			$applicant->country_id = null;
			$applicant->telephone = null;
			$applicant->email = null;
			$applicant->wheredidu_id = null;
			$applicant->other_fellowships = null;
			$applicant->other_fellowships_text = null;
			$applicant->career_breaks = null;
			$applicant->career_breaks_text = null;
			$applicant->career_breaks_filename = null;
			$applicant->additional_info = null;
			$applicant->phd_thesis = null;
			$applicant->expected_lecture = null;
			$applicant->research_experience = null;
			$applicant->ethical_issue = null;
			$applicant->ethical_issue_text = null;
			$applicant->user_username = null;
			$applicant->status_id = 1;
			$applicant->academic_data = array();
			$applicant->work_experiences = array();
			$applicant->referees = array();
			$applicant->files = array();
			$applicant->selections = array();

			// 2014-09-23 Roberto Copiando el código de Albert Moreno
			$applicant->directory = null;
				
			$this->_data = $applicant;

			return (boolean) $this->_data;
		}
		return true;
	}


	/**
	 * Method to save Personal Data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function savePersonalData($data)
	{
		$applicant_id = $this->_store($data, 'personaldata');
		if ($applicant_id){
			return $applicant_id;
		}
		return false;
	}


	/**
	 * Method to save Academic data
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveAcademicData($data){
		$store_id = $this->_store($data,'degree');
		if ($store_id){
			return $store_id;
		}
		return false;
	}

	/**
	 * Method to save a File
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveFile($data){
		$store_id = $this->_store($data,'doc');
		if ($store_id){
			return $store_id;
		}
		return false;
	}

	/**
	 * Method to save a Referee
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveReferee($data)
	{
		if (!$this->_store($data, 'referee')) {
			return false;
		}
		return true;
	}

	/**
	 * Method to save Work Experience
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveWorkExperience($data){
		$store_id = $this->_store($data,'workexperience');
		if ($store_id){
			return $store_id;
		}
		return false;
	}

	/**
	 * Method to save the programmes
	 *
	 * @param object $data Data to be saved
	 * @return int The row identifier. FALSE in case of error
	 */
	function saveProgramme($data)
	{
		$row =& $this->getTable('applicantprogramme');

		// Bind the form fields to the table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the table
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		} else {
			// returns the id
			return $row->id;
		}
	}


	/**
	 * Method to save additional info
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function saveInfo($applicant_id,$additional_info){
		$db    =& JFactory::getDBO();

		$query = "INSERT INTO #__phd_applicants"
		. "	SET additional_info = '$additional_info'"
		. " WHERE id = '".$applicant_id."'"
		;
		$db->setQuery($query);
		if(!$db->query()) {
			die($db->stderr(true));
		}

		//echo JHTML::_('phdhelper.displayMessage',JText::_( 'DATA_CORRECTLY_SAVED' ),'ok');

		return true;
	}


	/**
	 * Save new status, check that the change is needed and log the change
	 *
	 * @param integer $new_status_id New status id
	 * @return bool true, false
	 */
	function saveStatus($new_status_id)
	{
		// setting the data
		$data = array();
		$data['id'] = $this->_data->id;
		if ( $new_status_id == '2' ) {
			$data['submit_date'] = date( 'Y-m-d H:i:s' );
		}
		$data['status_id'] = $new_status_id;

		if (!$this->_store($data, 'personaldata')) {
			return false;
		}

		return true;
	}



	/**
	 * Method to save ethical info
	 *
	 * @params integer $applicant_id
	 * @params integer $ethical_issue_id
	 * @return boolean	True on success
	 */
	function saveEthicalIssue($applicant_id, $ethical_issue_id)
	{
		$db =& JFactory::getDBO();

		$query = "INSERT INTO #__phd_applicant_ethical_issue(applicant_id, ethical_issue_id)"
		. "	VALUES(" . $applicant_id . ", ". $ethical_issue_id . ")"
		;
		$db->setQuery($query);
		if(!$db->query()) {
			die($db->stderr(true));
			return false;
		}
		return true;
	}



	/**
	 * Method to delete academic data
	 *
	 * @param int $id Academic data id
	 * @return boolean True on success, False otherwise
	 */
	function deleteAcademicData($id)
	{
		$query = 'DELETE FROM #__phd_degrees'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;
	}

	/**
	 * Method to delete a File
	 *
	 * @param int $id File id
	 * @return	boolean	True on success, False otherwise
	 */
	function deleteFile($id)
	{
		global $mainframe;

		$params =& $mainframe->getParams();
		$phdConfig_DocsPath = $params->get('phdConfig_DocsPath');

		$query = 'SELECT * FROM #__phd_docs'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery( $query );
		$file_details = $this->_db->loadObject();

                $model =& JModel::getInstance( 'applicant', 'phdmodel' );
                $model->setId( $file_details->applicant_id );
                $applicant =& $model->getData();                 
		
        $filepath = JPath::clean($phdConfig_DocsPath.DS.$applicant->directory.DS.$file_details->filename);
                
        //$filepath = JPath::clean(JPATH_ROOT.DS.$phdConfig_DocsPath.DS.$file_details->applicant_id.DS.$file_details->filename);

		if (!JFile::delete($filepath)) {
			//echo JText::_('ERROR_DELETING_FILE');
			return false;
		}

		$query = 'DELETE FROM #__phd_docs'
		. ' WHERE id = ' . $id
		;
		$this->_db->setQuery( $query );
		if(!$this->_db->query()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		return true;

	}

	/**
	 * Method to delete a referee
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function deleteReferee($id_referee,$applicant_id){
		global $mainframe;

		$params =& $mainframe->getParams();
		$phdConfig_DocsPath = $params->get('phdConfig_DocsPath');

		$model =& JModel::getInstance( 'applicant', 'phdmodel' );
		$model->setId($applicant_id);
		$applicant =& $model->getData();           

		$query = "SELECT * FROM #__phd_referees WHERE id='$id_referee'";
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			die($this->_db->stderr(true));
		}

		$file_details = $this->_db->loadObject();

		if (isset($file_details->filename)){
			$filepath = JPath::clean($phdConfig_DocsPath.DS.$applicant->directory.DS.$file_details->filename);
			
			if (!JFile::delete($filepath)) {
				//echo JText::_('ERROR_DELETING_FILE');
				return false;
			}
		}
		$query = "DELETE FROM #__phd_referees WHERE id='$id_referee'";

		$this->_db->setQuery( $query );
		if(!$this->_db->query()) {
			die($db->stderr(true));
		}
		return true;

	}

	/**
	 * Method to delete work experience
	 *
	 * @access	private
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	function deleteWorkExperience($id)
	{

		$query = "DELETE FROM #__phd_work_experiences"
		. " WHERE id = " . $id
		;
		$this->_db->setQuery( $query );
		if(!$this->_db->query()) {
			die($this->_db->stderr(true));
		}

		return true;
	}


	/**
	 * Delete previous programmes
	 *
	 * @param object $data Data to be deleted
	 * @return TRUE, FALSE
	 */
	function deleteProgrammes($data)
	{
		// delete previous programmes
		$query = 'DELETE FROM #__phd_applicant_programme'
		. ' WHERE applicant_id = ' . $data->applicant_id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			die($this->_db->stderr(true));
			return false;
		}
		return true;
	}


	/**
	 * Delete previous ethical issues
	 *
	 * @param object $data Data to be deleted
	 * @return TRUE, FALSE
	 */
	function deleteEthicalIssues($data)
	{
		// delete previous programmes
		$query = 'DELETE FROM #__phd_applicant_ethical_issue'
		. ' WHERE applicant_id = ' . $data->applicant_id
		;
		$this->_db->setQuery($query);
		if(!$this->_db->query()) {
			die($this->_db->stderr(true));
			return false;
		}
		return true;
	}

}