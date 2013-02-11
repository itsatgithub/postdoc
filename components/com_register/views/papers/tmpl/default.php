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
</script>

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div
	class="componentheading<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
<?php echo $this->escape($this->params->get('page_title')); ?></div>
TOTAL PAPERS (
<?php echo $this->pagination->total; ?>
)
<?php endif; ?>
<a
	href="index.php?option=com_register&view=papers&format=rtf&id_congress=<?php echo $this->congress->id; ?>"
	target="_blank"><img src="components/com_register/assets/txt.png"
	align="right" alt="RTF" title="View RTF"></a>
<img
	src="administrator/images/blank.png" align="right">
<!--img src="administrator/images/menu_divider.png" align="right">
<img src="administrator/images/blank.png" align="right">
<a href="index.php?option=com_register&view=papers&format=pdf&id_congress=<?php echo $this->congress->id; ?>" target="_blank"><img src="components/com_register/assets/pdf.png" align="right" alt="PDF" title="Export to PDF"></a>
<img src="administrator/images/blank.png" align="right"-->
<img
	src="administrator/images/menu_divider.png" align="right">
<img
	src="administrator/images/blank.png" align="right">
<a
	href="index.php?option=com_register&view=papers&format=raw&id_congress=<?php echo $this->congress->id; ?>"
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
	<thead>
		<tr class="sectiontableentry1">
		<?php if ($this->user->gid == '25') :
		$colspan="6";
		else :
		$colspan="5";
		endif; ?>
			<td align="right" colspan="<?php echo $colspan; ?>"><?php echo JText::_( 'Filter' ); ?>:
			<input type="text" name="filter_search" id="search"
				value="<?php echo $this->lists['search'];?>" class="text_area"
				onchange="document.adminForm.submit();" />
			<button onclick="this.form.submit();"><?php echo JText::_('Go'); ?></button>
			<button
				onclick="document.adminForm.filter_search.value='';this.form.submit();"><?php echo JText::_('Reset'); ?></button>

				<?php if ( $this->menu_params->get( 'display_sessions')): ?> <?php echo $this->lists['session']; ?>
				<?php endif; ?> <?php if ( $this->menu_params->get( 'display_paper_type')): ?>
				<?php echo $this->lists['paper_type']; ?> <?php endif; ?> <?php
				echo JText::_('Display Num') .'&nbsp;';
				echo $this->pagination->getLimitBox();
				?></td>
		</tr>
		<tr class="sectiontableheader">
			<th width="10" style="text-align: right;" class="white"><?php echo JHTML::_('grid.sort', 'Id', 'p.id', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<th height="20" class="white"><?php echo JHTML::_('grid.sort', 'Title', 'p.title', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>

			<?php if ( $this->menu_params->get( 'display_filename')): ?>
			<th width="20%" height="20" class="white"><?php echo JHTML::_('grid.sort', 'Filename', 'p.filename', $this->lists['order_Dir'], $this->lists['order'] ); ?>
			</th>
			<?php endif; ?>

			<?php if ( $this->menu_params->get( 'display_sessions')): ?>
			<th width="20%" height="20" class="white"><?php echo JText::_('Session'); ?>
			</th>
			<?php endif; ?>

			<th width="20%" height="20" class="white"><?php echo JText::_('Institution'); ?>
			</th>
			<th width="20%" height="20" class="white"><?php echo JText::_('Email'); ?>
			</th>

			<?php if ($this->user->gid == '25') : ?>
			<th height="20" class="white"><?php echo JText::_('Del'); ?></th>
			<?php endif; ?>
		</tr>
	</thead>
	<?php foreach ($this->items as $item) :
	$link_del = JRoute::_( 'index.php?option=com_register&view=papers&task=del_paper&cid[]='. $item->id );
	$link = JRoute::_( 'index.php?option=com_register&view=papers&task=edit_paper&cid[]='. $item->id );
	?>
	<tr class="sectiontableentry1">
		<td align="right"><?php echo $item->id; ?></td>

		<?php if ($this->user->gid >= '18') : ?>
		<td height="20"><span class="editlinktip hasTip"
			title="<?php echo JText::_( 'Edit Paper' );?>::<?php echo $this->escape($item->title); ?>">
		<a href="<?php echo $link; ?>"><?php echo $this->escape($item->title); ?></a></span>
		</td>
		<?php else: ?>
		<td height="20"><?php echo $this->escape($item->title); ?></td>
		<?php endif; ?>

		<?php if ( $this->menu_params->get( 'display_filename')): ?>
		<td height="20"><a
			href='<?php echo $this->congress->papers_directory. DS .$item->id.'_'.$item->filename; ?>'>
		<img border='0' src='administrator/images/filesave.png'> <?php echo $item->filename; ?></a>
		</td>
		<?php endif; ?>

		<?php if ( $this->menu_params->get( 'display_sessions')): ?>
		<td height="20"><?php echo $item->session; ?></td>
		<?php endif; ?>

		<td height="20"><?php echo $item->institution; ?></td>
		<td height="20"><?php echo $item->email; ?></td>

		<?php if ($this->user->gid == '25') : ?>
		<td align='center'><a href='<? echo $link_del; ?>'
			onClick="return confirm('Are you sure you want to delete this document?');">
		<img border='0' src='administrator/images/publish_x.png'> </a></td>
		<?php endif; ?>

	</tr>
	<?php endforeach; ?>
	<tr class="sectiontableentry1">
		<td align="center" colspan="<?php echo $colspan; ?>"
			class="sectiontablefooter<?php echo $this->escape($this->params->get('pageclass_sfx')); ?>">
			<?php echo $this->pagination->getPagesLinks(); ?></td>
	</tr>
	<tr class="sectiontableentry1">
		<td colspan="<?php echo $colspan; ?>" align="right"
			class="pagecounter"><?php echo $this->pagination->getPagesCounter(); ?>
		</td>
	</tr>
</table>
<input type="hidden" name="filter_order"
	value="<?php echo $this->lists['order']; ?>" /> <input type="hidden"
	name="filter_order_Dir" value="" /></form>
