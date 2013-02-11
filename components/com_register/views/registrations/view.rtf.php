<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * RAW View class for the register component
 */
class RegisterViewRegistrations extends JView {

	function display($tpl = null) {
		global $mainframe, $option;
		$db 	=& JFactory::getDBO();

		$get = JRequest::get( 'get' );
		$id_congress = $get['id_congress'];

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($id_congress);
		$congress =& $model_2->getData();

		$query = 'SELECT *'
		. ' FROM `jos_reg_registrations` AS r'
		. ' LEFT JOIN `jos_reg_registration_type` AS rt'
		. ' ON r.registration_type_id = rt.id'
		. ' WHERE r.congress_id='. $congress->id
		. ' ORDER BY r.id'
		;

		$db->setQuery( $query );
		$result = $db->loadObjectList();

		foreach ($result as $row) {
			echo "<br><b>".$row->lastname.", ".$row->firstname."</b><br>";
			echo $row->institution."<br>";
			echo $row->description."<br>";
		}
	}
}
?>