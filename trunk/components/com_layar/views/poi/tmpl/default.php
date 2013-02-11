<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php ini_set('display_errors', 0); ?> 
<?php JHTML::_('stylesheet', 'table.css', 'components/com_jobs/assets/'); ?>

<?php 	JHTML::_('behavior.formvalidation'); ?>

<?php 
/**
 * Poi data.
 */
?>

<a href="<? echo $_SERVER['PHP_SELF']; ?>?option=com_layar&view=pois"><?php echo JText::_('BACK_TO_LIST') ?></a><br><br>

<?php echo JText::_('INSTRUCTIONS_TEXT'); ?><br></br>
<?php echo JText::_('COMPULSORY_FIELDS_TEXT'); ?>
<br></br><br></br>

<form action="<?php echo $this->action; ?>" method="post" class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table"> 
<thead>
<tr class="sectiontableheader">
	<th colspan='3' class="white">
		<?php echo JText::_('POI_DATA_TITLE'); ?>
	</th>
</tr>
</thead>
<tbody>

<?php if ($this->poi->id):?>
<tr class="sectiontableentry1">
	<td width="20%">
		<?php echo JText::_('ID'); ?>:
	</td>
	<td>
		<?php echo '<i>'.$this->poi->id.'</i>'; ?>
	</td>
	<td rowspan="4">
		<IMG src="<?php echo $this->poi->imageURL; ?>" align="left" border="0" height="75" width="100"><br>100x75 píxels<br><2Kb.
	</td>
</tr>
<?php endif; ?>

