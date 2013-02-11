<?php
/**
 * Joomla! 1.5 component register
 *
 * @version $Id: view.feed.php 2009-07-07 09:14:21 svn $
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

// Require the base controller
require_once JPATH_COMPONENT.DS.'assets'.DS.'fdf.php';
jimport( 'joomla.application.component.view');

/**
 * Feed View class for the register component
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

		$pdf_fdf = new pdf_fdf();

		$template_pdf = JPATH_COMPONENT.DS.'assets'.DS.'factura_matgas.pdf';

		$description = utf8_decode('SAFT 2010 Inscription');

		$invoice_client = utf8_decode($registration->lastname).", ".utf8_decode($registration->firstname)."\n"
		.utf8_decode($registration->invoice_institution)."\n"
		.utf8_decode($registration->invoice_address)."\n"
		.utf8_decode($registration->invoice_city)." ".$registration->invoice_zip."\n"
		.utf8_decode($registration->invoice_country)."\n"
		.utf8_decode($registration->invoice_cif)."\n";

		$invoice_cost_tva = $registration->cost*0.16;
		$invoice_total_cost = $registration->cost*1.16;

		// Fill in text fields
		$strings = array(
		'invoice_client' => $invoice_client,
		'invoice_client_code' => $registration->invoice_client_code,
		'invoice_number' => $registration->invoice,
		'invoice_date' => $registration->invoice_date,
		'invoice_payment_reference' => $registration->invoice_payment_reference,
		'invoice_amount' => '1',
		'invoice_cost' => $registration->cost,
		'invoice_cost_tva' => $invoice_cost_tva,
		'invoice_total_cost' => $invoice_total_cost,
		'invoice_description' => $description
		);

		/*$fdf_content = $pdf_fdf->Make($template_pdf,$strings);
		 Header('Content-type: application/vnd.fdf');
		 echo $fdf_content;
		 die;*/

		$fdf_file = $pdf_fdf->Save($template_pdf,$strings,'fdf_temp.fdf');

		$pdf_file = JPATH_COMPONENT.DS.'invoices'.DS.'invoice_'.$registration->id.'.pdf';
		$pdf_fdf->FDF2PDF('fdf_temp.fdf',$pdf_file);

		if (file_exists($pdf_file)) {
			// send open/save pdf dialog to user
			header('Cache-Control: public'); // needed for i.e.
			header('Content-Type: application/pdf');
			header('Content-Disposition: filename="invoice_'.$registration->id.'.pdf"');
			readfile($pdf_file);
			die(); // stop execution of further script because we are only outputting the pdf
		} else {
			die('Error: File not found.');
		}

	}
}
?>