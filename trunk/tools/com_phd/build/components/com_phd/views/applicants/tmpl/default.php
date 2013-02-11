<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('stylesheet', 'table.css', 'components/com_phd/assets/'); ?>

<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value = order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
</script>

<?php if ( $this->params->get( 'show_page_title', 1 ) ) : ?>
<div
	class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<?php echo $this->escape( JText::_( 'APPLICANTS_TOP_TABLE') ); ?></div>
<?php endif; ?>

<?php echo JText::_( 'APPLICANTS_INTRO' ); ?>
<br>
<br>

<form id="adminForm" action="<?php echo JRoute::_( 'index.php' );?>"
	method="post" name="adminForm" class="form-validate">
<table width="100%" class="table">
	<caption><?php echo JText::_( 'Filter' ); ?>: <input type="text"
		name="filter_search" id="filter_search"
		value="<?php echo $this->lists['search'];?>" class="text_area"
		onchange="document.adminForm.submit();" />
	<button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
	<button onclick="this.form.filter_search.value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
	<?php
	echo JText::_('Display Num') .'&nbsp;';
	echo $this->pagination->getLimitBox();
	?></caption>
	<?php
	if(count( $this->items ) != '0')
	{
		?>
	<thead>
		<tr class="sectiontableheader">
			<th width="30" class="white"><?php echo JHTML::_('grid.sort', 'Num', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="15%" height="20" scope='col'><?php echo JHTML::_('grid.sort', 'Firstname', 'firstname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th height="20" scope='col'><?php echo JHTML::_('grid.sort', 'Lastname', 'lastname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="15%" height="20" scope='col'><?php echo JHTML::_('grid.sort', 'Status', 'status', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="15%" height="20" scope='col'><?php echo JHTML::_('grid.sort', 'Submit date', 'submit_date', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="15" scope='col'></th>
		</tr>
	</thead>
	<?php
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$item =& $this->items[$i];
		$link = JRoute::_( 'index.php?option=com_phd&view=applicant&id=' . $item->id );
		$link_readonly = JRoute::_( 'index.php?option=com_phd&view=applicant&id=' . $item->id .'&readonly=true' );
		$del_link = JRoute::_( 'index.php?option=com_phd&controller=applicants&task=delete&id=' . $item->id );
		$pdf_link = JRoute::_( 'index.php?option=com_phd&view=applicant&format=pdf&tmpl=component&id=' . $item->id );
		?>
	<tbody>
		<tr class="sectiontableentry1">
			<!-- <tr class="sectiontableentry<?php echo $item->odd + 1; ?>">-->
			<td align="left"><?php echo $this->escape($item->id); ?></td>
			<td height="20"><?php echo $this->escape($item->firstname); ?></td>
			<td height="20"><?php echo $this->escape($item->lastname); ?></td>
			<td height="20"><?php echo $this->escape($item->status); ?></td>
			<td height="20"><?php echo $this->escape($item->submit_date); ?></td>
			<td valign="top" width="90" align="center"><?php if ($this->iamadministrator) : ?>
			<div class="buttonheading"><span> <a href='<?php echo $del_link; ?>'
				onClick="return confirm('<?php echo JText::_( 'ARE_YOU_SURE' ); ?>');"
				title="<?php echo JText::_( 'DELETE' ); ?>"> <img border='0'
				src='./components/com_phd/assets/Delete.png'> </a> </span></div>
				<?php endif; ?>
			<div class="buttonheading"><span> <a href='<?php echo $pdf_link; ?>'
				title="<?php echo JText::_( 'VIEW_PDF' ); ?>" target="_blank"> <img
				border='0' src='./components/com_phd/assets/acrobat.png'> </a> </span>
			</div>
			<?php if ($this->iamgroupleader || $this->iamcommittee) : ?>
			<div class="buttonheading"><span> <a href='<?php echo $link; ?>'
				title="<?php echo JText::_( 'VIEW' ); ?>"> <img border='0'
				src='./components/com_phd/assets/Info.png'> </a> </span></div>
				<?php endif; ?> <?php if ($this->iamadministrator) : ?>
			<div class="buttonheading"><span> <a href='<?php echo $link; ?>'
				title="<?php echo JText::_( 'MODIFY' ); ?>"> <img border='0'
				src='./components/com_phd/assets/Document.png'> </a> </span></div>
			<div class="buttonheading"><span> <a
				href='<?php echo $link_readonly; ?>'
				title="<?php echo JText::_( 'VIEW' ); ?>"> <img border='0'
				src='./components/com_phd/assets/Info.png'> </a> </span></div>
				<?php endif; ?></td>
		</tr>
	</tbody>
	<?php
	}
	?>
	<!-- <tfoot> -->
	<tr class="sectiontableentry1">
		<!-- <td scope="row" align="center" colspan="6"> -->
		<td align="center" colspan="6"><?php echo $this->pagination->getPagesLinks(); ?>
		</td>
	</tr>
	<!-- </tfoot> -->
	<?php
	} else {
		?>
	<tbody>
		<tr>
			<td align="left"><?php echo JText::_('NO_ROWS'); ?></td>
		</tr>
	</tbody>
	<?php
	}
	?>
</table>
<input type="hidden" name="option" value="com_phd" /> <input
	type="hidden" name="task" value="" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->lists['order']; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->lists['order_Dir']; ?>" /></form>
