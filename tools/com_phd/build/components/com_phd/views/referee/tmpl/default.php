<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('stylesheet', 'table.css', 'components/com_phd/assets/'); ?>

<?php echo JText::_('INTRO_REFEREE_VIEW'); ?>
<br></br>
<br></br>

<form action="<?php echo $this->action; ?>" method="post"
	class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php echo JText::_('UPLOAD_FILE_TITLE'); ?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%"><?php echo JText::_('UPLOAD_FILE'); ?>:</td>
		<td><input type='hidden' name='MAX_FILE_SIZE' value='2097152' /> <input
			type='file' class='inputbox' name='uploaded_file'></td>
	</tr>

	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"><?php echo JText::_('UPLOAD') ?></button>
		</fieldset>
		<input type="hidden" name="referee_id"
			value="<?php echo $this->applicant->referee_id; ?>" /> <input
			type="hidden" name="id" value="<?php echo $this->applicant->id; ?>" />
		<input type="hidden" name="option" value="com_phd" /> <input
			type="hidden" name="controller" value="referee" /> <input
			type="hidden" name="view" value="referee" /> <input type="hidden"
			name="task" value="upload_file" /> <input type="hidden" name="check"
			value="post" /> <?php echo JHTML::_( 'form.token' ); ?></td>
		<td align="right"></td>
	</tr>
</table>
</form>
