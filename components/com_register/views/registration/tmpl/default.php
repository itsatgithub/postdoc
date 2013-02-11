<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('stylesheet', 'table.css', 'components/com_register/assets/'); ?>

<?php JHTML::_('behavior.formvalidation'); ?>

<?php //BFBehavior::formbfvalidation(); ?>

<script language="javascript" type="text/javascript">
	function invoice_data_copy() {
		if(document.registrationForm.choice_accounting[0].checked == false){
			document.registrationForm.invoice_institution.value = document.registrationForm.institution.value;
			document.registrationForm.invoice_address.value = document.registrationForm.address.value;
			document.registrationForm.invoice_zip.value = document.registrationForm.postalcode.value;
			document.registrationForm.invoice_city.value = document.registrationForm.city.value;
			document.registrationForm.invoice_country_id.value = document.registrationForm.country_id.value;
		} else {
			document.registrationForm.invoice_institution.value="";
			document.registrationForm.invoice_address.value="";
			document.registrationForm.invoice_zip.value="";
			document.registrationForm.invoice_city.value="";
			document.registrationForm.invoice_country_id.value="";
		}
	}

	function myValidate(f) {
		if (document.formvalidator.isValid(f)) {
			f.check.value='<?php echo JUtility::getToken(); ?>';//send token
			return true; 
		}
		else {
      var msg = 'Some values are not acceptable.  Please retry.';
 
      //Example on how to test specific fields
      if($('email').hasClass('invalid')){msg += '\n\n\t* Invalid E-Mail Address';}
 
      alert(msg);

			alert('Some values are not acceptable or empty.  Please retry.');
		}
		return false;
	}


        Window.onDomReady(function(){
                document.formvalidator.setHandler('emailverify', function (value) {
		if (document.registrationForm.email.value != value){
			return false;
		}
		return true;
		})

		/*document.formvalidator.setHandler('selectradio', function (value) {
		if (value == '0'){
			return false;
		}
		return true;
		})*/
        })

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

<?php if ($this->congress->cost_javascript) {
	echo $this->congress->cost_javascript;
} ?>

</script>

<?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
<div
	class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
<?php echo $this->escape($this->params->get('page_title')); ?></div>
<?php endif; ?>

<?php if (($this->congress->registration_limit) && (!$this->editing_registration)) {
	if ($this->num_registered_people >= $this->congress->registration_limit) {
		echo $this->congress->registration_limit_text;
		return true;
	}
}

if (!$this->editing_registration) :
echo $this->congress->registration_text;
endif;
?>

<form
	action="<?php echo $this->action; ?>" method="post"
	name="registrationForm" id="registrationForm" class="form-validate"
	onSubmit="return myValidate(this);"><!-- Variable used to check the validation of the form fields -->
<input type="hidden" name="check" value="post" />

