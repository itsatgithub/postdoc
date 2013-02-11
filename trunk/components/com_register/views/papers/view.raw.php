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

//If there is warnings the excel file will not work
ini_set('display_errors','0');
error_reporting (E_ALL);

jimport( 'joomla.application.component.view');

require_once("components/com_register/includes/excel.php");
require_once("components/com_register/includes/excel-ext.php");

/**
 * RAW View class for the register component
 */
class RegisterViewPapers extends JView {

	function display($tpl = null) {
		global $mainframe, $option;

		// Initialize some variables
		$db 	=& JFactory::getDBO();
		$uri	=& JFactory::getURI();

		$this->assign('action',$uri->toString());

		$get = JRequest::get( 'get' );
		$id_congress = $get['id_congress'];

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($id_congress);
		$congress =& $model_2->getData();


		$query = "SELECT r.*, rt.description as registration_type, pt.description as payment_type
FROM `jos_reg_registrations` as r
LEFT JOIN `jos_reg_registration_type` as rt
ON r.registration_type_id = rt.id
LEFT JOIN `jos_reg_payment_type` as pt
ON r.payment_type_id = pt.id
WHERE r.congress_id=". $congress->id ."AND
registration_date IS NOT NULL";

		$db->setQuery( $query );

		$result = $db->loadObjectList();
		//print_r($result);die;
		$display = array();

		/*foreach ($result as $row) {
			$display[] = array("Id"=>$row->id, "Title"=>$row->title, "Type of presentation"=>$row->type, "Session"=>$row->session, "Intitution"=>$row->institution, "Presenting Author Name"=>$row->name, "Presenting Author Initials"=>$row->initials, "E-mail"=>$row->email, "Filename"=>$row->filename, "Link"=>$link);
			}*/

		createExcel("excel-array.xls", $display);
		exit;
	}
}
?>