<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
jimport('joomla.utilities.date');
jimport('joomla.filesystem.file');
jimport('joomla.mail.mail');
jimport('joomla.methods');
jimport('joomla.error.log' );

/**
 * Applicants Controller
 *
 * @author	GPLavui.com <info@gplavui.com>
 * @version	1.5.0
 * @package	PhD Programme
 */
class PhdControllerApplicants extends JController
{

	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display()
	{
		// Make sure we have a default view
		if( !JRequest::getVar( 'view' )) {
			JRequest::setVar('view', 'applicants' );
		}

		parent::display();
	}

	function delete()
	{
		//get data from the request
		$get = JRequest::get( 'get' );
		$id = $get['id'];

		$model = $this->getModel( 'applicant' );
		if( $model->delete( $id ) ) {
			$msg = JText::_('APPLICANT_DEL_OK');
		} else {
			$msg = JText::_('APPLICANT_DEL_KO');
		}
		$this->setRedirect(JRoute::_('index.php?option=com_phd&view=applicants', false), $msg);
	}
	
	function make_total_zip()
	{
		global $mainframe;
	
		//get data from the request
		$get = JRequest::get( 'get' );
	
		$params =& $mainframe->getParams();
		$phdConfig_DocsPath = $params->get('phdConfig_DocsPath');
		
		$model =& JModel::getInstance( 'applicants', 'phdmodel' );
		$items =& $model->getData();
		
		$z = new ZipArchive();
		$log_zip = &JLog::getInstance('create_zip.log'); //fichero de log en (joomla)/logs
		$log_zip->addEntry(array('comment' =>'Starting ZIP'));
		$filename = 'all_candidates.zip';
		$outZipPath =  JPATH_ROOT . '/tmp/' . $filename;
		$z->open($outZipPath, ZIPARCHIVE::CREATE);
			
		foreach ($items as $applicant)
		{
			$sourcePath = $phdConfig_DocsPath."/".$applicant->directory;
			$pathInfo = pathInfo($sourcePath);
			$parentPath = $pathInfo['dirname'];
			$dirName = $pathInfo['basename'];
		
			$log_zip->addEntry(array('comment' => 'sourcePath:'
				.$sourcePath.',outPath:'
				.$outZipPath.'pathInfo:'
				.$pathInfo.',parentPath:'
				.$parentPath.',dirName:'
				.$dirName));

			$z->addEmptyDir($dirName);
			$exclusiveLength = strlen("$parentPath/");
			$folder = $sourcePath;
			$zipFile = $z;
			
			$handle = opendir($folder);
			while (false !== $f = readdir($handle)) {
				if ($f != '.' && $f != '..') {
					$filePath = "$folder/$f";
					$localPath = substr($filePath, $exclusiveLength);
					if (is_file($filePath)) {
						$zipFile->addFile($filePath, $localPath);
						$log_zip->addEntry(array('comment' =>'Added file '.$localPath.' to '.$filePath));
					} elseif (is_dir($filePath)) {
						$log_zip->addEntry(array('comment' =>'Added dir '.$localPath));
					}
				}
			}
			closedir($handle);
		}
		
		$log_zip->addEntry(array('comment' =>'Ending ZIP'));
		$z->close();
				
		//LOG all logins
		$user 	=& JFactory::getUser();
		$options = array('format' => "{DATE}\t{TIME}\t{IP}\t{NAME}\t{FILENAME}\t{APPLICANT}");
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$log_filename= "file_access-".date( 'M-Y').".log";
		$log = & JLog::getInstance($log_filename, $options);
		$log->addEntry(array("Date" => date('d-m-Y'),"Time" => date('h:i'),"IP" => $ip_address,"Name"=>$user->name,"Filename"=>$filename,"Applicant"=>$applicant->lastname.', '.$applicant->firstname));
		//END LOG
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/zip');
		header('Content-Disposition: attachment; filename='.$filename);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($outZipPath));
		ob_clean();
		readfile($outZipPath);
		
		exit;
	}
}
?>