<?php
/**
 * Joomla! 1.5 component Jobs
 *
 * @version $Id: controller.php 2010-10-22 10:02:57 svn $
 * @author Albert Moreno
 * @package Joomla
 * @subpackage Jobs
 * @license GNU/GPL
 *
 * Application to apply to ICMAB positions
 *
 * This component file was created using the Joomla Component Creator by Not Web Design
 * http://www.notwebdesign.com/joomla_component_creator/
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.utilities.date');
jimport('joomla.filesystem.file');
jimport('joomla.mail.mail');
jimport('joomla.methods');

/**
 * Jobs Component Controller
 */
class LayarController extends JController {

	function display() {
		// Make sure we have a default view
		if( !JRequest::getVar( 'view' )) {
			JRequest::setVar('view', 'jobs' );
		}
		parent::display();
	}

	/**
	 * Save personal data
	 *
	 * @since	1.5
	 */
	function save_poi()
	{
		global $mainframe;
		$params =& $mainframe->getParams();
		$layarConfig_LiveSite = $params->get('layarConfig_LiveSite');

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );
		//$iamadministrator = JHTML::_('helper.isAdministrator');

		$model =& $this->getModel('poi');

		//get data from the request
		$post = JRequest::get( 'post' );

		$post['attribution'] = JRequest::getVar('attribution', '', 'post', 'string', JREQUEST_ALLOWRAW);	

		if (!isset($post['id'])){
			$poi_id = $model->savePoiData($post);
			$post['id'] = $poi_id;
		} else {
			$poi_id = $post['id'];
		}
		$model->setId($poi_id);
		$poi =& $model->getData();

		list($post['lat'], $post['lon']) = split('[,;-]', $post['latlon']);

		$file = JRequest::getVar('uploadedfile', '', 'FILES', 'array');
		$file['name']  = JFile::makeSafe($file['name']);
		$extension = strtolower(JFile::getExt($file['name']) );

		$filepath = JPath::clean(JPATH_ROOT.DS.$post['layer_id'].DS.$file['name']);

		if ((isset($file['name'])) && (!$file['error'])) {

			if (JFile::exists($filepath)) {
				$mainframe->enqueueMessage( JText::_('FILE_EXISTS') , 'error');
				parent::display();
				return;
			}
	
			if ( ($extension == 'gif') || ($extension == 'png') || ($extension == 'jpg')) {
				if (!JFile::upload($file['tmp_name'], $filepath)) {
					$mainframe->enqueueMessage( JText::_('ERROR_UPLOADING') , 'error');
					parent::display();
					return;
				}
			} else {
				$mainframe->enqueueMessage( JText::_('ERROR_EXTENSION') , 'error');
				parent::display();
				return;
			}

			$post['imageURL'] = $layarConfig_LiveSite.DS.$post['layer_id'].DS.$file['name'];
			$post['image'] = $file['name'];

			//remove old file
			if (!empty($poi->image)){
				//$parsed_url = parse_url($poi->imageURL, PHP_URL_PATH);
				$filepath_to_delete = JPath::clean(JPATH_ROOT.DS.$poi->layer_id.DS.$poi->image);

				if (!JFile::delete($filepath_to_delete)) {
					$mainframe->enqueueMessage( JText::_('ERROR_DELETING_FILE') , 'error');
					//return;
				}
			}

		}

		// store data. the function returns the saved id
		$poi_id = $model->savePoiData($post);

		JRequest::setVar('view', 'poi' );
		JRequest::setVar('id', $poi_id );

		if ($poi_id) {
			$mainframe->enqueueMessage( JText::_('POI_STORE_OK') );
			parent::display();
		} else {
			$mainframe->enqueueMessage( JText::_('POI_STORE_KO') , 'error');
			parent::display();
			return false;
		}
	}

	function delete() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get( 'get' );

		// store data. the function returns the saved id
		$model =& $this->getModel('poi');
		$poi_id = $get['id'];
		$operation = $model->delete($poi_id);

		JRequest::setVar('view', 'pois' );

		if ($operation) {
			$mainframe->enqueueMessage( JText::_('DELETION_OK') );
			parent::display();
		} else {
			$mainframe->enqueueMessage( JText::_('DELETION_KO') , 'error');
			parent::display();
			return false;
		}
	}

	/**
	 * Save doc file
	 *
	 * @since	1.5
	 */
	function save_action()
	{
		global $mainframe;

		//get data from the request
		$post = JRequest::get( 'post' );

		// store data. the function returns the saved id
		$model =& $this->getModel('poi');
		$poi_id = $post['id'];
		$data['label'] = $post['label'];
		$data['uri'] = $post['uri'];
		$data['poiID'] = $poi_id;

		$data['autoTriggerRange'] = '5000';
		$data['autoTriggerOnly'] = '0';
		$data['activityType'] = $post['actiontype_id'];

		switch($post['actiontype_id']){
			case 1:
				$data['contentType'] = 'text/html';
				break;
			case 2:
				$data['contentType'] = 'audio/mpeg';
				break;
			case 3:
				$data['contentType'] = 'video/mp4';
				break;
			case 4:
				$data['uri'] = "tel:+34".$data['uri'];
				$data['contentType'] = 'application/vnd.layar.internal';
				break;
			case 5:
				$data['uri'] = "mailto:".$data['uri'];
				$data['contentType'] = 'application/vnd.layar.internal';
				break;
			case 6:
				$data['uri'] = "sms:".$data['uri'];
				$data['contentType'] = 'application/vnd.layar.internal';
				break;
			case 7:
				$data['contentType'] = 'text/plain';
				break;
			default:
				$data['contentType'] = 'application/vnd.layar.internal';
				break;
		}

		$store = $model->saveAction($data);

		JRequest::setVar('view', 'poi' );
		JRequest::setVar('id', $poi_id );

		if ($store) {
			$mainframe->enqueueMessage( JText::_('ACTION_STORE_OK') );
			parent::display();
			return true;
		} else {
			$mainframe->enqueueMessage( JText::_('ACTION_STORE_KO') , 'error');
			parent::display();
			return false;
		}
	}

	/**
	 * Delete document
	 *
	 * @since	1.5
	 */
	function del_action() {
		global $mainframe;

		//get data from the request
		$get = JRequest::get( 'get' );

		// store data. the function returns the saved id
		$model =& $this->getModel('poi');
		$poi_id = $get['id'];
		$store = $model->deleteAction($get['action_id']);

		JRequest::setVar('view', 'poi' );
		JRequest::setVar('id', $poi_id );

		if ($store) {
			$mainframe->enqueueMessage( JText::_('ACTION_DELETION_OK') );
			parent::display();
			return true;
		} else {
			$mainframe->enqueueMessage( JText::_('ACTION_DELETION_KO') , 'error');
			parent::display();
			return false;
		}
	}

}
?>