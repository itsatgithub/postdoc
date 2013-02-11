<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('stylesheet', 'table.css', 'components/com_register/assets/'); ?>

<?php JHTML::_('behavior.formvalidation'); ?>

<script language="javascript" type="text/javascript">

	function myValidate(f) {
		if (document.formvalidator.isValid(f)) {
			f.check.value='<?php echo JUtility::getToken(); ?>';//send token
			return true; 
		}
		else {
			alert('Some values are not acceptable.  Please retry.');
		}
		return false;
	}

	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
	
		<?php
			$editor =& JFactory::getEditor();
			echo $editor->save( 'content' );
		?>
		submitform(pressbutton);
	}

</script>


		<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div
	class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
		<?php echo $this->escape($this->params->get('page_title')); ?></div>
		<?php endif; ?>

		<?php if ($this->congress->papers_limit) {
			if ($this->num_upload_papers >= $this->congress->papers_limit) {
				echo $this->congress->papers_limit_text;
				return true;
			}
		}

		if (!$this->editing_paper) :
		echo $this->congress->paper_instructions;
		endif; ?>

<table width="100%" class="table">

	<form action="<?php echo $this->action; ?>" method="post"
		name="paperForm" id="paperForm" class="form-validate"
		onSubmit="return myValidate(this);" enctype='multipart/form-data'><!-- Variable used to check the validation of the form fields -->
	<input type="hidden" name="check" value="post" />

	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php echo JText::_( 'PAPER_DETAILS_LABEL'); ?>
			</th>
		</tr>
	</thead>

	<?php if ( $this->menu_params->get( 'paper_title') || (!empty($this->paper->title))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_TITLE_LABEL' ); ?><?php if ( $this->menu_params->get( 'paper_title')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get( 'paper_title')=='2') echo "class='required'"; ?>
			type="text" name="title" value="<?php echo $this->paper->title; ?>"
			size="55" maxlength="250" /></td>
	</tr>
	<?php endif; ?> <?php if ( $this->menu_params->get( 'paper_file') || (!empty($this->paper->filename))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_FILE_LABEL' ); ?><span
			style='color: red;'>*</span>:</td>
		<td><input type='hidden' name='MAX_FILE_SIZE' value='2097152' /> <input
			type="file" name="filename"
			value="<?php echo $this->paper->filename; ?>" /> <?php echo ($this->paper->filename)?"<img src='./administrator/images/tick.png'> Paper Uploaded [".$this->paper->filename."]":''; ?>
		<!--a href="<?php //echo JPATH_BASE . DS . $this->congress->papers_directory . DS . $this->paper->id.'_'.$this->paper->filename; ?>">[Download]</a-->
		<input type="hidden" name="old_filename"
			value="<?php echo $this->paper->filename; ?>" /></td>
	</tr>
	<?php endif; ?> <?php if ( $this->menu_params->get( 'paper_institution') || (!empty($this->paper->institution))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_INSTITUTION_LABEL' ); ?><?php if ( $this->menu_params->get( 'paper_institution')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get( 'paper_institution')=='2') echo "class='required'"; ?>
			type="text" name="institution"
			value="<?php echo $this->paper->institution; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif;?> <?php if ( $this->menu_params->get( 'paper_mail') || (!empty($this->paper->email))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_EMAIL_LABEL' ); ?><?php if ( $this->menu_params->get( 'paper_mail')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get( 'paper_mail')=='2') echo "class='required validate-email'"; ?>
			type="text" name="email" value="<?php echo $this->paper->email; ?>"
			size="50" maxlength="100" /></td>
	</tr>
	<?php endif; ?> <?php if ( $this->menu_params->get( 'paper_typeofpresentation') || (!empty($this->paper->paper_type_id))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_TYPE_OF_PRESENTATION_LABEL' ); ?><?php if ( $this->menu_params->get( 'paper_typeofpresentation')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['paper_type']; ?></td>
	</tr>
	<?php endif; ?> <?php if ( $this->menu_params->get( 'paper_session') || (!empty($this->paper->session_id))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_SESSION_LABEL' ); ?><?php if ( $this->menu_params->get( 'paper_session')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['session_type']; ?></td>
	</tr>
	<?php endif; ?> <?php if ( $this->menu_params->get( 'paper_abstract') || (!empty($this->paper->abstract))) : ?>
	<?php $editor =& JFactory::getEditor(); ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_ABSTRACT_LABEL' ); ?><span
			style='color: red;'>*</span>:</td>
		<td><?php echo $editor->display('abstract', $this->paper->abstract, '100%','200','50','6',false); ?>
		</td>
	</tr>
	<?php endif; ?> <?php /*if ($this->editing_paper) : ?>
	<!--tr class='sectiontableentry1'>
	<td valign="top">
	<?php echo JText::_( 'PAPER_ACCEPTED_LABEL' ); ?>:
	</td>
	<td>
	<?php echo $this->lists['choice_accepted']; ?>
	</td>
	</tr-->
	<?php endif;*/ ?>

	<tr>
		<td valign="top" colspan="2">

		<button class="button validate" type="submit"><?php if($this->paper->id): ?>
		<?php echo JText::_('Modify') ?> <?php else: ?> <?php echo JText::_('Save') ?>
		<?php endif; ?></button>

		<INPUT type='hidden' name='modified'
			value='<?php echo $this->modified; ?>'> <input type="hidden"
			name="id" value="<?php echo $this->paper->id; ?>" /> <input
			type="hidden" name="congress_id"
			value="<?php echo $this->paper->congress_id; ?>" /> <input
			type="hidden" name="option" value="com_register" /> <input
			type="hidden" name="view" value="paper" /> <input type="hidden"
			name="task" value="save_paper_data" /> <input type="hidden"
			name="editing_paper" value="<?php echo $this->editing_paper; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
	
	</form>
	</td>
	</tr>

</table>

<hr>

<table width="100%">
	<form action="<?php echo $this->action; ?>" method="post"
		name="presentingauthorForm" id="presentingauthorForm"
		class="form-validate" onSubmit="return myValidate(this);"
		enctype='multipart/form-data'><!-- Variable used to check the validation of the form fields -->
	<input type="hidden" name="check" value="post" />

	<tr>
		<TD colspan="4"><?php echo JText::_( 'PAPER_PRESENTING_AUTHOR_LABEL' ); ?></TD>
	</tr>

	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_NAME' ); ?><span
			style='color: red;'>*</span>:</td>
		<td><input class="required" type="text" name="name"
			value="<?php echo $this->presenting_author->name; ?>" size="50"
			maxlength="250" /></td>
		<td valign="top"><?php echo JText::_( 'PAPER_INITIALS' ); ?><span
			style='color: red;'>*</span>:</td>
		<td><input class="required" type="text" name="initials"
			value="<?php echo $this->presenting_author->initials; ?>" size="10"
			maxlength="50" /></td>
	</tr>
	<tr>
		<td valign="top" colspan="4"><?php if($this->paper->filename || $this->paper->abstract): ?>
		<button class="button validate" type="submit"><?php if($this->paper->presenting_author_id): ?>
		<?php echo JText::_('Modify') ?> <?php else: ?> <?php echo JText::_('Save') ?>
		<?php endif; ?></button>
		<?php endif; ?> <INPUT type='hidden' name='modified'
			value='<?php echo $this->modified; ?>'> <input type="hidden"
			name="paper_id" value="<?php echo $this->paper->id; ?>" /> <input
			type="hidden" name="id"
			value="<?php echo $this->presenting_author->id; ?>" /> <input
			type="hidden" name="option" value="com_register" /> <input
			type="hidden" name="view" value="paper" /> <input type="hidden"
			name="task" value="save_presenting_author" /> <input type="hidden"
			name="editing_paper" value="<?php echo $this->editing_paper; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
	
	</form>

</table>

<hr>

<table width="100%">
	<form action="<?php echo $this->action; ?>" method="post"
		name="presentingauthorForm" id="presentingauthorForm"
		class="form-validate" onSubmit="return myValidate(this);"
		enctype='multipart/form-data'><!-- Variable used to check the validation of the form fields -->
	<input type="hidden" name="check" value="post" /> <INPUT type='hidden'
		name='modified' value='<?php echo $this->modified; ?>'> <?php $paper_presenting_author_label = $this->menu_params->get( 'paper_presenting_author_label'); ?>
	<tr>
		<TD colspan="4"><?php echo JText::_( 'PAPER_REST_OF_AUTHORS_LABEL' ); ?></TD>
	</tr>

	<?php if(count($this->authors) != 0): ?>

	<tr>
		<td valign="top"><strong><?php echo JText::_( 'PAPER_NAME' ); ?></strong>
		</td>
		<td valign="top"><strong><?php echo JText::_( 'PAPER_INITIALS' ); ?></strong>
		</td>
		<td colspan="2"><strong><?php echo JText::_( 'DELETE' ); ?></strong></td>
	</tr>

	<?php foreach($this->authors as $author) : ?>

	<tr>
		<td><?php echo $author->name; ?></td>
		<td><?php echo $author->initials; ?>
		<td colspan="2"><a
			href='<?php echo $_SERVER['PHP_SELF']; ?>?option=com_register&task=del_author&view=paper&editing_paper=<?php echo $this->editing_paper; ?>&id=<?php echo $author->id; ?>&paper_id=<?php echo $this->paper->id; ?>'
			onClick="return confirm('Are you sure you want to delete this author?');"><img
			border='0' src='administrator/images/publish_x.png'></a></td>
	
	</tr>

	<?php endforeach; ?>

	<tr>
		<TD colspan="4"><br>
		</TD>
	</tr>

	<?php endif; ?>


	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAPER_NAME' ); ?>:</td>
		<td><input class="required" type="text" name="name" size="50"
			maxlength="250" /></td>
		<td valign="top"><?php echo JText::_( 'PAPER_INITIALS' ); ?>:</td>
		<td><input class="required" type="text" name="initials" size="10"
			maxlength="50" /></td>
	</tr>
	<tr>
		<td valign="top" colspan="4"><?php if(($this->paper->filename || $this->paper->abstract) && $this->paper->presenting_author_id): ?>
		<button class="button validate" type="submit"><?php echo JText::_('Add Author') ?>
		</button>
		<?php endif; ?> <INPUT type='hidden' name='modified'
			value='<?php echo $this->modified; ?>'> <input type="hidden"
			name="paper_id" value="<?php echo $this->paper->id; ?>" /> <input
			type="hidden" name="option" value="com_register" /> <input
			type="hidden" name="view" value="paper" /> <input type="hidden"
			name="editing_paper" value="<?php echo $this->editing_paper; ?>" /> <input
			type="hidden" name="task" value="add_author" /> <?php echo JHTML::_( 'form.token' ); ?>
	
	</form>

</table>

<hr>

<br>
		<?php echo JText::_( 'COMPULSORY_FIELDS' ); ?>
<br>

<hr>

		<?php if ($this->editing_paper) : ?>
<hr>
<br>
<a
	href='<?php echo $_SERVER['PHP_SELF']; ?>?option=com_register&view=papers&id=<?php echo $this->paper->congress_id; ?>'>
<button class="button"><?php echo JText::_('Back to List') ?></button>
</a>
</tr>

		<?php else: ?>

<table width="100%">
	<tr>
		<tr>
			<TD colspan="2"><br>
			</TD>
		</tr>
		<td colspan="2" valign="top">

		<form action="<?php echo $this->action; ?>" method="post"><?php if($this->paper->email && $this->paper->presenting_author_id): ?>
		<button class="button validate" type="submit"><?php echo JText::_('CONFIRM_AND_SAVE') ?>
		</button>
		<?php endif; ?> <input type="hidden" name="id"
			value="<?php echo $this->paper->id; ?>" /> <input type="hidden"
			name="option" value="com_register" /> <input type="hidden"
			name="view" value="paper" /> <INPUT type='hidden' name='modified'
			value='<?php echo $this->modified; ?>'> <INPUT type='hidden'
			name='submission_date' value='<?php echo $this->submission_date; ?>'>
		<input type="hidden" name="task" value="confirm_paper" /> <input
			type="hidden" name="editing_paper"
			value="<?php echo $this->editing_paper; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
		</form>
		</td>
		<td valign="top" colspan="2"><?php if (empty($this->paper->filename) && ($this->menu_params->get( 'paper_file'))) :?>
		<font color="Red"><i><?php echo JText::_('Missing_File'); ?></i></font><br>
		<?php endif;?> <?php if (empty($this->paper->presenting_author_id)) :?>
		<font color="Red"><i><?php echo JText::_( 'MISSING_AUTHOR' ); ?></i></font><br>
		<?php endif;?> <?php if (empty($this->paper->session_id) && ($this->menu_params->get( 'paper_session'))) :?>
		<font color="Blue"><i><?php echo JText::_( 'NO_SESSION_ASSOCIATED' ); ?></i></font><br>
		<?php endif;?> <?php if (empty($this->paper->paper_type_id) && ($this->menu_params->get( 'paper_typeofpresentation'))) :?>
		<font color="Blue"><i><?php echo JText::_( 'NO_TYPE_ASSOCIATED' ); ?></i></font><br>
		<?php endif;?></td>
	</tr>
</table>

<?php endif; ?>