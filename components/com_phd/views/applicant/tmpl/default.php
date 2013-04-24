<?php
defined('_JEXEC') or die('Restricted access');
?>
<?php
ini_set('display_errors', 0);
?>
<?php
JHTML::_('stylesheet', 'table.css', 'components/com_phd/assets/');
?>

<script type="text/javascript">

/***********************************************
* Textarea Maxlength script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}

</script>

<?php
JHTML::_('behavior.formvalidation');
jimport('joomla.html.pane');
?>

<?php
$pdf_link = JRoute::_('index.php?option=com_phd&view=applicant&format=pdf&tmpl=component&id=' . $this->applicant->id);

if ($this->iamadministrator):
?>
<a href='<?php
    echo $pdf_link;
?>'
	title="<?php
    echo JText::_('VIEW_PDF');
?>" target="_blank"><i>View
PDF </i><img border='0' src='./images/M_images/pdf_button.png'></a>
<br>
<?php
endif;

//print_r($this->applicant);

$myTabs =& JPane::getInstance('tabs', array(
    'startOffset' => $this->active_tab
));
//Create Pane
echo $myTabs->startPane('pane');

/**
 * Personal data. Shown on all the applicants.
 */
echo $myTabs->startPanel(JText::_('PERSONAL_DATA_TAB'), 'tab1');
?>

<?php
if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader 
?>
<?php
    echo JText::_('INTRO_PERSONAL');
?>
<br></br>
<?php
    echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
<?php
endif;
?>

<form action="<?php
echo $this->action;
?>" method="post"
	class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
echo JText::_('PERSONAL_DATA_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class="sectiontableentry1">
			<td width="15%"><?php
echo JText::_('FIRSTNAME');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input type="text"
				name="firstname" value="<?php
    echo $this->applicant->firstname;
?>"
				size="50" maxlength="50" class="required" /> <?php
else:
    echo $this->applicant->firstname;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('LASTNAME');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="lastname"
				value="<?php
    echo $this->applicant->lastname;
?>" size="50"
				maxlength="50" /> <?php
else:
    echo $this->applicant->lastname;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('GENDER');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
    echo $this->lists['genders'];
else:
    echo $this->applicant->gender;
?> <?php
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('PASSPORT');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="passport"
				value="<?php
    echo $this->applicant->passport;
?>" size="20"
				maxlength="20" /> <!--<?php
    echo JHTML::_('tooltip', JText::_('PASSPORT_TOOLTIP'));
?> -->
				<?php
else:
    echo $this->applicant->passport;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('BIRTHDATE');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <?php
    JHTML::_('behavior.calendar');
?>
			<input class="required" type="text" name="birth_date" id="birth_date"
				value="<?php
    echo $this->applicant->birth_date;
?>" size="10"
				maxlength="10" /> <img class="calendar"
				src="./templates/system/images/calendar.png" alt="calendar"
				onclick="return showCalendar('birth_date', '%Y-%m-%d');" /> <?php
else:
    echo $this->applicant->birth_date;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('BIRTHCOUNTRY');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
    echo $this->lists['birthcountries'];
else:
    echo $this->applicant->birth_country;
?> <?php
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('STREET');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="street"
				value="<?php
    echo $this->applicant->street;
?>" size="40"
				maxlength="40" /> <?php
else:
    echo $this->applicant->street;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('CITY');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="city"
				value="<?php
    echo $this->applicant->city;
?>" size="40"
				maxlength="40" /> <?php
else:
    echo $this->applicant->city;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('POSTALCODE');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="postalcode"
				value="<?php
    echo $this->applicant->postalcode;
?>" size="10"
				maxlength="10" /> <?php
else:
    echo $this->applicant->postalcode;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('COUNTRY');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
    echo $this->lists['countries'];
else:
    echo $this->applicant->country;
?> <?php
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('TELEPHONE');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="telephone"
				value="<?php
    echo $this->applicant->telephone;
?>" size="40"
				maxlength="40" /> <?php
else:
    echo $this->applicant->telephone;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('EMAIL');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
if ($this->rights == 'write'):
?> <input
				class="required validate-email" type="text" name="email"
				value="<?php
    echo $this->applicant->email;
?>" size="50"
				maxlength="100" /> <?php
else:
    echo $this->applicant->email;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('WHEREDIDU');
?>: <?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
echo ($this->rights == 'write') ? $this->lists['wheredidu'] : $this->applicant->wheredidu;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('OTHERFELLOWSHIPS');
?>:</td>
			<td><?php
if ($this->rights == 'write'):
    echo $this->lists['other_fellowships'];
else:
    echo ($this->applicant->other_fellowships) ? 'Yes' : 'No';
?> <?php
endif;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td valign="top"><?php
echo JText::_('OTHERFELLOWSHIPS_TEXT');
?>:</td>
			<td><?php
if ($this->rights == 'write'):
?> <textarea
				name="other_fellowships_text" cols="50" rows="4">
				<?php
    echo $this->applicant->other_fellowships_text;
?></textarea> <?php
else:
    echo $this->applicant->other_fellowships_text;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('CAREERBREAKS');
?>:</td>
			<td><?php
if ($this->rights == 'write'):
    echo $this->lists['career_breaks'];
else:
    echo ($this->applicant->career_breaks) ? 'Yes' : 'No';
?> <?php
endif;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td valign="top"><?php
echo JText::_('CAREERBREAKS_TEXT');
?>:</td>
			<td><?php
if ($this->rights == 'write'):
?> <textarea
				name="career_breaks_text" cols="50" rows="4">
				<?php
    echo $this->applicant->career_breaks_text;
?></textarea> <?php
else:
    echo $this->applicant->career_breaks_text;
endif;
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
echo JText::_('CAREERBREAKS_UPLOAD');
?>:</td>
			<td><?php
if ($this->rights == 'write'):
?> <input type='hidden'
				name='MAX_FILE_SIZE' value='2097152' /> <input type='file'
				class='inputbox' name='uploaded_file' /> <?php
    echo ($this->applicant->career_breaks_filename) ? "<img src='./administrator/images/tick.png'> File Uploaded" : '';
?>

				<?php
    if ($this->applicant->career_breaks_filename):
?> <?php
        $filepath = JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $this->applicant->career_breaks_filename);
?> <a href='<?php
        echo $filepath;
?>' style="color: blue;"
				target="_blank"><?php
        echo JText::_('LABEL_DOWNLOAD');
?></a> <?php
    endif;
