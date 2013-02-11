<?php defined('_JEXEC') or die('Restricted access'); ?>

<br>

<?php if ($this->registration->payment_type_id =='1') { //Transfer ?>
<?php echo $this->congress->summary_transfer_text; ?>
<?php } else if ($this->registration->payment_type_id =='2') { //Credit Card ?>
<?php echo $this->congress->credit_card_summary_text; ?>
<?php } else  { //Alternative ?>
<?php echo $this->congress->summary_alt_text; ?>
<?php } ?>

<br>
<b>
<h2>
<center><?php echo JText::_( 'SUMMARY' ); ?></center>
</h2>
</b>

<br>
<table style="text-align: left; width: 100%;" border="1" cellpadding="2"
	cellspacing="1">
	<tr class='sectiontableentry1'>
		<td colspan='2'><?php if ( $this->params->def( 'show_page_title', 1 ) ) : ?>
		<div
			class="componentheading<?php echo $this->params->get( 'pageclass_sfx' ); ?>">
			<?php echo $this->escape($this->params->get('page_title')); ?></div>
			<?php endif; ?></td>
	</tr>


	<?php if ($this->registration->payment_type_id !='') { //Transfer or other, not credit card ?>
	<tr>
		<td colspan="2"><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="Silver">

		<table width="100%" border=0>
			<TR>
				<td align="left" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='id_registration'
					value='<?php echo $this->registration->id; ?>'> <INPUT
					type='submit' value='Modify Registration Data'></form>
				</td>
				<td align="right" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='task' value='save_confirmation'> <INPUT
					type='hidden' name='id'
					value='<?php echo $this->registration->id; ?>'> <input
					type="hidden" name="view" value="registration" /> <INPUT
					type='submit' value='Complete Registration'></form>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } else if ($this->registration->payment_type_id =='2') { //Credit Card ?>

	<?php

	$url_tpvv=$this->congress->tpv_url_tpvv;
	$clave=$this->congress->tpv_clave;
	$name=$this->congress->tpv_name;
	$code=$this->congress->tpv_code;
	$terminal=$this->congress->tpv_terminal;
	$order = date('ymd').'ID'.$this->registration->id;
	$amount = $this->registration->cost * 100;
	$currency=$this->congress->tpv_currency;
	$transactionType=$this->congress->tpv_transaction_type;
	$urlMerchant=$this->congress->tpv_url_merchant;
	$urlMerchantOk=$this->congress->tpv_url_merchant_ok.$id_registration;
	$language = $this->congress->tpv_language;
	$producto=$this->congress->tpv_producto;

	?>

	<tr>
		<td colspan="2"><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" bgcolor="Silver">

		<table width="100%" border=0>
			<TR>
				<td align="left" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='id_registration'
					value='<?php echo $this->registration->id; ?>'> <INPUT
					type='submit' value='Modify Registration Data'></form>
				</td>
				<td align="right" bgcolor="Silver">
				<form name=compra action=<?php echo $url_tpvv; ?> method=post
					target=tpv><input type=hidden name=Ds_Merchant_Amount
					value='<?php echo $amount; ?>'> <input type=hidden
					name=Ds_Merchant_Currency value='<?php echo $currency; ?>'> <input
					type=hidden name=Ds_Merchant_Order value='<?php echo $order; ?>'> <input
					type=hidden name=Ds_Merchant_MerchantCode
					value='<?php echo $code; ?>'> <input type=hidden
					name=Ds_Merchant_Terminal value='<?php echo $terminal; ?>'> <input
					type=hidden name=Ds_Merchant_TransactionType
					value='<?php echo $transactionType; ?>'> <input type=hidden
					name=Ds_Merchant_MerchantURL value='<?php echo $urlMerchant; ?>'> <input
					type=hidden name=Ds_Merchant_UrlOK
					value='<?php echo $urlMerchantOk; ?>'> <input type=hidden
					name=Ds_Merchant_ConsumerLanguage value='<?php echo $language; ?>'>

					<?php
					// Compute hash to sign form data
					// $signature=sha1_hex($amount,$order,$code,$currency,$clave);
					$message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
					//echo $message;
					$signature = strtoupper(sha1($message));
					?> <input type=hidden name=Ds_Merchant_MerchantSignature
					value='<?php echo $signature?>'> <INPUT type='hidden' name='id'
					value='<?php echo $id_registration; ?>'> <input type="hidden"
					name="view" value="registration" /> <INPUT type='submit'
					value='Complete Registration'></form>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } ?>


	<?php
	if (( $this->menu_params->get( 'academic_title')) || (!empty($this->registration->title))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'ACADEMIC_TITLE_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->title; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('firstname')) || (!empty($this->registration->firstname))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'FIRST_NAME_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->firstname; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('lastname')) || (!empty($this->registration->lastname))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'LAST_NAME_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->lastname; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('gender')) || (!empty($this->registration->gender))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'GENDER_LABEL' ); ?>:</td>
		<td><?php echo ($this->registration->gender == '1')?'Male':'Female'; ?>
		</td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('institution')) || (!empty($this->registration->institution))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'INSTITUTION_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->institution; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('registration_type')) || (!empty($this->registration->registration_type))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'REGISTRATION_FEE_LABEL' ); ?>:
		</td>
		<td><?php echo $this->registration->registration_type; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('membership')) || (!empty($this->registration->member))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'MEMBERSHIP_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->member; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('address')) || (!empty($this->registration->address))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'ADDRESS_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->address; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('city')) || (!empty($this->registration->city))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'CITY_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->city; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('postal_code')) || (!empty($this->registration->postalcode))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'POSTALCODE_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->postalcode; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('country')) || (!empty($this->registration->printable_name))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'COUNTRY_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->printable_name; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('email')) || (!empty($this->registration->email))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'EMAIL_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->email; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('daytime_phone')) || (!empty($this->registration->telephone1))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'PHONE1_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->telephone1; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('alternative_phone')) || (!empty($this->registration->telephone2))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'PHONE2_LABEL' ); ?>:</td>
		<td><?php echo $this->registration->telephone2; ?></td>
	</tr>
	<?php endif; ?>

	<?php if ($this->registration->presentation == 'yes') :
	if ($this->registration->paper_type == 'oral') { ?>
	<tr>
		<td colspan="2">I intend to present an abstract<br>
		Prefered form : Oral</td>
	</tr>
	<?php } else { ?>
	<tr>
		<td colspan="2">I intend to present an abstract<br>
		Prefered form : Poster</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2"><span class="highlight">Dead Line for receiving
		Abstracts: 20th July 2009 </span></td>
	</tr>
	<?php endif; ?>

	<tr>
		<td colspan="2"><br>
		</td>
	</tr>

	<?php if (( $this->menu_params->get('extrafield_1')) || (!empty($this->registration->extrafield_1))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_1' ); ?>:</td>
		<td><?php echo $this->registration->extrafield_1; ?></td>
	</tr>
	<?php endif; ?>
	<?php if (( $this->menu_params->get('extrafield_2')) || (!empty($this->registration->extrafield_2))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_2' ); ?>:</td>
		<td><?php echo $this->registration->extrafield_2; ?></td>
	</tr>
	<?php endif; ?>
	<?php if (( $this->menu_params->get('extrafield_3')) || (!empty($this->registration->extrafield_3))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_3' ); ?>:</td>
		<td><?php echo $this->registration->extrafield_3; ?></td>
	</tr>
	<?php endif; ?>
	<?php if (( $this->menu_params->get('extrafield_bool_1')) || (!empty($this->registration->extrafield_bool_1))) : ?>
	<tr>
		<td valign="top"><?php echo JText::_( 'EXTRAFIELD_BOOL_1' ); ?>:</td>
		<td><?php echo ($this->registration->extrafield_bool_1)?JText::_( 'EXTRAFIELD_BOOL_1_YES' ):JText::_( 'EXTRAFIELD_BOOL_1_NO' ); ?>
		</td>
	</tr>
	<?php endif; ?>

	<tr>
		<td colspan="2"><br>
		</td>
	</tr>

	<?php if (( $this->menu_params->get('accounting') =='2' ) || (!empty($this->registration->invoice_institution))) : ?>
	<tr>
		<td>INVOICE NAME :</td>
		<td><?php echo $this->registration->invoice_institution; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('accounting_cif') =='2' ) || (!empty($this->registration->invoice_cif))) : ?>
	<tr>
		<td>INVOICE CIF :</td>
		<td><?php echo $this->registration->invoice_cif; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('accounting') =='2' )  || (!empty($this->registration->invoice_address))): ?>
	<tr>
		<td>INVOICE ADDRESS</td>
		<td><?php echo $this->registration->invoice_address; ?></td>
	</tr>

	<tr>
		<td>INVOICE CITY</td>
		<td><?php echo $this->registration->invoice_city; ?></td>
	</tr>

	<tr>
		<td>INVOICE ZIP CODE</td>
		<td><?php echo $this->registration->invoice_zip; ?></td>
	</tr>

	<tr>
		<td>INVOICE COUNTRY</td>
		<td><?php echo $this->registration->invoice_country; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('payment_method'))  || (!empty($this->registration->payment_type))): ?>
	<tr>
		<td>Method of Payment</td>
		<td><?php echo $this->registration->payment_type; ?></td>
	</tr>
	<?php endif; ?>

	<?php if (( $this->menu_params->get('cost')) || (!empty($this->registration->cost))) : ?>
	<tr>
		<td>TOTAL</td>
		<td><?php echo $this->registration->cost; ?></td>
	</tr>
	<?php endif; ?>

	<?php if ($this->registration->payment_type_id !='') { //Transfer or other, not credit card ?>
	<tr>
		<td colspan="2"><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" bgcolor="Silver">

		<table width="100%" border=0>
			<TR>
				<td align="left" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='id_registration'
					value='<?php echo $this->registration->id; ?>'> <INPUT
					type='submit' value='Modify Registration Data'></form>
				</td>
				<td align="right" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='task' value='save_confirmation'> <INPUT
					type='hidden' name='id'
					value='<?php echo $this->registration->id; ?>'> <input
					type="hidden" name="view" value="registration" /> <INPUT
					type='submit' value='Complete Registration'></form>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } else if ($this->registration->payment_type_id =='2') { //Credit Card ?>

	<?php

	$url_tpvv='https://sis.sermepa.es/sis/realizarPago';
	$clave='271BM9N2RM9N31UP';
	$name='WOE';
	$code='297182602';
	$terminal='1';
	$order = date('ymd').'ID'.$this->registration->id;
	$amount = $this->registration->cost * 100;
	$currency='978';
	$transactionType='0';
	$urlMerchant='http://www.icmab.es/registration/index.php?option=com_register&task=end_message';
	$urlMerchantOk='http://www.icmab.es/registr.html?task=save_second_step_bis&paid=1&id_registration='.$id_registration;
	$language = '002';
	$producto='Registro Workshop Oxide Electronic';

	?>

	<tr>
		<td colspan="2"><br>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="right" bgcolor="Silver">

		<table width="100%" border=0>
			<TR>
				<td align="left" bgcolor="Silver">
				<form action='<?php echo $this->action; ?>' method='post'><INPUT
					type='hidden' name='id_registration'
					value='<?php echo $this->registration->id; ?>'> <INPUT
					type='submit' value='Modify Registration Data'></form>
				</td>
				<td align="right" bgcolor="Silver">
				<form name=compra action=<?php echo $url_tpvv; ?> method=post
					target=tpv><input type=hidden name=Ds_Merchant_Amount
					value='<?php echo $amount; ?>'> <input type=hidden
					name=Ds_Merchant_Currency value='<?php echo $currency; ?>'> <input
					type=hidden name=Ds_Merchant_Order value='<?php echo $order; ?>'> <input
					type=hidden name=Ds_Merchant_MerchantCode
					value='<?php echo $code; ?>'> <input type=hidden
					name=Ds_Merchant_Terminal value='<?php echo $terminal; ?>'> <input
					type=hidden name=Ds_Merchant_TransactionType
					value='<?php echo $transactionType; ?>'> <input type=hidden
					name=Ds_Merchant_MerchantURL value='<?php echo $urlMerchant; ?>'> <input
					type=hidden name=Ds_Merchant_UrlOK
					value='<?php echo $urlMerchantOk; ?>'> <input type=hidden
					name=Ds_Merchant_ConsumerLanguage value='<?php echo $language; ?>'>

					<?php
					// Compute hash to sign form data
					// $signature=sha1_hex($amount,$order,$code,$currency,$clave);
					$message = $amount.$order.$code.$currency.$transactionType.$urlMerchant.$clave;
					//echo $message;
					$signature = strtoupper(sha1($message));
					?> <input type=hidden name=Ds_Merchant_MerchantSignature
					value='<?php echo $signature?>'> <INPUT type='hidden' name='id'
					value='<?php echo $id_registration; ?>'> <input type="hidden"
					name="view" value="registration" /> <INPUT type='submit'
					value='Complete Registration'></form>
				</td>
			</tr>
		</table>
		</td>
	</tr>
	<?php } ?>

</table>
