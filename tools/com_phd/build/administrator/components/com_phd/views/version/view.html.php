<?php defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

class PhdViewVersion extends JView
{
	function display($tpl = null)
	{
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_phd'.DS .'helpers'.DS.'phdinstallhelper.php');
		
		$local = JHTML::_('phdinstallhelper.getVersionLocal');
		$remote = JHTML::_('phdinstallhelper.getVersionRemote');
		
		$this->assignRef('vlocal', $local);
		$this->assignRef('vremote', $remote);

		parent::display($tpl);
	}
}
?>