?>
				<?php
else:
    if ($this->applicant->career_breaks_filename):
        $filepath = JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $this->applicant->career_breaks_filename);
?>
			<a href='<?php
        echo $filepath;
?>' style="color: blue;"
				target="_blank"><?php
        echo $this->applicant->career_breaks_filename;
?></a>
				<?php
    endif;
?> <?php
endif;
?></td>
		</tr>

		<?php
if (($this->rights == 'write')):
?>
		<!-- No write, no buttons -->
		<tr class="sectiontableentry1">
			<td align="left">

			<fieldset class="input">
			<button class="validate" name="save" value="true" type="submit"><?php
    echo JText::_('Save');
?></button>
			<button onclick="window.history.go(-1);return false;"><?php
    echo JText::_('Cancel');
?></button>
			</fieldset>
			<?php
    if ($this->applicant->id):
?> <input type="hidden" name="id"
				value="<?php
        echo $this->applicant->id;
?>" /> <?php
    endif;
?> <input
				type="hidden" name="option" value="com_phd" /> <input type="hidden"
				name="controller" value="applicant" /> <input type="hidden"
				name="view" value="applicant" /> <input type="hidden" name="task"
				value="save_personal_data" /> <input type="hidden" name="check"
				value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
			<td align="right"></td>
		</tr>
		<?php
endif;
?>
	</tbody>
</table>
</form>
		<?php
// end personal data panel
echo $myTabs->endPanel();

/**
 * Academic panel
 */
echo $myTabs->startPanel(JText::_('ACADEMIC_TAB'), 'tab2');
?>

		<?php
if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader 
?>
		<?php
    echo JText::_('INTRO_ACADEMIC');
?>
<br></br>
		<?php
    echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
		<?php
endif;
?>

<!-- Different code if the application is PhD or Postdoc -->
		<?php
