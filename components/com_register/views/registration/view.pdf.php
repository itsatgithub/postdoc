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
class RegisterViewRegistration extends JView {
	function display($tpl = null) {
		global $mainframe;
		$db 	=& JFactory::getDBO();

		$get = JRequest::get( 'get' );
		$registration_id = $get['registration_id'];

		//Get Registered Person
		$model =& JModel::getInstance('registration', 'registermodel');
		$model->setId($registration_id);
		$registration =& $model->getData();

		$document =& JFactory::getDocument();
		$document->setName('Papers List PDF');
		$document->setTitle('Papers List');
		$document->setDescription('PDF exportion of Papers');
		$document->setMetadata('papers', 'papers');
		$document->setGenerator('');

		echo "<table border='1'><tr>
		MATGAS 2000, AIE<br>
		Campus de la Universitat Autònoma de Barcelona<br>
		08193 Bellaterra (Barcelona)<br>
		Tel: 935929950 -  Fax: 935929951<br>
		NIF: V-62610613<br>
		</tr><tr>"
		.$registration->lastname.", ".$registration->firstname."<br>"
		.$registration->invoice_institution."<br>"
		.$registration->invoice_cif."<br>"
		.$registration->invoice_address."<br>"
		.$registration->invoice_city."<br>"
		.$registration->invoice_zip."<br>"
		.$registration->invoice_country."<br>
		</tr></table>";

	}
}
?>