<tr class="sectiontableentry1">
	<td width="15%">
		<?php echo JText::_('LAYER'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
	</td>
	<td>
		<?php echo $this->lists['layerslist']; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td width="15%">
		<?php echo JText::_('TITLE'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
	</td>
	<td>
		<?php if ($this->rights == 'write'): ?>
			<input type="text" name="title" value="<?php echo $this->poi->title; ?>" size="60" maxlength="60" class="required"/>
		<?php else: 
			echo $this->poi->title;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('ATTRIBUTION'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
	</td>
	<td>
		<?php if ($this->rights == 'write'): ?>
			<input class="required" type="text" name="attribution" value="<?php echo $this->poi->attribution; ?>" size="45" maxlength="45" /> [Descripció]
		<?php else: 
			echo $this->poi->attributtion;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('LINE2'); ?>:
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'): ?>
			<input class="" type="text" name="line2" value="<?php echo $this->poi->line2; ?>" size="35" maxlength="35" /> [Tipus activitat detall]
		<?php else: 
			echo $this->poi->line2;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('LINE3'); ?>:
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'): ?>
			<input class="" type="text" name="line3" value="<?php echo $this->poi->line3; ?>" size="35" maxlength="35" /> [Adreça, Dades contacte]
		<?php else: 
			echo $this->poi->line3;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('LINE4'); ?>:
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'): ?>
			<input class="" type="text" name="line4" value="<?php echo $this->poi->line4; ?>" size="35" maxlength="35" /> [Horari]
		<?php else: 
			echo $this->poi->line4;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('LAT-LON'); ?>:
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'): ?>
			<input class="required" type="text" name="latlon" value="<?php echo $this->poi->lat.','.$this->poi->lon; ?>" size="60" maxlength="60" />
		<?php else: 
			echo $this->poi->lat.','.$this->poi->lon;
		endif; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('IMAGE'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
	</td>
	<td>
		<input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
		<input type='file' class='inputbox' name='uploadedfile'><?php echo JText::_('HELP_UPLOAD_FILE'); ?>
	</td>
</tr>
<?php if(count($this->lists['poitypelist']) > 1): ?>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_( 'TYPELIST' ); ?>: 
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'):
				echo $this->lists['poitypelist']; 
			else: 
				echo $this->poi->type; ?>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>
<?php if(count($this->lists['typelist']) > 1): ?>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_( 'TYPELIST_FILTER' ); ?>: 
	</td>
	<td colspan="2">
		<?php if ($this->rights == 'write'):
				echo $this->lists['typelist']; 
			else: 
				echo $this->poi->type; ?>
		<?php endif; ?>
	</td>
</tr>
<?php endif; ?>


<?php //if (($this->rights == 'write')): ?> <!-- No write, no buttons -->
<tr class="sectiontableentry1">
	<td align="left">

<fieldset class="input">
	<button class="validate" name="save" value="true" type="submit"><?php echo JText::_('Save') ?></button>
</fieldset>
	<?php if($this->poi->id): ?>
		<input type="hidden" name="id" value="<?php echo $this->poi->id; ?>" />
	<?php endif; ?>
	<input type="hidden" name="option" value="com_layar" />
	<input type="hidden" name="view" value="poi" />
	<input type="hidden" name="task" value="save_poi" />
	<input type="hidden" name="check" value="post"/>
<?php echo JHTML::_( 'form.token' ); ?>
	</td>
	<td colspan="2">
	</td>
</tr>
<?php //endif; ?>
</tbody>
</table>
</form>

<?php /*if ($this->iamadministrator && $this->poi->codi): ?>
	<?php echo JText::_('LINK_TO_MODIFY:'); ?>
	<?php echo $this->linktomodify; ?>
	<br>
<?php endif; */?>

<br><hr></br>
<?php echo JText::_('INTRO_FILES'); ?>
<br></br><br></br>

<?php if(count($this->poi->actions) > 0): ?>
<table width='100%' border='0' class="table">
<thead>
	<tr class='sectiontableheader'>
	<th width='20%' class="white"><?php echo JText::_('TYPE'); ?></th>
	<th width='20%' class="white"><?php echo JText::_('LABEL'); ?></th>
	<th class="white"><?php echo JText::_('URI'); ?></th>
	<?php if ($this->rights == 'write'): ?>
		<th width='10%' align='center' class="white"><?php echo JText::_('DELETE'); ?></th>
	<?php endif; ?>
	</tr>
</thead>
<?php foreach($this->poi->actions as $action): ?>
	<tr>
	<td><? echo $action->actiontype; ?></td>
	<td>
		<?php echo $action->label; ?>
	</td>
	<td><? echo $action->uri; ?></td>
	<?php if ($this->rights == 'write'): ?>
		<td align='center'>
		<a href='<? echo $_SERVER['PHP_SELF']; ?>?option=com_layar&task=del_action&action_id=<? echo $action->id; ?>&id=<? echo $this->poi->id; ?>' onClick="return confirm('Are you sure you want to delete this action?');"><IMG src='./components/com_layar/assets/Delete.png' border="0"  title="<?php echo JText::_( 'DELETE' ); ?>"></a></td>
	<?php endif; ?>
	</tr>
<?php endforeach; ?>
</table>
<br></br>
<?php endif; ?>

<?php 

if ($this->rights == 'write'): ?>

<form action="<?php echo $this->action; ?>" method="post" class="form-validate">
<table width="100%" class="table">
<thead>
<tr class="sectiontableheader">
	<th colspan='2' class="white">
		<?php echo JText::_('ACTIONS_TITLE'); ?>
	</th>
</tr>
</thead>
<tr class="sectiontableentry1">
	<td width="20%">
		<?php echo JText::_('TYPE'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
	</td>
	<td>
		<?php echo $this->lists['actiontypelist']; ?>
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('LABEL'); ?>:
	</td>
	<td>
		<input type="text" name="label" size="30" maxlength="30" />
	</td>
</tr>
<tr class="sectiontableentry1">
	<td>
		<?php echo JText::_('URI'); ?>:
	</td>
	<td>
		<input type="text" name="uri" size="60" maxlength="150" /> [No incloure tel:, ni prefix de païs]
	</td>
</tr>

<tr class="sectiontableentry1">
	<td align="left">

<fieldset class="input">
	<button class="validate" name="save" value="true" type="submit" <?php echo ($this->poi->id)?'':'disabled'; ?>><?php echo JText::_('Save') ?></button>
</fieldset>
	<input type="hidden" name="layer_id" value="<?php echo $this->poi->layer_id; ?>" />
	<input type="hidden" name="id" value="<?php echo $this->poi->id; ?>" />
	<input type="hidden" name="option" value="com_layar" />
	<input type="hidden" name="view" value="poi" />
	<input type="hidden" name="task" value="save_action" />
	<input type="hidden" name="check" value="post"/>
<?php echo JHTML::_( 'form.token' ); ?>
	</td>
	<td align="right">
	</td>
</tr>
<?php endif; ?>
</table>
</form>

1 - http://www.layar.com/<br>
2 - http://custom.layar.nl/music.mp3<br>
3 - http://custom.layar.nl/video.mp4<br>
4 - tel:+34203201617<br>
5 - mailto:info@layar.com <br>
6 - sms:+34203201617 <br>
7 - plain text on a pop-up (experimental) <br><br><br>

<a href="<? echo $_SERVER['PHP_SELF']; ?>?option=com_layar&view=pois"><?php echo JText::_('BACK_TO_LIST') ?></a>