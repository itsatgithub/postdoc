<?php
/**
 * PhD Helper file
 *
 * @author GPLavui.com <info@gplavui.com>
 * @version 1.5.0
 * @package PhD Programme
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * The class contains the functions used on different parts of the PhD application.
 *
 * @package PhD Programme
 */
class JHTMLPhdHelper
{
	/**
	 * Check if logged user is an Administrator
	 *
	 * @return boolean True => Administrator
	 */
	function isAdministrator()
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 1) { // role 1 is administrator
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if logged user is a Group Leader
	 *
	 * @return boolean True => Group Leader
	 */
	function isGroupLeader()
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;

		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 2) { // role 2 is group leader
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Check if logged user is a Commite
	 *
	 * @return boolean True => Commite
	 */
	function isCommittee()
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();
		if ($role_id == 3) { // role 2 is commite
			return true;
		} else {
			return false;
		}
	}


	/**
	 * get id applicant from username
	 *
	 * @param string $username username of the user
	 * @return integer Id => Applicant_id
	 */
	function getIdFromUsername($username)
	{
		$db    =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = "SELECT id "
		. " FROM `#__phd_applicants` AS a"
		. " WHERE a.user_username like '".$username."'"
		;

		$db->setQuery($query);
		return $db->loadResult();
	}

	/**
	 * Check Total Access variable from configuration
	 *
	 * @return boolean True for total access
	 */
	function totalAccess()
	{

	}

	/**
	 * Generate message
	 *
	 * @return text message
	 */
	/*
	 function displayMessage($message,$type)
	 {
		switch($type){
		case 'ok':
		$color = 'green';
		break;
		case 'ko':
		$color = 'red';
		break;
		default:
		$color = 'blue';
		break;
		}

		return	"<table width='100%' border='0' align='center' bordercolor='".$color."'>
		<tr align='center'>
		<td bgcolor='".$color."'><font color=white><b>".$message."</b></font></td>
		</tr>
		</table>";
		}
		*/

	/**
	 * Generate message
	 *
	 * @return text message
	 */
	function canApply($applicant)
	{
		global $mainframe;
		$params = &JComponentHelper::getParams( 'com_phd' );
		//$params =& $mainframe->getParams();

		$phdConfig_ClosingDateTime = $params->get('phdConfig_ClosingDateTime');
		$phdConfig_LimitAge = (int) $params->get('phdConfig_LimitAge');

		$dateNow = new JDate();
		$closing_date = new JDate( $phdConfig_ClosingDateTime );
		$birth_date = new JDate( $applicant->birth_date );
		//echo 'Cierre ' . $closing_date->toFormat() . '<br>';
		//echo 'Nacimiento ' . $birth_date->toFormat() . '<br>';
		//echo 'Ahora ' . $dateNow->toFormat() . '<br>';

		$apply_details = new stdClass();

		// passed by??
		if ( $dateNow->toUnix() > $closing_date->toUnix() )
		{
			$apply_details->message = JText::_('TEXT_TO_SUBMIT_PASSED_BY');
			$apply_details->disabled = 'disabled';
			return $apply_details;
		}

		// date lime to be born??
		$date_limit = strtotime( '- ' . $phdConfig_LimitAge . ' year', strtotime( $closing_date->toFormat() ) );
		$date_limit = date( 'Y-m-j', $date_limit );
		//echo 'Fecha limite ' . $date_limit . '<br>';

		if ( $applicant->birth_date < $date_limit )
		{
			// can not apply
			$apply_details->message = JText::sprintf('TEXT_TO_SUBMIT_NO_AGE',$phdConfig_LimitAge);
			$apply_details->disabled = 'disabled';
			return $apply_details;
		}

		// all right
		$apply_details->message = JText::_('TEXT_TO_SUBMIT');
		$apply_details->disabled = '';
		return $apply_details;
	}

	/**
	 * Generate message
	 *
	 * @return text message
	 */
	function canApplyBirthDate($param_birth_date)
	{
		global $mainframe;
		$params = &JComponentHelper::getParams( 'com_phd' );
		//$params =& $mainframe->getParams();

		$phdConfig_ClosingDateTime = $params->get('phdConfig_ClosingDateTime');
		$phdConfig_LimitAge = (int) $params->get('phdConfig_LimitAge');

		$dateNow = new JDate();
		$closing_date = new JDate( $phdConfig_ClosingDateTime );
		$birth_date = new JDate( $param_birth_date );
		
		//echo 'Cierre ' . $closing_date->toFormat() . '<br>';
		//echo 'Nacimiento ' . $birth_date->toFormat() . '<br>';
		//echo 'Ahora ' . $dateNow->toFormat() . '<br>';

		$apply_details = new stdClass();

		// passed by??
		if ( $dateNow->toUnix() > $closing_date->toUnix() )
		{
			$apply_details->message = JText::_('TEXT_TO_SUBMIT_PASSED_BY');
			$apply_details->disabled = 'disabled';
			return $apply_details;
		}

		// date lime to be born??
		$date_limit = strtotime( '- ' . $phdConfig_LimitAge . ' year', strtotime( $closing_date->toFormat() ) );
		$date_limit = date( 'Y-m-j', $date_limit );
		//echo 'Fecha limite ' . $date_limit . '<br>';

		if ( $param_birth_date < $date_limit )
		{
			// can not apply
			$apply_details->message = JText::sprintf('TEXT_TO_SUBMIT_NO_AGE',$phdConfig_LimitAge);
			$apply_details->disabled = 'disabled';
			return $apply_details;
		}

		// all right
		$apply_details->message = JText::_('TEXT_TO_SUBMIT');
		$apply_details->disabled = '';
		return $apply_details;
			}
	
	
	/**
	 * get messages
	 *
	 * @param string $id_message message id
	 * @return object Message
	 */
	function getMessage($id_message)
	{
		global $mainframe;
		
		$params =& $mainframe->getParams();
		$email = new stdClass();
		$email->mail_subject = $params->get('phdConfig_EmailApplicantSubject' . $id_message);
		$email->mail_body = $params->get('phdConfig_EmailApplicantBody' . $id_message);
		return $email;
		/*
		$db =& JFactory::getDBO();

		$query = 'SELECT * FROM #__phd_status'
		. ' WHERE id = ' . $id_message
		;
		$db->setQuery( $query );
		$row = $db->loadObject();
		*/
	}

	/**
	 * Check if the personal data have been introduced and saved for the applicant
	 *
	 * @param integer $applicant_id identifier of the applicant
	 * @return boolean true if the personal data have been introduced correctly, false if not
	 */
	function applicationDataExists($applicant_id) {
		$db    =& JFactory::getDBO();

		$query = "SELECT *
		FROM #__phd_applicants
		WHERE (id = '$applicant_id'
		AND passport != ''
		AND birth_date != '0000-00-00'
		AND street != ''
		AND city != ''
		AND postalcode != ''
		AND country_id != ''
		AND telephone != ''
		AND email != ''
		AND wheredidu_id != '')";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced a cv
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the cv exists
	 */
	function cvExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=1";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced his motivation letter
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the motivation letter exists
	 */
	function motivationLetterExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=2";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced his academic records
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the academic records exists
	 */
	function academicRecordsExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=3";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced his eligibility form
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the records exists
	 */
	function eligibilityFormExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=4";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}
	
	/**
	 * Check if a determinate user have already introduced his phd certificate
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the phd certificate record exists
	 */
	function phdCertificateExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=6";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced his list of publications
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the list of publications exists
	 */
	function listPublicationsExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_docs
			WHERE applicant_id = '$applicant_id' AND doc_type_id=5";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced his degrees
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the degree exists
	 */
	function degreeExists($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT *
			FROM #__phd_degrees
			WHERE applicant_id = '$applicant_id'";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already introduced at least two referees
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if the references are introduced
	 */
	function checkReferees($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT * "
		. "FROM #__phd_referees "
		. "WHERE applicant_id = '$applicant_id'";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows) > 1)
		return true;
		return false;
	}

	/**
	 * Check if a determinate user have already selected at least one programme
	 *
	 * @param integer $applicant_id Applicant id
	 * @return bool True if a program is selected
	 */
	function checkProgramme($applicant_id) {
		$db    =& JFactory::getDBO();
		$query = "SELECT * "
		. "FROM #__phd_applicant_programme "
		. "WHERE applicant_id = '$applicant_id'";
		$db->setQuery( $query );
		$rows = $db->loadObjectList();
		if (count($rows))
		return true;
		return false;
	}

	/**
	 * Check if a user have write access to a tab
	 *
	 * @return bool True if the user can write. False otherwise.
	 */
	function canWrite($id)
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT *'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;
		$db->setQuery($query);
		$phd_user = $db->loadObject();

		$role_id = (isset($phd_user->role_id))?$phd_user->role_id:'';
		switch ($role_id)
		{
			case 1:
				{
					return true; // admin can always write
				} break;
					
			case 2:
				{
					return false; // group leaders can not write
				} break;
					
			case 3:
				{
					return false; // committe can not write
				} break;
					
			default:
				{
				 if (!$id) {
				 	return true; // I am a new registrant, so I can write
				 }
				 	
				 // check if I am the user
				 $query = 'SELECT *'
				 . ' FROM #__phd_applicants AS a'
				 . ' WHERE a.id = ' . $id
				 . ' AND a.user_username = \'' . $user->username . '\''
				 ;
				 $db->setQuery($query);
				 $applicant = $db->loadObject();
				 if ($applicant) {
				 	// check if the status = 1 (editing)
				 	if ($applicant->status_id == 1) {
				 		return true; // the user can write
				 	} else {
				 		return false; // the user can not write
				 	}
				 } else {
				 	return false; // I am not the user
				 }
				} break;
		}
	}


	/**
	 * Check if a user have read access to the applicant's data
	 *
	 * @param int $id Applicant id
	 * @return bool True if the user can read. False otherwise.
	 */
	function canRead($id)
	{
		$db =& JFactory::getDBO();
		$user =& JFactory::getUser();

		$query = 'SELECT *'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;
		$db->setQuery($query);
		$phd_user = $db->loadObject();

		$role_id = (isset($phd_user->role_id))?$phd_user->role_id:'';
		switch ($role_id)
		{
			case 1:
				{
					if (!$id) {
						return false; // can not create users
					}
					return true; // admin always read
				} break;
					
			case 2:
				{
					if (!$id) {
						return false; // can not create users
					}
					// if the user is a GL, can not read his own user
					if ($phd_user->id == $id ) {
						return false;
					}
					// check if the user has selected the GL's programme
					$query = 'SELECT *'
					. ' FROM #__phd_applicants AS a'
					. ' LEFT JOIN #__phd_applicant_programme AS ap ON ap.applicant_id = a.id'
					. ' LEFT JOIN #__phd_programmes AS pro ON pro.id = ap.programme_id'
					. ' LEFT JOIN #__phd_users AS u ON u.user_username = pro.user_username'
					. ' WHERE a.id = ' . $id
					. ' AND a.status_id = 2'
					. ' AND u.user_username = \'' . $user->username . '\''
					;
					$db->setQuery($query);
					if ($db->loadObject()) {
						return true; // the user has the programme
					} else {
						return false; // the user does not have the programme
					}
				} break;
					
			case 3:
				{
					if (!$id) {
						return false; // can not create users
					}
					// check if the candidate has this committee
					$query = 'SELECT *'
					. ' FROM #__phd_applicants AS a'
					. ' LEFT JOIN #__phd_applicant_user_committee AS uc ON uc.applicant_id = a.id'
					. ' WHERE a.id = ' . $id
					. ' AND a.status_id != 1' // not editing
					. ' AND a.status_id != 7' // not discarded
					. ' AND uc.user_committee_username = \'' . $user->username . '\''
					;
					$db->setQuery($query);
					if ($db->loadObject()) {
						return true; // the candidate has the committee
					} else {
						return false; // the candidate does not have the committee
					}
				} break;
					
			default:
				{
				 if (!$id) {
				 	return true; // I am a new registrant, so I can read
				 }
				 // check if I am the user
				 $query = 'SELECT *'
				 . ' FROM #__phd_applicants AS a'
				 . ' WHERE a.id = ' . $id
				 . ' AND a.user_username = \'' . $user->username . '\''
				 ;
				 $db->setQuery($query);
				 $applicant = $db->loadObject();
				 if ($applicant) {
				 	return true; // I am the user or I am a new user
				 } else {
				 	return false; // I am not the user
				 }
				} break;
		}
	}



	/**
	 * Check if a tab must be shown
	 *
	 * @return bool True if the user can write. False otherwise.
	 * @param integer $tab_id Tab identifier
	 */
	function showTab($tab_id)
	{
		global $mainframe;

		$db =& JFactory::getDBO();
		$params =& $mainframe->getPageParameters('com_phd');
		$application = $params->get('phdConfig_Application');

		$query = 'SELECT show'
		. ' FROM #__phd_tab_application'
		. ' WHERE tab_id = ' . $tab_id
		. ' AND application_id = ' . $application
		;
		$db->setQuery($query);
		$show = $db->loadResult();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}

		// if it does not be shown
		if (!$show) {
			return false;
		}

		// check the role permissions
		$user =& JFactory::getUser();

		$query = 'SELECT role_id'
		. ' FROM #__phd_users'
		. ' WHERE user_username = \'' . $user->username . '\''
		;
		$db->setQuery($query);
		$role_id = $db->loadResult();

		$query = 'SELECT ri.short_description'
		. ' FROM #__phd_role_tab_right AS rtr'
		. ' LEFT JOIN #__phd_roles AS ro ON ro.id = rtr.role_id'
		. ' LEFT JOIN #__phd_tabs AS t ON t.id = rtr.tab_id'
		. ' LEFT JOIN #__phd_rights AS ri ON ri.id = rtr.right_id'
		. ' WHERE ro.id = ' . $role_id
		. ' AND t.id = ' . $tab_id
		;
		$db->setQuery($query);
		$rights = $db->loadResult();
		if ($rights == 'read') {
			return true;
		} else {
			return false;
		}

	}


	/**
	 * Generates an HTML table of checkboxes
	 *
	 * @param array An array of objects
	 * @returns string HTML
	 */
	function getEthicalIssuesList( $applicant_id, $arr )
	{
		$db =& JFactory::getDBO();

		// getting the ethical issues
		$query = 'SELECT ei.*'
		. ' FROM `#__phd_ethical_issues` AS ei'
		. ' ORDER BY ei.order'
		;
		$db->setQuery($query);
		$ethical_issues = $db->loadObjectList();

		// building the html
		$html = "<table border='0'>";
			
		foreach($ethical_issues as $item)
		{
			// new row
			$html .= "<tr>";
			$html .= "<td>";
				
			// is the ethical issue selected?
			$query = 'SELECT aei.*'
			. ' FROM `#__phd_applicant_ethical_issue` AS aei'
			. ' WHERE aei.applicant_id = ' . $applicant_id
			. ' AND aei.ethical_issue_id = ' . $item->id
			;
			$db->setQuery($query);
			$row = $db->loadObject();
			if ($row->id) {
				$html .= "<input name='ei[]' type='checkbox' value='" .$item->id . "' checked> " . $item->description;
			} else {
				$html .= "<input name='ei[]' type='checkbox' value='" .$item->id . "'> " . $item->description;
			}

			// ending row
			$html .= "</td>";
			$html .= "</tr>";
		}
		$html .= "</table>";

		return $html;
	}

}