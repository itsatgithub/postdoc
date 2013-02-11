<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

/**
 * RAW View class for the register component
 */
class RegisterViewPapers extends JView {

	function display($tpl = null) {
		global $mainframe;
		$db 	=& JFactory::getDBO();

		$get = JRequest::get( 'get' );
		$id_congress = $get['id_congress'];

		//Get Active Congress
		$model_2 =& JModel::getInstance('congress', 'registermodel');
		$model_2->setId($id_congress);
		$congress =& $model_2->getData();

		$document =& JFactory::getDocument();
		$document->setName('Papers List PDF');
		$document->setTitle('Papers List');
		$document->setDescription('PDF exportion of Papers');
		$document->setMetadata('papers', 'papers');
		$document->setGenerator('');

		$query = 'SELECT *, a.id as author_id'
		. ' FROM `jos_reg_papers` AS p'
		. ' RIGHT JOIN `jos_reg_authors` AS a'
		. ' ON p.id = a.paper_id'
		. ' LEFT JOIN jos_reg_sessions AS s ON p.session_id = s.id'
		. ' LEFT JOIN jos_reg_paper_type AS pt ON p.paper_type_id = pt.id'
		. ' WHERE p.congress_id='. $congress->id
		. ' ORDER BY s.id, pt.id DESC, a.id'
		;

		echo $query;
		$db->setQuery( $query );
		$result = $db->loadObjectList();

		$paper_id = $title = $additional_info = $authors = $institution = null;
		foreach ($result as $row) {
			//print_r($row);
			if ($row->paper_id != $paper_id) {
				if (!is_null($title)){
					echo "<b>".$title."</b><br><i>".$authors."</i><br>".$institution."<br>".$additional_info."<br><br><br>";
				}
				$title = $row->title;
				$additional_info = "(session id: ".$row->session_id.", paper type id: ".$row->paper_type_id." )";
				if ($row->presenting_author_id == $row->author_id) {
					$authors = '<u>'.$row->initials.' '.$row->name.'</u>';
				} else {
					$authors = $row->initials.' '.$row->name;
				}
				$institution = $row->institution;
			} else {
				if ($row->presenting_author_id == $row->author_id) {
					$authors .= ', <u>'.$row->initials.' '.$row->name.'</u>';
				} else {
					$authors .= ', '.$row->initials.' '.$row->name;
				}
			}
			$paper_id = $row->paper_id;
		}
		echo "<b>".$title."</b><br><i>".$authors."</i><br>".$institution."<br>".$additional_info."<br><br><br>";
	}
}
?>