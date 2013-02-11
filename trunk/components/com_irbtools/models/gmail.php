<?php
/**
 * Joomla! 1.5 component irbtools
 *
 * @version $Id: gmail.php 2010-10-13 07:12:40 svn $
 * @author IRB Barcelona
 * @package Joomla
 * @subpackage irbtools
 * @license GNU/GPL
 *
 * IRB Barcelona Tools
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

require_once 'Zend/Loader.php';

// Google API
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Gapps');

/**
 * irbtools Component irbtools Model
 *
 * @author      IRB Barcelona
 * @package		Joomla
 * @subpackage	irbtools
 * @since 1.5
 */
class IrbtoolsModelGmail extends JModel
{
	/**
	 * Parameter
	 *
	 * @var char
	 */
	var $_google_domain = null;
	
	/**
	 * Parameter
	 *
	 * @var char
	 */
	var $_google_user = null;
	
	/**
	 * Parameter
	 *
	 * @var char
	 */
	var $_google_pass = null;
	
	/**
	 * Parameter
	 *
	 * @var object
	 */
	var $_google_lists = null;
		
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$params =& JComponentHelper::getParams( 'com_irbtools' );
    	$this->_google_user = $params->get( 'irbtoolsConfig_GoogleUser', '' );
    	$this->_google_pass = $params->get( 'irbtoolsConfig_GooglePass', '' );
		$this->_google_domain = $params->get( 'irbtoolsConfig_GoogleDomain', '' );		
		// subscripcion a las listas de correo
		$this->_google_lists = array();
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista1', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista2', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista3', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista4', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista5', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista6', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista7', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista8', '' );
		$this->_google_lists[] = $params->get( 'irbtoolsConfig_Lista9', '' );
	}
    
	/**
	* Returns a HTTP client object with the appropriate headers for communicating
	* with Google using the ClientLogin credentials supplied.
	*
	* @param string $user The username, in e-mail address format, to authenticate
	* @param string $pass The password for the user specified
	* @return Zend_Http_Client
	*/
	function getClientLoginHttpClient($user, $pass) 
	{
		$service = Zend_Gdata_Gapps::AUTH_SERVICE_NAME;
		$client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $service);
		return $client;
	}
    
	
	/**
     * Create gmail account
     * 
     * @param 
     * @return
     * 
     */
    function createAccount($username, $name, $surname, $password)
    {		
		// datos de conexion
		$client = $this->getClientLoginHttpClient($this->_google_user, $this->_google_pass);
		$gapps = new Zend_Gdata_Gapps($client, $this->_google_domain);
		
		// creacion de la cuenta
		$gapps->createUser($username, $name, $surname, $password);
				
		foreach($this->_google_lists as $key=>$value)
		{
			if ($value)
			{
				$gapps->addRecipientToEmailList($username . '@' . $this->_google_domain, $value);
			}
		}
		
		return true;
    }
}
?>