if ($this->params->get('phdConfig_Application') == 1) {
?>
<!-- PhD information -->

			<?php
    if (count($this->applicant->academic_data_academic) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th class="white"><?php
        echo JText::_('DEGREE');
?></th>
			<th width='40%' class="white"><?php
        echo JText::_('UNIVERSITY');
?></th>
			<?php
        if (($this->rights == 'write')):
?>
			<th width='10%' align='center' class="white"><?php
            echo JText::_('DELETE');
?></th>
			<?php
        endif;
?>
		</tr>
	</thead>
	<?php
        foreach ($this->applicant->academic_data_academic as $academic_data):
?>
	<tr>
		<td><?php
            echo $academic_data->degree;
?></td>
		<td><?php
            echo $academic_data->university;
?></td>
		<?php
            if (($this->rights == 'write')):
?>
		<!-- No write, no input form -->
		<td align='center'><a
			href='<?php
                echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_academic_data&academic_data_id=<?php
                echo $academic_data->id;
?>&id=<?php
                echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this academic data?');"
			title="<?php
                echo JText::_('DELETE');
?>"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"></a></td>
			<?php
            endif;
?>
	</tr>
	<?php
        endforeach;
?>
</table>
<br></br>
	<?php
    endif;
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('ACADEMIC_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class="sectiontableentry1">
			<td width="15%"><?php
        echo JText::_('DEGREE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input type="text"
				name="degree" size="50" maxlength="100" class="required" /> <?php
        endif;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('UNIVERSITY');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="university" size="50" maxlength="100" /> <?php
        endif;
?>
			</td>
		</tr>
		<?php
        if (($this->rights == 'write')):
?>
		<!-- No write, no buttons -->
		<tr>
			<td align="left" colspan="2">
			<fieldset class="input">
			<button class="validate" name="save" value="true" type="submit"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Save');
?></button>
			<button onclick="window.history.go(-1);return false;"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Cancel');
?></button>
			</fieldset>
			<input type="hidden" name="id"
				value="<?php
            echo $this->applicant->id;
?>" /> <input type="hidden"
				name="type" value="academic" /> <input type="hidden" name="option"
				value="com_phd" /> <input type="hidden" name="controller"
				value="applicant" /> <input type="hidden" name="view"
				value="applicant" /> <input type="hidden" name="task"
				value="save_academic_data" /> <input type="hidden" name="check"
				value="post" /> <?php
            echo JHTML::_('form.token');
?></td>
		</tr>
		<?php
        endif;
?>
	</tbody>
</table>
</form>
		<?php
    endif;
?>
<!-- No write, no input form -->

		<?php
} else {
?>
<!-- PostDoctoral information -->

<table width='100%' border='0'>
	<thead>
		<tr class='mysectiontableheader'>
			<th width='100%' align='center' class="white"><?php
    echo JText::_('POSTDOCTORAL_ACADEMIC_TITLE');
?></th>
		</tr>
	</thead>
</table>
<br></br>
			<?php
    if (count($this->applicant->academic_data_postdoctoral) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th class="white"><?php
        echo JText::_('UNIVERSITY-INSTITUTION');
?></th>
			<!--th width='15%' class="white"><?php //echo JText::_('INSTITUTION'); 
?></th-->
			<th width='10%' class="white"><?php
        echo JText::_('STARTING_DATE');
?></th>
			<th width='10%' class="white"><?php
        echo JText::_('END_DATE');
?></th>
			<th width='10%' class="white"><?php
        echo JText::_('COUNTRY');
?></th>
			<?php
        if (($this->rights == 'write')):
?>
			<th width='10%' align='center' class="white"><?php
            echo JText::_('DELETE');
?></th>
			<?php
        endif;
?>
		</tr>
	</thead>
	<?php
        foreach ($this->applicant->academic_data_postdoctoral as $academic_data):
?>
	<tr>
		<td><?php
            echo $academic_data->university;
?></td>
		<!--td><?php //echo $academic_data->institution; 
?></td-->
		<td><?php
            echo $academic_data->start_date;
?></td>
		<td><?php
            echo $academic_data->end_date;
?></td>
		<td><?php
            echo $academic_data->country;
?></td>
		<?php
            if (($this->rights == 'write')):
?>
		<!-- No write, no input form -->
		<td align='center'><a
			href='<?php
                echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_academic_data&academic_data_id=<?php
                echo $academic_data->id;
?>&id=<?php
                echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this academic data?');"
			title="<?php
                echo JText::_('DELETE');
?>"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"></a></td>
			<?php
            endif;
?>
	</tr>
	<?php
        endforeach;
?>
</table>
<br></br>
	<?php
    endif;
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('POSTDOCTORAL_ACADEMIC_TITLE_ENTER');
?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class="sectiontableentry1">
			<td width="25%"><?php
        echo JText::_('UNIVERSITY-INSTITUTION');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="university" size="50" maxlength="100" /> <?php
        endif;
?>
			</td>
		</tr>
		<!--tr class="sectiontableentry1">
		<td>
			<?php
        /*echo JText::_('INSTITUTION'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
        </td>
        <td>
        <?php if ($this->rights == 'write'): ?>
        <input class="required" type="text" name="institution" size="50" maxlength="100" />
        <?php endif;*/
?>
		</td>
	</tr-->
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('STARTING_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        JHTML::_('behavior.calendar');
?> <input class="required"
				type="text" name="start_date" id="start_date" size="10"
				maxlength="10" /> <img class="calendar"
				src="./templates/system/images/calendar.png" alt="calendar"
				onclick="return showCalendar('start_date', '%Y-%m-%d');" /></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('END_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        JHTML::_('behavior.calendar');
?> <input class="required"
				type="text" name="end_date" id="end_date" size="10" maxlength="10" />
			<img class="calendar" src="./templates/system/images/calendar.png"
				alt="calendar"
				onclick="return showCalendar('end_date', '%Y-%m-%d');" /></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('DEGREECOUNTRY');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        echo $this->lists['degreecountries'];
?></td>
		</tr>
		<?php
        if (($this->rights == 'write')):
?>
		<!-- No write, no buttons -->
		<tr>
			<td align="left" colspan="2">
			<fieldset class="input">
			<button class="validate" name="save" value="true" type="submit"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Save');
?></button>
			<button onclick="window.history.go(-1);return false;"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Cancel');
?></button>
			</fieldset>
			<input type="hidden" name="id"
				value="<?php
            echo $this->applicant->id;
?>" /> <input type="hidden"
				name="type" value="postdoctoral" /> <input type="hidden"
				name="option" value="com_phd" /> <input type="hidden"
				name="controller" value="applicant" /> <input type="hidden"
				name="view" value="applicant" /> <input type="hidden" name="task"
				value="save_academic_data" /> <input type="hidden" name="check"
				value="post" /> <?php
            echo JHTML::_('form.token');
?></td>
		</tr>
		<?php
        endif;
?>
	</tbody>
</table>
</form>
<br></br>
		<?php
    endif;
?>
<!-- No write, no input form -->

<!-- Doctoral information -->

<table width='100%' border='0'>
	<thead>
		<tr class='sectiontableheader'>
			<th width='100%' align='center' class="white"><?php
    echo JText::_('DOCTORAL_ACADEMIC_TITLE');
?></th>
		</tr>
	</thead>
</table>
<br></br>
		<?php
    if (count($this->applicant->academic_data_doctoral) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th class="white"><?php
        echo JText::_('DEGREE');
?></th>
			<th width='20%' class="white"><?php
        echo JText::_('UNIVERSITY-INSTITUTION');
?></th>
			<!--th width='15%' class="white"><?php //echo JText::_('INSTITUTION'); 
?></th-->
			<th width='10%' class="white"><?php
        echo JText::_('STARTING_DATE');
?></th>
			<th width='10%' class="white"><?php
        echo JText::_('OBTENTION_DATE');
?></th>
			<th width='10%' class="white"><?php
        echo JText::_('COUNTRY');
?></th>
			<th width='15%' class="white"><?php
        echo JText::_('THESIS_DIRECTOR_NAME');
?></th>
			<?php
        if (($this->rights == 'write')):
?>
			<th width='10%' align='center' class="white"><?php
            echo JText::_('DELETE');
?></th>
			<?php
        endif;
?>
		</tr>
	</thead>
	<?php
        foreach ($this->applicant->academic_data_doctoral as $academic_data):
?>
	<tr>
		<td><?php
            echo $academic_data->degree;
?></td>
		<td><?php
            echo $academic_data->university;
?></td>
		<!--td><?php //echo $academic_data->institution; 
?></td-->
		<td><?php
            echo $academic_data->start_date;
?></td>
		<td><?php
            echo $academic_data->end_date;
?></td>
		<td><?php
            echo $academic_data->country;
?></td>
		<td><?php
            echo $academic_data->director_name;
?></td>
		<?php
            if (($this->rights == 'write')):
?>
		<!-- No write, no input form -->
		<td align='center'><a
			href='<?php
                echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_academic_data&academic_data_id=<?php
                echo $academic_data->id;
?>&id=<?php
                echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this academic data?');"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"
			title="<?php
                echo JText::_('DELETE');
?>"></a></td>
			<?php
            endif;
?>
	</tr>
	<?php
        endforeach;
?>
</table>
<br></br>
	<?php
    endif;
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('DOCTORAL_ACADEMIC_TITLE_ENTER');
?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr class="sectiontableentry1">
			<td width="25%"><?php
        echo JText::_('DEGREE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input type="text"
				name="degree" size="50" maxlength="100" class="required" /> <?php
        endif;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('UNIVERSITY-INSTITUTION');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="university" size="50" maxlength="100" /> <?php
        endif;
?>
			</td>
		</tr>
		<!--tr class="sectiontableentry1">
		<td>
			<?php
        /*echo JText::_('INSTITUTION'); ?>: <?php echo ($this->rights == 'read')?"":"<span style='color: red;'>*</span>"; ?>
        </td>
        <td>
        <?php if ($this->rights == 'write'): ?>
        <input class="required" type="text" name="institution" size="50" maxlength="100" />
        <?php endif;*/
?>
		</td>
	</tr-->
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('STARTING_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        JHTML::_('behavior.calendar');
?> <input class="required"
				type="text" name="start_date" id="start_date_2" size="10"
				maxlength="10" /> <img class="calendar"
				src="./templates/system/images/calendar.png" alt="calendar"
				onclick="return 	showCalendar('start_date_2', '%Y-%m-%d');" /></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('OBTENTION_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        JHTML::_('behavior.calendar');
?> <input class="required"
				type="text" name="end_date" id="end_date_2" size="10" maxlength="10" />
			<img class="calendar" src="./templates/system/images/calendar.png"
				alt="calendar"
				onclick="return 	showCalendar('end_date_2', '%Y-%m-%d');" /></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('DEGREECOUNTRY');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        echo $this->lists['degreecountries'];
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('DIRECTOR');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="director_name" size="50" maxlength="50" /> <?php
        endif;
?>
			</td>
		</tr>
		<?php
        if (($this->rights == 'write')):
?>
		<!-- No write, no buttons -->
		<tr>
			<td align="left" colspan="2">
			<fieldset class="input">
			<button class="validate" name="save" value="true" type="submit"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Save');
?></button>
			<button onclick="window.history.go(-1);return false;"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Cancel');
?></button>
			</fieldset>
			<input type="hidden" name="id"
				value="<?php
            echo $this->applicant->id;
?>" /> <input type="hidden"
				name="type" value="doctoral" /> <input type="hidden" name="option"
				value="com_phd" /> <input type="hidden" name="controller"
				value="applicant" /> <input type="hidden" name="view"
				value="applicant" /> <input type="hidden" name="task"
				value="save_academic_data" /> <input type="hidden" name="check"
				value="post" /> <?php
            echo JHTML::_('form.token');
?></td>
		</tr>
		<?php
        endif;
?>
	</tbody>
</table>
</form>
<br></br>
		<?php
    endif;
?>
<!-- No write, no input form -->

<!-- Academic information  -->

<table width='100%' border='0'>
	<thead>
		<tr class='sectiontableheader'>
			<th width='100%' align='center' class="white"><?php
    echo JText::_('ACADEMIC_TITLE');
?></th>
		</tr>
	</thead>
</table>
<br></br>
		<?php
    if (count($this->applicant->academic_data_academic) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th width='25%' class="white"><?php
        echo JText::_('DEGREE');
?></th>
			<th width='15%' class="white"><?php
        echo JText::_('UNIVERSITY');
?></th>
			<!-- <th width='10%' class="white"><?php
        echo JText::_('STARTING_DATE');
?></th> -->
			<th width='10%' class="white"><?php
        echo JText::_('COUNTRY');
?></th>
			<th width='10%' class="white"><?php
        echo JText::_('OBTENTION_DATE');
?></th>
			<!-- <th width='20%' class="white"><?php
        echo JText::_('THESIS_DIRECTOR_NAME');
?></th> -->
			<?php
        if (($this->rights == 'write')):
?>
			<th width='10%' align='center' class="white"><?php
            echo JText::_('DELETE');
?></th>
			<?php
        endif;
?>
		</tr>
	</thead>
	<?php
        foreach ($this->applicant->academic_data_academic as $academic_data):
?>
	<tr>
		<td><?php
            echo $academic_data->degree;
?></td>
		<td><?php
            echo $academic_data->university;
?></td>
		<!-- <td><?php
            echo $academic_data->start_date;
?></td> -->
		<td><?php
            echo $academic_data->country;
?></td>
		<td><?php
            echo $academic_data->end_date;
?></td>
		<!-- <td><?php
            echo $academic_data->director_name;
?></td> -->
		<?php
            if (($this->rights == 'write')):
?>
		<!-- No write, no input form -->
		<td align='center'><a
			href='<?php
                echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_academic_data&academic_data_id=<?php
                echo $academic_data->id;
?>&id=<?php
                echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this academic data?');"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"
			title="<?php
                echo JText::_('DELETE');
?>"></a></td>
			<?php
            endif;
?>
	</tr>
	<?php
        endforeach;
?>
</table>
<br></br>
	<?php
    endif;
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('ACADEMIC_TITLE_ENTER');
?>
			</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan='2'><?php
        echo JText::_('INTRO_ACADEMIC_TITLE');
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td width="25%"><?php
        echo JText::_('DEGREE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input type="text"
				name="degree" size="50" maxlength="100" class="required" /> <?php
        endif;
?>
			</td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('UNIVERSITY');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        if ($this->rights == 'write'):
?> <input class="required"
				type="text" name="university" size="50" maxlength="100" /> <?php
        endif;
?>
			</td>
		</tr>
		<!--
	
	 Not for the new form
	 
	<tr class="sectiontableentry1">
		<td>
			<?php
        echo JText::_('STARTING_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td>
			<?php
        JHTML::_('behavior.calendar');
?>
			<input class="required" type="text" name="start_date" id="start_date" size="10" maxlength="10"/>
			<img class="calendar" src="./templates/system/images/calendar.png" alt="calendar" onclick="return 	showCalendar('start_date', '%Y-%m-%d');" /> 
		</td>
	</tr>
	-->
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('DEGREECOUNTRY');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        echo $this->lists['degreecountries'];
?></td>
		</tr>
		<tr class="sectiontableentry1">
			<td><?php
        echo JText::_('OBTENTION_DATE');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
			</td>
			<td><?php
        JHTML::_('behavior.calendar');
?> <input class="required"
				type="text" name="end_date" id="end_date_3" size="10" maxlength="10" />
			<img class="calendar" src="./templates/system/images/calendar.png"
				alt="calendar"
				onclick="return 	showCalendar('end_date_3', '%Y-%m-%d');" /></td>
		</tr>
		<!-- 
	<tr class="sectiontableentry1">
		<td>
			<?php
        echo JText::_('DIRECTOR');
?>: <?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td>
			<?php
        if ($this->rights == 'write'):
?>
				<input class="required" type="text" name="director_name" size="50" maxlength="50" />
			<?php
        endif;
?>
		</td>
	</tr>
	-->
	<?php
        if (($this->rights == 'write')):
?>
		<!-- No write, no buttons -->
		<tr>
			<td align="left" colspan="2">
			<fieldset class="input">
			<button class="validate" name="save" value="true" type="submit"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Save');
?></button>
			<button onclick="window.history.go(-1);return false;"
			<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Cancel');
?></button>
			</fieldset>
			<input type="hidden" name="id"
				value="<?php
            echo $this->applicant->id;
?>" /> <input type="hidden"
				name="type" value="academic" /> <input type="hidden" name="option"
				value="com_phd" /> <input type="hidden" name="controller"
				value="applicant" /> <input type="hidden" name="view"
				value="applicant" /> <input type="hidden" name="task"
				value="save_academic_data" /> <input type="hidden" name="check"
				value="post" /> <?php
            echo JHTML::_('form.token');
?></td>
		</tr>
		<?php
        endif;
?>
	</tbody>
</table>
</form>
		<?php
    endif;
?>
<!-- No write, no input form -->

		<?php
} // closing the main if between Postdoc or phd
?>

		<?php
// end Academic panel
echo $myTabs->endPanel();

/**
 * Files panel
 */
echo $myTabs->startPanel(JText::_('FILES_TAB'), 'tab3');
?>

		<?php
if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader 
?>
		<?php
    echo JText::_('INTRO_FILES');
?>
<br></br>
		<?php
    echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
		<?php
endif;
?>

		<?php
if (count($this->applicant->files) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th width='20%' class="white"><?php
    echo JText::_('TYPE');
?></th>
			<th width='20%' class="white"><?php
    echo JText::_('FILE');
?></th>
			<th class="white"><?php
    echo JText::_('DESCRIPTION');
?></th>
			<?php
    if ($this->rights == 'write'):
?>
			<th width='10%' align='center' class="white"><?php
        echo JText::_('DELETE');
?></th>
			<?php
    endif;
?>
		</tr>
	</thead>
	<?php
    foreach ($this->applicant->files as $file):
?>
	<tr>
		<td><?php
        echo $file->doc_type;
?></td>
		<td><a
			href="<?php
        echo JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $file->filename);
?>"
			style="color: blue;" target="_blank"><?php
        echo $file->filename;
?></a>
		</td>
		<td><?php
        echo $file->description;
?></td>
		<?php
        if ($this->rights == 'write'):
?>
		<td align='center'><a
			href='<?php
            echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_file&file_id=<?php
            echo $file->id;
?>&id=<?php
            echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this file?');"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"
			title="<?php
            echo JText::_('DELETE');
?>"></a></td>
			<?php
        endif;
?>
	</tr>
	<?php
    endforeach;
?>
</table>
<br></br>
	<?php
endif;
?>

	<?php

if (count($this->applicant->files) >= $this->params->get('phdConfig_MaxNumberOfFiles')):
    echo JText::_('MAX_NUM_FILES_REACHED');
elseif ($this->rights == 'write'):
?>

<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('FILES_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%"><?php
    echo JText::_('TYPE');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><?php
    echo $this->lists['doctypelist'];
?></td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
    echo JText::_('UPLOAD_FILE');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><input type='hidden' name='MAX_FILE_SIZE' value='2097152' /> <input
			type='file' class='inputbox' name='uploaded_file'></td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
    echo JText::_('DESCRIPTION');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><input class="required" type="text" name="description" size="60"
			maxlength="250" /></td>
	</tr>

	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_file" /> <input type="hidden" name="check" value="post" />
			<?php
    echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
endif;
?>
</table>
</form>

	<?php
// end files panel
echo $myTabs->endPanel();

/**
 * Letters panel
 */
echo $myTabs->startPanel(JText::_('LETTERS'), 'tab4');
?>

	<?php
if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader 
?>
	<?php
    echo JText::_('INTRO_LETTERS');
?>
<br></br>
	<?php
    echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
	<?php
endif;
?>

	<?php
if (count($this->applicant->referees) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th width='15%' class="white"><?php
    echo JText::_('REFEREE_FIRST_NAME');
?></th>
			<th width='15%' class="white"><?php
    echo JText::_('REFEREE_LAST_NAME');
?></th>
			<th width='20%' class="white"><?php
    echo JText::_('REFEREE_EMAIL');
?></th>
			<th width='10%' class="white"><?php
    echo JText::_('REFEREE_SENT_MAIL');
?></th>

			<?php
    if (($this->iamadministrator || $this->iamgroupleader || $this->iamcommittee)):
?>
			<th class="white"><?php
        echo JText::_('RECOMENDATION_LETTER');
?></th>
			<?php
    endif;
?>
			<?php
    if (!$this->iamgroupleader && !$this->iamcommittee):
?>
			<th class="white"><?php
        echo JText::_('SEND_MAIL');
?></th>
			<?php
    endif;
?>
			<th width='10%' align='center' class="white"><?php
    echo JText::_('STATUS');
?></th>
			<?php
    if ($this->rights == 'write'):
?>
			<th width='10%' align='center' class="white"><?php
        echo JText::_('DELETE');
?></th>
			<?php
    endif;
?>
		</tr>
	</thead>
	<?php
    foreach ($this->applicant->referees as $referee):
?>
	<tr>
		<td><?php
        echo $referee->firstname;
?></td>
		<td><?php
        echo $referee->lastname;
?></td>
		<td><?php
        if ($this->iamadministrator && !$referee->filename):
?> <?php
            echo $referee->email;
?>
		<?php
        else:
?> <?php
            echo $referee->email;
?> <?php
        endif;
?></td>
		<td><?php
        echo ($referee->sent_mail == '') ? JText::_('NOT_SENT') : date('Y-m-d', strtotime($referee->sent_mail));
?></td>

		<?php
        if (($this->iamadministrator || $this->iamgroupleader || $this->iamcommittee)):
?>
		<td><?php
            if ($referee->filename):
?> <a
			href="<?php
                echo JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $referee->filename);
?>"
			style="color: blue;" target="_blank"><?php
                echo $referee->filename;
?></a>
			<?php
            endif;
?> <!--
		<?php
            if ($this->iamadministrator):
?>
		<form action="<?php
                echo $this->action;
?>" method="post" class="form-validate" enctype="multipart/form-data">
			<input type='hidden' name='MAX_FILE_SIZE' value='2097152' />
			<input type='file' class='inputbox' name='uploaded_file'>
			<button class="validate" name="save" value="true" type="submit"><?php
                echo JText::_('Upload');
?></button>
			<?php
                if ($referee->filename):
?>
				<input type="hidden" name="old_filename" value="<?php
                    echo $referee->filename;
?>" />
			<?php
                endif;
?>
			<input type="hidden" name="id" value="<?php
                echo $this->applicant->id;
?>" />
			<input type="hidden" name="referee_id" value="<?php
                echo $referee->id;
?>" />
			<input type="hidden" name="option" value="com_phd" />
			<input type="hidden" name="controller" value="applicant" />
			<input type="hidden" name="view" value="applicant" />
			<input type="hidden" name="task" value="save_referee" />
			<input type="hidden" name="check" value="post"/>
			<?php
                echo JHTML::_('form.token');
?>
		</form>
		<?php
            endif;
?>
		--></td>
		<?php
        endif;
?>

		<?php
        if (!$this->iamgroupleader && !$this->iamcommittee):
?>
		<td align='center'><a
			href='<?php
            echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=referee&task=email_referee&referee_id=<?php
            echo $referee->id;
?>&id=<?php
            echo $this->applicant->id;
?>'
			onClick="return confirm('<?php
            echo JText::_('REFEREE_EMAIL_MSG');
?>')."
			title="<?php
            echo JText::_('SEND_MAIL');
?>"><IMG
			src='./components/com_phd/assets/Mail.png' border='0'></a></td>
			<?php
        endif;
?>

		<td align='center'><?php
        if ($referee->filename):
?> <img
			src="./administrator/images/publish_g.png"
			title="<?php
            echo JText::_('FILE_UPLOADED');
?>"> <?php
        else:
?> <img
			src="./administrator/images/publish_r.png"
			title="<?php
            echo JText::_('FILE_NOT_UPLOADED');
?>"> <?php
        endif;
?>
		</td>
		<?php
        if ($this->rights == 'write'):
?>
		<td align='center'><a
			href='<?php
            echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_referee&referee_id=<?php
            echo $referee->id;
?>&id=<?php
            echo $this->applicant->id;
?>'
			onClick="return confirm('<?php
            echo JText::_('REFEREE_DELETE_MSG');
?>');"
			title="<?php
            echo JText::_('DELETE');
?>"><IMG
			src='./components/com_phd/assets/Delete.png' border='0'></a></td>
			<?php
        endif;
?>
	</tr>
	<?php
    endforeach;
?>
</table>
<br></br>
	<?php
endif;
?>

	<?php
if ($this->rights == 'write'):
?>
<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('LETTERS_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="20%"><?php
    echo JText::_('REFEREE_FIRST_NAME');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><input class="required" type="text" name="firstname" size="30" />
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
    echo JText::_('REFEREE_LAST_NAME');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><input class="required" type="text" name="lastname" size="30" /></td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
    echo JText::_('REFEREE_EMAIL');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><input class="required validate-email" type="text" name="email"
			size="30" /></td>
	</tr>
	<?php
    if ($this->iamadministrator):
?>
	<tr class="sectiontableentry1">
		<td><?php
        echo JText::_('UPLOAD_FILE');
?>:</td>
		<td><input type='hidden' name='MAX_FILE_SIZE' value='2097152' /> <input
			type='file' class='inputbox' name='uploaded_file'></td>
	</tr>
	<?php
    endif;
?>
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_referee" /> <input type="hidden" name="check"
			value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
endif;
?>
</table>
</form>
	<?php
// end letters panel
echo $myTabs->endPanel();

/**
 * Work panel
 */
if ($this->params->get('phdConfig_Application') == '1'): //Only display for PhD
    echo $myTabs->startPanel(JText::_('WORK_TAB'), 'tab5');
?>

	<?php
    if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader 
?>
	<?php
        echo JText::_('INTRO_WORK');
?>
<br></br>
	<?php
        echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
	<?php
    endif;
?>

	<?php
    if (count($this->applicant->work_experience) > 0):
?>
<table width='100%' border='0' class="table">
	<thead>
		<tr class='sectiontableheader'>
			<th width='90%' class="white"><?php
        echo JText::_('DESCRIPTION');
?></th>
			<?php
        if (($this->rights == 'write')):
?>
			<th width='10%' align='center' class="white"><?php
            echo JText::_('DELETE');
?></th>
			<?php
        endif;
?>
		</tr>
	</thead>
	<?php
        foreach ($this->applicant->work_experience as $work_experience):
?>
	<tr>
		<td><?php
            echo $work_experience->experience;
?></td>
		<?php
            if (($this->rights == 'write')):
?>
		<td align='center'><a
			href='<?php
                echo $_SERVER['PHP_SELF'];
?>?option=com_phd&controller=applicant&task=del_work_experience&work_experience_id=<?php
                echo $work_experience->id;
?>&id=<?php
                echo $this->applicant->id;
?>'
			onClick="return confirm('Are you sure you want to delete this work_experience?');"><IMG
			src='./components/com_phd/assets/Delete.png' border="0"></a></td>
			<?php
            endif;
?>
	</tr>
	<?php
        endforeach;
?>
</table>
<br></br>
	<?php
    endif;
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('WORK_TITLE');
?></th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
        echo JText::_('WORKEXPERIENCE');
?>:
		<?php
        echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><?php
        if ($this->rights == 'write'):
?> <textarea
			name="work_experience" cols="50" rows="4" class="required"
			maxlength="4000" onkeyup="return ismaxlength(this)"></textarea> <?php
        endif;
?>
		</td>
	</tr>
	<?php
        if (($this->rights == 'write')):
?>
	<!-- No write, no buttons -->
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
            echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
            echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
            echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_work_experience" /> <input type="hidden" name="check"
			value="post" /> <?php
            echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
        endif;
?>
</table>
</form>
	<?php
    endif;
?>
<!-- No write, no input form -->
	<?php
    // end work panel
    echo $myTabs->endPanel();
endif; //Only display for PhD

/**
 * Phd thesis panel
 */
if ($this->params->get('phdConfig_Application') == '2'):
    echo $myTabs->startPanel(JText::_('PHDTHESIS_TAB'), 'tab6b');
    
    if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader
        echo JText::_('INTRO_PHDTHESIS');
?>
<br></br>
	<?php
        echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
	<?php
    endif;
?>

<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('PHDTHESIS_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
    echo JText::_('PHDTHESIS');
?>: <?php
    echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><?php
    if (($this->rights == 'write')):
?> <textarea
			name="phd_thesis" cols="50" rows="4" class="required"><?php
        echo $this->applicant->phd_thesis;
?></textarea>
			<?php
    else:
?> <?php
        echo $this->applicant->phd_thesis;
?> <?php
    endif;
?>
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
    echo JText::_('PHDLECTURE_DATE');
?>:
		</td>
		<td><?php
    if ($this->rights == 'write'):
?> <input 
			type="text" name="expected_lecture" value="<?php
        echo $this->applicant->expected_lecture;
?>" size="50" /> <?php
    else:
        echo $this->applicant->expected_lecture;
    endif;
?></td>
		</td>
	</tr>	
	<?php
    if (($this->rights == 'write')):
?>
	<!-- No write, no input form -->
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
        echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_personal_data" /> <input type="hidden" name="check"
			value="post" /> <?php
        echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
    endif;
?>
</table>
</form>

	<?php
    // end phd thesis panel
    echo $myTabs->endPanel();
endif;

/**
 * Research experience panel
 */
if ($this->params->get('phdConfig_Application') == '2'):
    echo $myTabs->startPanel(JText::_('RESEARCH_EXPERIENCE_TAB'), 'tab6c');
    
    if (!$this->iamgroupleader): //Do not show intro data if i am a Group Leader
        echo JText::_('INTRO_RESEARCH_EXPERIENCE');
?>
<br></br>
	<?php
        echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
	<?php
    endif;
?>

<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('RESEARCH_EXPERIENCE_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
    echo JText::_('RESEARCH_EXPERIENCE');
?>:
		</td>
		<td><?php
    if (($this->rights == 'write')):
?> <textarea
			name="research_experience" cols="50" rows="4" class="required"><?php
        echo $this->applicant->research_experience;
?></textarea>
			<?php
    else:
?> <?php
        echo $this->applicant->research_experience;
?> <?php
    endif;
?>
		</td>
	</tr>

	<?php
    if (($this->rights == 'write')):
?>
	<!-- No write, no input form -->
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
        echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_personal_data" /> <input type="hidden" name="check"
			value="post" /> <?php
        echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
    endif;
?>
</table>
</form>
	<?php
    // end research experience panel
    echo $myTabs->endPanel();
endif;

/**
 * Programmes panel
 */
if ($this->params->get('phdConfig_Application') == 1) {
    echo $myTabs->startPanel(JText::_('PROGRAMMES_TAB'), 'tab6');
} else {
    echo $myTabs->startPanel(JText::_('RESEARCH_GROUPS_TAB'), 'tab6');
}
?>

	<?php
//Do not show intro data if i am a Group Leader
if (!$this->iamgroupleader):
    if ($this->params->get('phdConfig_Application') == 1) {
        echo JText::_('INTRO_PROGRAMMES');
    } else {
        echo JText::_('INTRO_RESEARCH_GROUPS');
    }
endif;
?>
<br></br>
	<?php
echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>

<form action="<?php
echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
if ($this->params->get('phdConfig_Application') == 1) {
    echo JText::_('PROGRAMMES_TITLE');
} else {
    echo JText::_('RESEARCH_GROUPS_TITLE');
}
?></th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
echo JText::_('PROGRAMMES_1_OPTION');
?>:
		<?php
echo ($this->rights == 'read') ? "" : "<span style='color: red;'>*</span>";
?>
		</td>
		<td><?php
if ($this->rights == 'write'):
    echo $this->lists['programmeslist'];
else:
    echo $this->applicant->programme_1;
?> <?php
endif;
?></td>
	</tr>
	<?php
if (($this->rights == 'write') || ($this->applicant->programme_2)):
?>
	<tr class="sectiontableentry1">
		<td valign="top"><?php
    echo JText::_('PROGRAMMES_2_OPTION');
?>:</td>
		<td><?php
    if ($this->rights == 'write'):
        echo $this->lists['programmeslist2'];
    else:
        echo $this->applicant->programme_2;
?> <?php
    endif;
?></td>
	</tr>
	<?php
endif;
?>
	<?php
if (($this->rights == 'write')):
?>
	<!-- No write, no input form -->
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_programmes" /> <input type="hidden" name="check"
			value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
	<?php
endif;
?>
</table>
</form>
	<?php
// end programmes panel
echo $myTabs->endPanel();

/**
 * Ethical issue panel
 */
if ($this->params->get('phdConfig_Application') == '2'):
    echo $myTabs->startPanel(JText::_('ETHICAL_ISSUE_TAB'), 'tab6c');
?>

	<?php
    if (($this->rights == 'write')):
?>
<!-- No write, no input form -->
<form action="<?php
        echo $this->action;
?>" method="post"
	class="form-validate">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('ETHICAL_ISSUE_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
        echo JText::_('ETHICAL_ISSUE');
?>:
		</td>
		<td><?php
        echo ($this->rights == 'write') ? $this->lists['ethical_issue'] : $this->applicant->ethical_issue;
?>
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<td valign="top"><?php
        echo JText::_('ETHICAL_ISSUE_TEXT');
?>:</td>
		<td><?php
        echo ($this->rights == 'write') ? $this->lists['ethical_issues_list'] : $this->applicant->ethical_issues_list;
?>
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<td align="left">

		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
        echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
        echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
        echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_ethical_issues" /> <input type="hidden" name="check"
			value="post" /> <?php
        echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
</table>
</form>
		<?php
    else:
?>
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
        echo JText::_('ETHICAL_ISSUE_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td width="15%" valign="top"><?php
        echo JText::_('ETHICAL_ISSUE');
?>:
		</td>
		<td><?php
        echo ($this->applicant->ethical_issue) ? JText::_('YES') : JText::_('NO');
?>
		</td>
	</tr>
	<tr class="sectiontableentry1">
		<td valign="top"><?php
        echo JText::_('ETHICAL_ISSUE_TEXT');
?>:</td>
		<td><?php
        echo $this->applicant->ethical_issue_text;
?></td>
	</tr>
</table>
		<?php
    endif;
?>
		<?php
    // end ethical issue panel
    echo $myTabs->endPanel();
endif;

/**
 * Additional info pannel
 */
if (($this->iamadministrator) || ($this->iamgroupleader) || ($this->iamcommittee)):
    echo $myTabs->startPanel(JText::_('INFO_TAB'), 'tab7');
?>

		<?php
    if ($this->iamadministrator):
?>
		<?php
        echo JText::_('INTRO_ADDITIONAL_INFO');
?>
<br></br>
		<?php
        echo JText::_('COMPULSORY_FIELDS_TEXT');
?>
<br></br>
<br></br>
		<?php
    endif;
?>

<form
	action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate" enctype="multipart/form-data">
<table width="100%" class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('INFO_TITLE');
?></th>
		</tr>
	</thead>
	<tr class="sectiontableentry1">
		<td><?php
    if ($this->rights == 'write'):
?> <textarea
			name="additional_info" cols="50" rows="4"><?php
        echo $this->applicant->additional_info;
?></textarea>
			<?php
    else:
?> <?php
        echo $this->applicant->additional_info;
?> <?php
    endif;
?>
		</td>
	</tr>
</table>
<!-- The table format is different so we do a new one -->
<table width="100%" class="table">
	<tr class="sectiontableentry1">
		<td width="17%"><?php
    echo JText::_('INFO_FILE');
?>:</td>
		<td><?php
    if ($this->rights == 'write'):
?> <input type='hidden'
			name='MAX_FILE_SIZE' value='2097152' /> <input type='file'
			class='inputbox' name='additional_file' /> <?php
        echo ($this->applicant->additional_info_filename) ? "<img src='./administrator/images/tick.png'> File Uploaded" : '';
?>

			<?php
        if ($this->applicant->additional_info_filename):
?> <?php
            $filepath = JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $this->applicant->additional_info_filename);
?> <a href='<?php
            echo $filepath;
?>' style="color: blue;"
			target="_blank"><?php
            echo JText::_('LABEL_DOWNLOAD');
?></a> <?php
        endif;
?>
			<?php
    else:
        if ($this->applicant->additional_info_filename):
            $filepath = JPath::clean(JURI::base(true) . $this->params->get('phdConfig_DocsPath') . DS . $this->applicant->id . DS . $this->applicant->additional_info_filename);
?>
		<a href='<?php
            echo $filepath;
?>' style="color: blue;"
			target="_blank"><?php
            echo $this->applicant->additional_info_filename;
?></a>
			<?php
        endif;
?> <?php
    endif;
?></td>
	</tr>
	<?php
    if ($this->iamadministrator && $this->params->get('phdConfig_Application') == 2):
?>
	<tr class="sectiontableentry1">
		<td><?php
        echo JText::_('RESP_COMMITTEE');
?>:</td>
		<td><?php
        if ($this->rights == 'write'):
            echo $this->lists['committee_username0'] . ' ';
            echo JHTML::_('tooltip', JText::_('COMMITTEE_TOOLTIP'));
        else:
            echo $this->applicant->committee_list[0]->name;
?> <?php
        endif;
?></td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
        echo JText::_('RESP_COMMITTEE');
?>:</td>
		<td><?php
        if ($this->rights == 'write'):
            echo $this->lists['committee_username1'] . ' ';
            echo JHTML::_('tooltip', JText::_('COMMITTEE_TOOLTIP'));
        else:
            echo $this->applicant->committee_list[1]->name;
?> <?php
        endif;
?></td>
	</tr>
	<tr class="sectiontableentry1">
		<td><?php
        echo JText::_('RESP_COMMITTEE');
?>:</td>
		<td><?php
        if ($this->rights == 'write'):
            echo $this->lists['committee_username2'] . ' ';
            echo JHTML::_('tooltip', JText::_('COMMITTEE_TOOLTIP'));
        else:
            echo $this->applicant->committee_list[2]->name;
?> <?php
        endif;
?></td>
	</tr>
	<?php
    endif;
?>
	<tr class="sectiontableentry1">
		<td align="left">
		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"
		<?php
    echo ($this->rights == 'write') ? '' : 'disabled';
?>><?php
    echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"
		<?php
    echo ($this->applicant->id) ? '' : 'disabled';
?>><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="save_personal_data" /> <input type="hidden" name="check"
			value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
	</tr>
</table>
</form>
		<?php
    // end additional info panel
    echo $myTabs->endPanel();
endif;

/**
 * Status panel
 */

// administrator can always change everything
if ($this->iamadministrator) {
    echo $myTabs->startPanel(JText::_('STATUS_TAB'), 'tab8');
?>
<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate">
<table width='100%' border='0' class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('STATUS_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr>
		<td width="15%"><?php
    echo JText::_('ACTUAL_STATUS');
?>:</td>
		<td><?php
    echo $this->applicant->status;
?></td>
	</tr>
	<tr>
		<td><?php
    echo JText::_('NEW_STATUS');
?>:</td>
		<td><?php
    echo $this->lists['statuslist'];
?></td>
	</tr>
	<tr>
		<td colspan="2"><?php
    echo JText::_('CHECK_TO_SEND_MAIL');
?> <INPUT
			name="send_mail" type="checkbox" value="yes"></td>
	</tr>
	<tr class="sectiontableentry1">
		<td align="left">
		<fieldset class="input">
		<button class="validate" name="save" value="true" type="submit"><?php
    echo JText::_('Save');
?></button>
		<button onclick="window.history.go(-1);return false;"><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="change_status" /> <input type="hidden" name="check"
			value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
</table>
</form>
			<?php
    echo $myTabs->endPanel();
}

// applicants with status = editing can submit the application
if (!($this->iamadministrator || $this->iamgroupleader || $this->iamcommittee) && ($this->applicant->status_id == 1)) {
    echo $myTabs->startPanel(JText::_('STATUS_TAB'), 'tab8');
    
    echo JText::_('INTRO_STATUS');
?>
<br></br>
<br></br>

<form action="<?php
    echo $this->action;
?>" method="post"
	class="form-validate">
<table width='100%' border='0'>
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('STATUS_TITLE');
?>
			</th>
		</tr>
	</thead>
	<!-- <tr><td class='componentheading' colspan=4><?php
    echo JText::_('SUBMIT_APPLICATION');
?></td></tr>-->
	<tr>
		<td colspan=2><?php
    echo $this->apply_details->message;
?></td>
	</tr>
	<tr class="sectiontableentry1">
		<td align="left">
		<fieldset class="input">
		<button type='submit' name='submit_button' value='Submit'
		<?php
    echo $this->apply_details->disabled;
?>><?php
    echo JText::_('Submit');
?></button>
		<button onclick="window.history.go(-1);return false;"><?php
    echo JText::_('Cancel');
?></button>
		</fieldset>
		<input type="hidden" name="id"
			value="<?php
    echo $this->applicant->id;
?>" /> <input type="hidden"
			name="option" value="com_phd" /> <input type="hidden"
			name="controller" value="applicant" /> <input type="hidden"
			name="view" value="applicant" /> <input type="hidden" name="task"
			value="submit_application" /> <input type="hidden" name="check"
			value="post" /> <?php
    echo JHTML::_('form.token');
?></td>
		<td align="right"></td>
	</tr>
</table>
</form>
		<?php
    echo $myTabs->endPanel();
}

// applicants with status != editing can see their status
if (!($this->iamadministrator || $this->iamgroupleader || $this->iamcommittee) && ($this->applicant->status_id != 1) && ($this->applicant->status_id)) {
    echo $myTabs->startPanel(JText::_('STATUS_TAB'), 'tab8');
?>
<table width='100%' border='0'>
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php
    echo JText::_('STATUS_TITLE');
?>
			</th>
		</tr>
	</thead>
	<tr>
		<td colspan=2><?php
    echo JText::_('YOUR_STATUS') . ' ';
?><b><?php
    echo $this->applicant->status;
?>.</b></td>
	</tr>
</table>
			<?php
    echo $myTabs->endPanel();
}

// end Pane
echo $myTabs->endPane();
?>