<table cellpadding="4" cellspacing="1" border="0" width="100%"
	class="table">
	<thead>
		<tr class="sectiontableheader">
			<th colspan='2' class="white"><?php echo JText::_( 'REGISTRATION_DETAILS_LABEL'); ?>
			</th>
		</tr>
	</thead>

	<?php
	if (( $this->menu_params->get( 'academic_title')) || (!empty($this->registration->title))): ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'ACADEMIC_TITLE_LABEL' ); ?><?php if ( $this->menu_params->get( 'academic_title')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get( 'academic_title')=='2') echo "class='required'"; ?>
			type="text" name="title"
			value="<?php echo $this->registration->title; ?>" size="10"
			maxlength="20" /></td>
	</tr>
	<?php endif; ?>
	<?php if (( $this->menu_params->get('firstname')) || (!empty($this->registration->firstname))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'FIRST_NAME_LABEL' ); ?><?php if ( $this->menu_params->get('firstname')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('firstname')=='2') echo "class='required'"; ?>
			type="text" name="firstname"
			value="<?php echo $this->registration->firstname; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('lastname')) || (!empty($this->registration->lastname))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'LAST_NAME_LABEL' ); ?><?php if ( $this->menu_params->get('lastname')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('lastname')=='2') echo "class='required'"; ?>
			type="text" name="lastname"
			value="<?php echo $this->registration->lastname; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('gender')) || (!empty($this->registration->gender))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'GENDER_LABEL' ); ?><?php if ( $this->menu_params->get( 'gender')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['choice_gender']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('institution')) || (!empty($this->registration->institution))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INSTITUTION_LABEL' ); ?><?php if ( $this->menu_params->get( 'institution')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('institution')=='2') echo "class='required'"; ?>
			type="text" name="institution"
			value="<?php echo $this->registration->institution; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('registration_type')) || (!empty($this->registration->registration_type_id))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'REGISTRATION_FEE_LABEL' ); ?><?php if ( $this->menu_params->get( 'registration_type')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['registration_type']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('member')) || (!empty($this->registration->member))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'MEMBERSHIP_LABEL' ); ?><?php if ( $this->menu_params->get( 'member')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['choice_member']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('address')) || (!empty($this->registration->address))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'ADDRESS_LABEL' ); ?><?php if ( $this->menu_params->get( 'address')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('address')=='2') echo "class='required'"; ?>
			type="text" name="address"
			value="<?php echo $this->registration->address; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('city')) || (!empty($this->registration->city))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'CITY_LABEL' ); ?><?php if ( $this->menu_params->get( 'city')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('city')=='2') echo "class='required'"; ?>
			type="text" name="city"
			value="<?php echo $this->registration->city; ?>" size="55"
			maxlength="100" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('postal_code')) || (!empty($this->registration->postalcode))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><label for="postalcode"> <?php echo JText::_( 'POSTALCODE_LABEL' ); ?><?php if ( $this->menu_params->get( 'postal_code')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</label></td>
		<td><input
		<?php if ( $this->menu_params->get('postal_code')=='2') echo "class='required'"; ?>
			type="text" name="postalcode"
			value="<?php echo $this->registration->postalcode; ?>" size="10"
			maxlength="10" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('country')) || (!empty($this->registration->country_id))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'COUNTRY_LABEL' ); ?><?php if ( $this->menu_params->get( 'country')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['countries']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('email')) || (!empty($this->registration->email))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'EMAIL_LABEL' ); ?><?php if ( $this->menu_params->get( 'email')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('email')=='2') echo "class='required validate-email'"; ?>
			type="text" name="email"
			value="<?php echo $this->registration->email; ?>" size="50"
			maxlength="100" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('email2')) || (!empty($this->registration->email2))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'REPEAT_EMAIL_LABEL' ); ?><?php if ( $this->menu_params->get( 'email2')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('email')=='2') echo "class='required validate-emailverify'"; ?>
			type="text" name="email2"
			value="<?php echo $this->registration->email; ?>" size="50"
			maxlength="100" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('daytime_phone')) || (!empty($this->registration->telephone1))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PHONE1_LABEL' ); ?><?php if ( $this->menu_params->get( 'daytime_phone')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('daytime_phone')=='2') echo "class='required'"; ?>
			type="text" name="telephone1"
			value="<?php echo $this->registration->telephone1; ?>" size="20"
			maxlength="20" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('alternative_phone')) || (!empty($this->registration->telephone2))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PHONE2_LABEL' ); ?><?php if ( $this->menu_params->get( 'alternative_phone')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('alternative_phone')=='2') echo "class='required'"; ?>
			type="text" name="telephone2"
			value="<?php echo $this->registration->telephone2; ?>" size="20"
			maxlength="20" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('presentation')) || (!empty($this->registration->presentation))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'ABSTRACT_QUESTION_LABEL' ); ?><?php if ( $this->menu_params->get( 'presentation')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['choice_presentation']; ?></td>
	</tr>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'ABSTRACT_YES_LABEL' ); ?><?php if ( $this->menu_params->get( 'presentation')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['paper_type']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('cost')) || (!empty($this->registration->cost))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'TOTAL PRICE_LABEL' ); ?><?php if ( $this->menu_params->get( 'cost')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('cost')=='2') echo "class='required validate-numeric'"; ?>
			type="text" id="cost" name="cost" readonly
			value="<?php echo $this->registration->cost; ?>" size="20"
			maxlength="20" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('accounting')) || (!empty($this->registration->invoice_institution))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'ACCOUNTING_LABEL' ); ?><?php if ( $this->menu_params->get( 'accounting')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>

		<td><?php echo $this->lists['choice_accounting']; ?></td>
	</tr>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_INSTITUTION_LABEL' ); ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('accounting')=='2') echo "class='required'"; ?>
			type="text" name="invoice_institution"
			value="<?php echo $this->registration->invoice_institution; ?>"
			size="55" maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('accounting_cif')) || (!empty($this->registration->invoice_cif))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_CIF_LABEL' ); ?><?php if ( $this->menu_params->get( 'accounting_cif')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('accounting_cif')=='2') echo "class='required'"; ?>
			type="text" name="invoice_cif"
			value="<?php echo $this->registration->invoice_cif; ?>" size="20"
			maxlength="100" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('accounting')) || (!empty($this->registration->invoice_address))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_ADDRESS_LABEL' ); ?>:</td>
		<td><input
		<?php if ( $this->menu_params->get('accounting')=='2') echo "class='required'"; ?>
			type="text" name="invoice_address"
			value="<?php echo $this->registration->invoice_address; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_CITY_LABEL' ); ?>:</td>
		<td><input
		<?php if ( $this->menu_params->get('accounting')=='2') echo "class='required'"; ?>
			type="text" name="invoice_city"
			value="<?php echo $this->registration->invoice_city; ?>" size="55"
			maxlength="100" /></td>
	</tr>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_POSTALCODE_LABEL' ); ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('accounting')=='2') echo "class='required'"; ?>
			type="text" name="invoice_zip"
			value="<?php echo $this->registration->invoice_zip; ?>" size="10"
			maxlength="10" /></td>
	</tr>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'INVOICE_COUNTRY_LABEL' ); ?>:</td>
		<td><?php echo $this->lists['invoice_countries']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('payment_method')) || (!empty($this->registration->payment_type))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'PAYMENT_METHOD_LABEL' ); ?><?php if ( $this->menu_params->get( 'payment_method')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['payment_type']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('extrafield_1')) || (!empty($this->registration->extrafield_1))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_1' ); ?><?php if ( $this->menu_params->get( 'extrafield_1')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('extrafield_1')=='2') echo "class='required'"; ?>
			type="text" name="extrafield_1"
			value="<?php echo $this->registration->extrafield_1; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('extrafield_2')) || (!empty($this->registration->extrafield_2))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_2' ); ?><?php if ( $this->menu_params->get( 'extrafield_2')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('extrafield_2')=='2') echo "class='required'"; ?>
			type="text" name="extrafield_2"
			value="<?php echo $this->registration->extrafield_2; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('extrafield_3')) || (!empty($this->registration->extrafield_3))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_3' ); ?><?php if ( $this->menu_params->get( 'extrafield_3')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><input
		<?php if ( $this->menu_params->get('extrafield_3')=='2') echo "class='required'"; ?>
			type="text" name="extrafield_3"
			value="<?php echo $this->registration->extrafield_3; ?>" size="55"
			maxlength="250" /></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('extrafield_bool_1')) || (!empty($this->registration->extrafield_bool_1))) : ?>
	<tr class='sectiontableentry1'>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_BOOL_1' ); ?><?php if ( $this->menu_params->get( 'extrafield_bool_1')=='2') echo "<span style='color: red;'>*</span>"; ?>:
		</td>
		<td><?php echo $this->lists['extrafield_bool_1']; ?></td>
	</tr>
	<?php endif; ?>

	<?php if ($this->editing_registration) : ?>
	<tr bgcolor="Silver">
		<td valign="top"><?php echo JText::_( 'PAID_STATUS_LABEL' ); ?>:</td>
		<td><?php echo $this->lists['choice_paid']; ?></td>
	</tr>
	<?php endif; ?>

	<?php /*if ($this->editing_registration) : ?>
	<!--tr bgcolor="Silver">
	<td valign="top">
	<?php echo JText::_( 'INVOICE_NUMBER_LABEL' ); ?>:
	</td>
	<td>
	<input type="text" name="invoice" value="<?php echo $this->registration->invoice; ?>" size="50" maxlength="50" />
	</td>
	</tr>
	<?php endif; ?>

	<?php if ($this->editing_registration) : ?>
	<tr bgcolor="Silver">
	<td valign="top">
	<?php echo JText::_( 'INVOICE_DATE' ); ?>:
	</td>
	<td>
	<?php JHTML::_('behavior.calendar'); ?>
	<input type="text" name="invoice_date" id="invoice_date" value="<?php echo $this->registration->invoice_date; ?>" size="10" maxlength="10"/>
	<img class="calendar" src="templates/system/images/calendar.png" alt="calendar" onclick="return 	showCalendar('invoice_date', '%Y-%m-%d');" />
	</td>
	</tr>
	<?php endif; ?>

	<?php if ($this->editing_registration) : ?>
	<tr bgcolor="Silver">
	<td valign="top">
	<?php echo JText::_( 'INVOICE_CLIENT_CODE' ); ?>:
	</td>
	<td>
	<input type="text" name="invoice_client_code" value="<?php echo $this->registration->invoice_client_code; ?>" size="50" maxlength="50" />
	</td>
	</tr>
	<?php endif; ?>

	<?php if ($this->editing_registration) : ?>
	<tr bgcolor="Silver">
	<td valign="top">
	<?php echo JText::_( 'INVOICE_PAYMENT_REFERENCE' ); ?>:
	</td>
	<td>
	<input type="text" name="invoice_payment_reference" value="<?php echo $this->registration->invoice_payment_reference; ?>" size="50" maxlength="50" />
	</td>
	</tr-->
	<?php endif; */?>

</table>

<button class="button validate" type="submit"><?php echo JText::_('Save') ?>
</button>

	<?php if ($this->registration->id) : ?> <input type="hidden" name="id"
	value="<?php echo $this->registration->id; ?>" /> <?php endif; ?> <input
	type="hidden" name="congress_id"
	value="<?php echo $this->registration->congress_id; ?>" /> <input
	type="hidden" name="option" value="com_register" /> <input
	type="hidden" name="view" value="registration" /> <input type="hidden"
	name="task" value="save_registration" /> <input type="hidden"
	name="editing_registration"
	value="<?php echo $this->editing_registration; ?>" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>

<br>
<hr>
<br>
	<?php echo JText::_( 'COMPULSORY_FIELDS' ); ?>
<br>

	<?php if ($this->editing_registration) : ?>
<br>
<hr>
<br>
<a
	href='<?php echo $_SERVER['PHP_SELF']; ?>?option=com_register&view=registrations&id=<?php echo $this->registration->congress_id; ?>'>
<button class="button">Back to List</button>
</a>
<?php endif; ?>