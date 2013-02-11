<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('stylesheet', 'table.css', 'components/com_register/assets/'); ?>

<script language="javascript" type="text/javascript">
function tableOrdering( order, dir, task ) {
	var form = document.adminForm;

	form.filter_order.value = order;
	form.filter_order_Dir.value	= dir;
	document.adminForm.submit( task );
}
function listItemTask( id, task ) {
    var f = document.adminForm;
    cb = eval( 'f.' + id );
    if (cb) {
        //alert("hola");
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        alert("adios");
        submitbutton(task);
    }
    alert("adios2");
    return false;
}
</script>

<?php if ( $this->params->get( 'show_page_title', 1 ) ) : ?>
<div
	class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<?php echo $this->escape($this->params->get('page_title')); ?></div>

TOTAL REGISTRATIONS (
<?php echo $this->pagination->total; ?>
)
<?php endif; ?>
<a
	href="index.php?option=com_register&view=registrations&format=rtf&id_congress=<?php echo $this->congress->id; ?>"
	target="_blank"><img src="components/com_register/assets/txt.png"
	align="right" alt="RTF" title="View RTF"></a>
<img
	src="administrator/images/blank.png" align="right">
<!--img src="administrator/images/menu_divider.png" align="right">
<img src="administrator/images/blank.png" align="right">
<a href="index.php?option=com_register&view=registrations&format=pdf&id_congress=<?php //echo $this->congress->id; ?>" target="_blank"><img src="components/com_register/assets/pdf.png" align="right" alt="PDF" title="Export to PDF"></a>
<img src="administrator/images/blank.png" align="right"-->
<img
	src="administrator/images/menu_divider.png" align="right">
<img
	src="administrator/images/blank.png" align="right">
<a
	href="index.php?option=com_register&view=registrations&format=raw&id_congress=<?php echo $this->congress->id; ?>"
	target="_blank"><img
	src="components/com_register/assets/spreadsheet.png" align="right"
	alt="CSV" title="Export to CSV"></a>
<br>
<br>
<br>
<br>

<form action="<?php echo JFilterOutput::ampReplace($this->action); ?>"
	method="post" name="adminForm">
