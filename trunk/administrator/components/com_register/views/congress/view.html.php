<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class RegisterViewCongress extends JView
{
	function display($tpl = null)
	{
		global $mainframe;

		if($this->getLayout() == 'form') {
			$this->_displayForm($tpl);
			return;
		}

		parent::display($tpl);
	}

	function _displayForm($tpl)
	{
		global $mainframe, $option;

		$db		=& JFactory::getDBO();
		$uri 	=& JFactory::getURI();
		$user 	=& JFactory::getUser();
		$model	=& $this->getModel();

		$lists = array();

		//get the congress
		//Get Active Congress
		$congress =& $this->get('data');

		// build list of countries
		$query = "SELECT id AS value, name AS text "
		. "\n FROM `jos_reg_countries`"
		;
		$db->setQuery($query);
		$countrylist[] = JHTML::_('select.option',  '0', JText::_( '- Select Country -' ), 'value', 'text');
		$countrylist = array_merge( $countrylist, $db->loadObjectList() );
		$lists['countries'] = JHTML::_('select.genericlist', $countrylist, 'country_id', 'class="inputbox" size="1"','value', 'text', $congress->country_id );

		//		$debug_value = ($congress->debug)?$congress->debug:0;
		$lists['debug'] = JHTML::_('select.booleanlist', 'debug' , '', $congress->debug ,'Yes', 'Not');

		// Imagelist
		$javascript			= 'onchange="changeDisplayImage();"';
		$directory			= '/images/banners';
		$lists['imageurl']	= JHTML::_('list.images', 'picture', $congress->picture, $javascript, $directory, "bmp|gif|jpg|png|swf"  );

		//clean weblink data
		JFilterOutput::objectHTMLSafe( $congress, ENT_QUOTES, 'description' );

		//$params = new JParameter( $congress->params, $file ); Si hay XML file
		$params = new JParameter( $congress->params);

		$this->assignRef('lists', $lists);
		$this->assignRef('congress', $congress);
		$this->assignRef('params', $params);
		$this->assignRef('user', $user);


		parent::display($tpl);
	}
}