<table width="100%" border="0" cellspacing="0" cellpadding="0"
	class="table">
	<thead align="center">
		<tr class="sectiontableentry1">
		<?php if ($this->user->gid == '25') :
		$colspan="7";
		else :
		$colspan="6";
		endif; ?>
			<td align="right" colspan="<?php echo $colspan; ?>"><?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="filter_search" id="search"
				value="<?php echo $this->lists['search'];?>" class="text_area"
				onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
			<button
				onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>
				<?php echo $this->lists['institution']; ?> <?php if ( $this->menu_params->get( 'display_registration_type')): ?>
				<?php echo $this->lists['registration_type']; ?> <?php endif; ?> <?php
				echo JText::_('Display Num') .'&nbsp;';
				echo $this->pagination->getLimitBox();
				?></td>
		</tr>
		<tr class="sectiontableheader">
			<th width="10" class="white" align="center"><?php echo JHTML::_('grid.sort', 'Id', 'r.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th width="20" align="center"><input type="checkbox" name="toggle"
				value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>
			<th width="15%" height="20" class="white"><?php echo JHTML::_('grid.sort', 'Firstname', 'r.firstname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th height="20" class="white"><?php echo JHTML::_('grid.sort', 'Lastname', 'r.lastname', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>

			<?php //if ( $this->menu_params->get( 'display_registration_date')): ?>
			<th width="15%" height="20" class="white"><?php echo JText::_('REGISTRATION_DATE'); ?>
			</th>
			<?php //endif; ?>

			<th width="15%" class="white"><?php echo JText::_('EMAIL_SENT_DATE'); ?>
			</th>
			<th class="white"><?php echo JText::_('SEND_MAIL'); ?></th>

			<?php //if ( $this->menu_params->get( 'display_paid')): ?>
			<th width="5%" height="20"><?php echo JHTML::_('grid.sort', 'Paid', 'r.paid', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<?php //endif; ?>

			<?php if ( $this->menu_params->get( 'display_title')): ?>
			<th width="15%" height="20" class="white"><?php echo JText::_('Title'); ?>
			</th>
			<?php endif; ?>

			<th class="white"><?php echo JText::_('Institution'); ?></th>
			<?php if ($this->user->gid == '25') : ?>
			<th height="20" class="white"><?php echo JText::_('Del'); ?></th>

			<?php if ( $this->menu_params->get( 'display_pdf_button')): ?>
			<th height="20" class="white"><?php echo JText::_('Invoice'); ?></th>

			<?php endif; ?>
			<?php endif; ?>
		</tr>
	</thead>
	<?php
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)
	{
		$item = &$this->items[$i];

		$checked 	= JHTML::_('grid.checkedout',   $item, $i );

		$img 	= $item->paid ? 'tick.png' : 'publish_x.png';
		$task 	= $item->paid ? 'unpublish' : 'publish';
		$alt 	= $item->paid ? JText::_( 'Unpaid' ) : JText::_( 'Paid' );
		$action = $item->paid ? JText::_( 'Unpaid Item' ) : JText::_( 'Paid item' );

		$paid = '<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">
	<img src="administrator/images/'. $img .'" border="0" alt="'. $alt .'" /></a>';

		//$link = JRoute::_( 'index.php?option=com_register&view=registration&task=display&registration_id='. $item->id );

		$link_del = JRoute::_( 'index.php?option=com_register&view=registrations&task=del_registration&cid[]='. $item->id );
		$link = JRoute::_( 'index.php?option=com_register&view=registrations&task=edit_registration&cid[]='. $item->id );
		$link_generate_invoice = JRoute::_( 'index.php?option=com_register&view=registration&format=raw&registration_id='. $item->id );

		?>
	<tr class="sectiontableentry1">
		<td align="right"><?php echo $item->id; ?></td>
		<td><?php echo $checked; ?></td>

		<?php if ($this->user->gid >= '18') : ?>
		<td height="20"><span class="editlinktip hasTip"
			title="<?php echo JText::_( 'Edit Registration' );?>::<?php echo $this->escape($item->firstname); ?>">
		<a href="<?php echo $link; ?>"><?php echo $this->escape($item->firstname); ?></a></span>
		</td>
		<td height="20"><span class="editlinktip hasTip"
			title="<?php echo JText::_( 'Edit Registration' );?>::<?php echo $this->escape($item->lastname); ?>">
		<a href="<?php echo $link; ?>"><?php echo $this->escape($item->lastname); ?></a></span>
		</td>
		<?php else: ?>
		<td height="20"><?php echo $this->escape($item->firstname); ?></td>
		<td height="20"><?php echo $this->escape($item->lastname); ?></td>
		<?php endif; ?>

		<?php //if ( $this->menu_params->get( 'display_registration_date')): ?>
		<td height="20"><?php echo $item->registration_date; ?></td>
		<?php //endif; ?>

		<td height="20"><?php echo $item->email_sent_date; ?></td>
		<td align="center"><a
			href='<?php echo $_SERVER['PHP_SELF']; ?>?option=com_register&task=email_registration&id=<?php echo $item->id; ?>'
			onClick="return confirm('<?php echo JText::_('EMAIL_CONFIRMATION'); ?>')."
			title="<?php echo JText::_( 'SEND_MAIL' ); ?>"><IMG
			src='images/M_images/emailButton.png' border='0'></a></td>

			<?php //if ( $this->menu_params->get( 'display_paid')): ?>
		<td height="20"><?php echo $paid; ?></td>
		<?php //endif; ?>

		<?php if ( $this->menu_params->get( 'display_title')): ?>
		<td height="20"><?php echo $item->title; ?></td>
		<?php endif; ?>

		<td height="20"><?php echo $item->institution; ?></td>

		<?php if ($this->user->gid == '25') : ?>
		<!--td align='center'>
			<a href='<? //echo $link; ?>' target='_blank'>
			<img border='0' src='images/M_images/edit.png'>
			</a>
		</td-->
		<td align='center'><a href='<? echo $link_del; ?>'
			onClick="return confirm('Are you sure you want to delete this registration?');">
		<img border='0' src='administrator/images/publish_x.png'> </a></td>

		<?php if ( $this->menu_params->get( 'display_pdf_button')): ?>
		<td align='center'><a href='<? echo $link_generate_invoice; ?>'
			target="_blank"> <img border='0' src='images/M_images/pdf_button.png'>
		</a></td>
		<?php endif; ?>

		<?php endif; ?>

	</tr>
	<?php
	}
	?>
	<tr>
		<td align="center" colspan="<?php echo $colspan; ?>"
			class="sectiontableentry1"><?php echo $this->pagination->getPagesLinks(); ?>
		</td>
	</tr>
	<tr>
		<td colspan="<?php echo $colspan; ?>" align="right"
			class="pagecounter"><?php echo $this->pagination->getPagesCounter(); ?>
		</td>
	</tr>
</table>
<input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir" value="" /></form>
