<?php defined('_JEXEC') or die('Restricted access'); ?>

<?php JHTML::_('behavior.tooltip'); ?>
<?php
jimport( 'joomla.html.pane' ); ?>

<?php
// Set toolbar items for the page
$edit = JRequest::getVar('edit', true);
$text = !$edit ? JText::_( 'New' ) : JText::_( 'Edit' );
JToolBarHelper::title(   JText::_( 'Congress' ).': <small><small>[ ' . $text.' ]</small></small>' );
JToolBarHelper::apply();
JToolBarHelper::save();
if (!$edit)  {
	JToolBarHelper::cancel();
} else {
	// for existing items the button is renamed `close`
	JToolBarHelper::cancel( 'cancel', 'Close' );
}
//JToolBarHelper::help( 'screen.weblink.edit' );
?>

<script language="javascript" type="text/javascript">
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}

		// do field validation
		if (form.long_name.value == ""){
			alert( "<?php echo JText::_( 'Congress item must have a description', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>
<style type="text/css">
table.paramlist td.paramlist_key {
	width: 92px;
	text-align: left;
	height: 30px;
}
</style>

<form action="index.php" method="post" name="adminForm"
	id="adminForm"><?php $pane =& JPane::getInstance('Sliders',array('useCookie' => 1));
	echo $pane->startPane('myPane');
	{
		echo $pane->startPanel('Details', 'panel1'); ?>
<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>
<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><label for="title"> <?php echo JText::_( 'Short name' ); ?>:
		</label></td>
		<td><input class="text_area" type="text" name="short_name"
			id="short_name" size="50" maxlength="50"
			value="<?php echo $this->congress->short_name;?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="title"> <?php echo JText::_( 'Long Name' ); ?>:
		</label></td>
		<td><input class="text_area" type="text" name="long_name"
			id="long_name" size="50" maxlength="255"
			value="<?php echo $this->congress->long_name;?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="title"> <?php echo JText::_( 'Description' ); ?>:
		</label></td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('description', $this->congress->description, '550', '200', '60', '20', false);
		?> <!--textarea class="text_area" cols="80" rows="9" name="description" id="description"><?php //echo $this->congress->description; ?></textarea-->
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="title"> <?php echo JText::_( 'Email' ); ?>:
		</label></td>
		<td><input class="text_area" type="text" name="email" id="email"
			size="50" maxlength="50" value="<?php echo $this->congress->email;?>" />
		</td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Start date' ); ?>:
		</td>
		<td><?php echo JHTML::_( 'calendar', $this->congress->start_date, 'start_date', 'start_date', '%Y-%m-%d', array('class'=>'inputbox', 'type'=>'text', 'size'=>'10', 'maxlength'=>'10') ); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'End date' ); ?>:
		</td>
		<td><?php echo JHTML::_( 'calendar', $this->congress->end_date, 'end_date', 'end_date', '%Y-%m-%d', array('class'=>'inputbox', 'type'=>'text', 'size'=>'10', 'maxlength'=>'10') ); ?>
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><label for="title"> <?php echo JText::_( 'Address' ); ?>:
		</label></td>
		<td><input class="text_area" type="text" name="address" id="address"
			size="50" maxlength="100"
			value="<?php echo $this->congress->address;?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'City' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="city" id="city"
			size="30" maxlength="255" value="<?php echo $this->congress->city;?>" />
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Country' ); ?>:
		</td>
		<td><?php echo $this->lists['countries']; ?></td>
	</tr>
	<tr>
		<td valign="top" class="key"><label for="imageurl"> <?php echo JText::_( 'Picture Selector' ); ?>:
		</label></td>
		<td><?php echo $this->lists['imageurl']; ?></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Registration', 'panel2'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Registration' ); ?></legend>

<table class="admintable">
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Date early registration' ); ?>:
		</td>
		<td><?php echo JHTML::_( 'calendar', $this->congress->early_registration_date, 'early_registration_date', 'early_registration_date', '%Y-%m-%d', array('class'=>'inputbox', 'type'=>'text', 'size'=>'10', 'maxlength'=>'10') ); ?>
		</td>
		<td><i>NOTE: This day will NOT BE early registration, it is not
		included.</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Date limit' ); ?>:
		</td>
		<td><?php echo JHTML::_( 'calendar', $this->congress->limit_date, 'limit_date', 'limit_date', '%Y-%m-%d', array('class'=>'inputbox', 'type'=>'text', 'size'=>'10', 'maxlength'=>'10') ); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Registration text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('registration_text', $this->congress->registration_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:Due to unexpected issues related to the credit card payment,
		we extend the reduced price inscription one additional week. The new
		deadline for early registration is the 30th July. Apology for the
		incovenience.</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Javascript to Calculate price' ); ?>:
		</td>
		<td><textarea class="text_area" name="cost_javascript"
			id="cost_javascript" cols="80" rows="30"><?php echo $this->congress->cost_javascript;?></textarea>
		</td>
		<td><i>Ex: function calculate_price(period) {<br>
		var registration_type =
		document.registrationForm.registration_type_id.value;<br>
		var cost = document.registrationForm.cost;<br>
		var price;<br>
		<br>
		if ((registration_type == "0") || (registration_type == "undefined")){<br>
		price = '---';<br>
		}<br>
		<br>
		switch(period) {<br>
		case "before":<br>
		switch(registration_type) {<br>
		case "1":<br>
		price = 5;<br>
		break;<br>
		case "2":<br>
		price = 20;<br>
		break;<br>
		case "3":<br>
		price = 30;<br>
		break;<br>
		}<br>
		break;<br>
		case "after":<br>
		switch(registration_type) {<br>
		case "1":<br>
		price = 10;<br>
		break;<br>
		case "2":<br>
		price = 25;<br>
		break;<br>
		case "3":<br>
		price = 35;<br>
		break;<br>
		}<br>
		break;<br>
		}<br>
		<br>
		cost.value = price;<br>
		return true;<br>
		}</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Registration Limit' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="registration_limit"
			id="registration_limit" size="50" maxlength="100"
			value="<?php echo $this->congress->registration_limit;?>" /></td>
		<td><i>Ex: Num of places, 0 means no limit.</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Registration Limit Reach' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('registration_limit_text', $this->congress->registration_limit_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:The maximum number of papers has been reached,<br>
		please contact mail@mail.com in order to be in the waiting list.</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Papers Limit' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="papers_limit"
			id="papers_limit" size="50" maxlength="100"
			value="<?php echo $this->congress->papers_limit;?>" /></td>
		<td><i>Ex: Num of accepted papers, 0 means no limit.</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Papers Limit Reach' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('papers_limit_text', $this->congress->papers_limit_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:The maximum number of papers has been reached, please
		contact mail@mail.com in order to be in the waiting list.</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Bank Transfer Configuration', 'panel3'); ?>


<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Bank Transfer Configuration' ); ?></legend>

<table class="admintable">
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Summary transfer text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('summary_transfer_text', $this->congress->summary_transfer_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:To perform your registration, it is necessary to complete
		the bank transfer to: FUNDACIÓ EMPRESA I CIÈNCIA<br>
		<br>
		Bank account : "La Caixa" 2100 0424 39 0200145951 I<br>
		<br>
		BAN : *ES02 2100 0424 3902 00145951*<br>
		<br>
		SWIFT : *CAIXESBBXXX<br>
		<br>
		and send a fax to: Mercè Moreno Humet 34-93 581 10 56<br>
		<br>
		Contact person: Mercè Moreno Humet,<br>
		<br>
		Tel. 93 581 25 21 (merce.moreno@uab.cat)<br>
		</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Registration complete transfer text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('registration_complete_transfer_text', $this->congress->registration_complete_transfer_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:Registration Completed !!</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Mail transfer subject' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="mail_transfer_subject"
			id="mail_transfer_subject" size="50" maxlength="100"
			value="<?php echo $this->congress->mail_transfer_subject;?>" /></td>
		<td><i>Ex:CCA 2009 Registration</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Mail transfer body' ); ?>:
		</td>
		<td><textarea class="text_area" cols="80" rows="9"
			name="mail_transfer_body" id="mail_transfer_body"><?php echo $this->congress->mail_transfer_body; ?></textarea>
		</td>
		<td><i>Ex:To complete your registration, it is necessary to fulfill
		the bank transfer to the congress bank account number and send a copy
		to the congress secretariat by e-mail (merce.moreno@uab.cat) or fax
		(+34 93 581 10 56), otherwise the registration will fail.<br>
		FUNDACIO EMPRESA I CIENCIA<br>
		Bank account : "La Caixa" 2100 0424 39 0200145951<br>
		IBAN : *ES02 2100 0424 3902 00145951*<br>
		SWIFT : *CAIXESBBXXX<br>
		<br>
		Merce Moreno Humet<br>
		E-mail : merce.moreno@uab.cat<br>
		Tel: +34 93 581 25 21<br>
		Fax: +34 93 581 10 56<br>
		<br>
		Otherwise, the registration and hotel booking will not be valid.
		correctly sent.<br>
		Summary<br>
		NAME : {lastname}, {firstname} (Op. Id {id})<br>
		TOTAL : {total}<br>
		INVOICE NAME : {invoice_name}<br>
		INVOICE ADDRESS : {invoice_address}<br>
		INVOICE CITY : {invoice_city}<br>
		INVOICE ZIP CODE : {invoice_zip}<br>
		INVOICE COUNTRY : {invoice_country}<br>
		Method of Payment:Credit Card</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Mail transfer additional email' ); ?>:
		</td>
		<td><input class="text_area" type="text"
			name="mail_transfer_additional_email"
			id="mail_transfer_additional_email" size="50" maxlength="255"
			value="<?php echo $this->congress->mail_transfer_additional_email;?>" />
		</td>
		<td><i>Additional mails can be used by doing:<br>
		amoreno@icmab.es;amoreno@matgas.com</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Credit Card Configuration', 'panel4'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Credit Card Configuration' ); ?></legend>

<table class="admintable">
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Credit card summary text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('credit_card_summary_text', $this->congress->credit_card_summary_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:Click on Complete Registration to proceed to the payment.<br>
		<br>
		ADVICE: The transaction happens in the following way:<br>
		<br>
		1.- When you confirm the Registration, a window appears asking you the
		credit card number, expiration date and security code (the last 3
		numbers on back of the card). You should fill correctly all these
		fields.<br>
		<br>
		2.- Once you click on continue (if the data is ok), another window
		will appear to confirm the purchase. Click on confirm.<br>
		<br>
		3.- Then a new window will appear (owned by the bank you have your
		credit card associated). This window will ask you for some kind of
		confirmation from your side. Once you confirm via this number (or
		another method relative to the bank), the payment is well done and you
		see on screen a confirmation message.<br>
		<br>
		<br>
		[NOTE 1: For instance, In Spain, such confirmation can be contained in
		a clues card. In this card, there is a list of numbers with a clue
		associated. In the page we talk about, the bank generates a random
		number, for instance the 3, thus you have to look at the card to find
		the clue associated to the number 3, for example 5686. Other banks may
		have different protocols. In order to complete correctly the
		transaction, you should know them.]<br>
		<br>
		[NOTE 2: In case of difficulties please try using Microsoft Explorer
		browser.]<br>
		<br>
		[NOTE 3: If difficulties with credit card transaction still exist,
		please contact to Mercè Moreno Humet, merce.moreno@uab.cat]<br>
		</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Credit card complete text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('credit_card_complete_text', $this->congress->credit_card_complete_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:Registration Completed !!</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Credit card mail subject' ); ?>:
		</td>
		<td><input class="text_area" type="text"
			name="credit_card_mail_subject" id="credit_card_mail_subject"
			size="50" maxlength="100"
			value="<?php echo $this->congress->credit_card_mail_subject;?>" /></td>
		<td><i>Ex:WOE 2009 Registration by Card</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Credit card mail body' ); ?>:
		</td>
		<td><textarea class="text_area" cols="80" rows="9"
			name="credit_card_mail_body" id="credit_card_mail_body"><?php echo $this->congress->credit_card_mail_body; ?></textarea>
		</td>
		<td><i>Ex: Your data have been correctly sent.<br>
		Summary<br>
		NAME : {lastname}, {firstname} (Op. Id {id})<br>
		TOTAL : {total}<br>
		INVOICE NAME : {invoice_name}<br>
		INVOICE ADDRESS : {invoice_address}<br>
		INVOICE CITY : {invoice_city}<br>
		INVOICE ZIP CODE : {invoice_zip}<br>
		INVOICE COUNTRY : {invoice_country}<br>
		Method of Payment:Credit Card</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Credit card additional email' ); ?>:
		</td>
		<td><input class="text_area" type="text"
			name="credit_card_additional_email" id="credit_card_additional_email"
			size="50" maxlength="255"
			value="<?php echo $this->congress->credit_card_additional_email;?>" />
		</td>
		<td><i>Additional mails can be used by doing:<br>
		amoreno@icmab.es;amoreno@matgas.com</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('TPV Parameters', 'panel5'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'TPV Parameters' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV URL' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_url_tpvv"
			id="tpv_url_tpvv" size="80" maxlength="120"
			value="<?php echo $this->congress->tpv_url_tpvv;?>" /></td>
		<td><i>Ex: https://sis-t.sermepa.es:25443/sis/realizarPago (Entorno
		pruebas)<br>
		https://sis.sermepa.es/sis/realizarPago (Entorno real)</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Clave' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_clave"
			id="tpv_clave" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_clave;?>" /></td>
		<td><i>Ex: 271BM9N2RM9N37UP</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Name' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_name" id="tpv_name"
			size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_name;?>" /></td>
		<td><i>Ex: WOE (not used on transaction)</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Code' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_code" id="tpv_code"
			size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_code;?>" /></td>
		<td><i>Ex: 297182602</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Terminal' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_terminal"
			id="tpv_terminal" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_terminal;?>" /></td>
		<td><i>Ex: 1</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Currency' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_currency"
			id="tpv_currency" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_currency;?>" /></td>
		<td><i>Ex: 978 (€)</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Transaction Type' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_transaction_type"
			id="tpv_transaction_type" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_transaction_type;?>" /></td>
		<td><i>Ex: 0</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV URL Merchant' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_url_merchant"
			id="tpv_url_merchant" size="80" maxlength="120"
			value="<?php echo $this->congress->tpv_url_merchant;?>" /></td>
		<td><i>Point the page when all procedure finished correctly<br>
		Ex:
		http://www.icmab.es/registration/index.php?option=com_register&task=end_message</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV URL Merchant OK' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_url_merchant_ok"
			id="tpv_url_merchant_ok" size="80" maxlength="120"
			value="<?php echo $this->congress->tpv_url_merchant_ok;?>" /></td>
		<td><i>The system request this page when all procedure finished
		correctly<br>
		Ex:
		http://www.icmab.es/registr.html?task=save_second_step_bis&paid=1&id_registration='.$id_registration</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Language' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_language"
			id="tpv_language" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_language;?>" /></td>
		<td><i>Ex: 002 (English), 001 (Spanish)</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'TPV Producto' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="tpv_producto"
			id="tpv_producto" size="50" maxlength="100"
			value="<?php echo $this->congress->tpv_producto;?>" /></td>
		<td><i>Ex: Registro Workshop Oxide Electronic</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Alternative Configuration', 'panel6'); ?>


<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Alternative Configuration' ); ?></legend>

<table class="admintable">
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Summary text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('summary_alt_text', $this->congress->summary_alt_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:To perform your registration, it is necessary to complete
		the bank transfer to: FUNDACIÓ EMPRESA I CIÈNCIA<br>
		<br>
		Bank account : "La Caixa" 2100 0424 39 0200145951 I<br>
		<br>
		BAN : *ES02 2100 0424 3902 00145951*<br>
		<br>
		SWIFT : *CAIXESBBXXX<br>
		<br>
		and send a fax to: Mercè Moreno Humet 34-93 581 10 56<br>
		<br>
		Contact person: Mercè Moreno Humet,<br>
		<br>
		Tel. 93 581 25 21 (merce.moreno@uab.cat)<br>
		</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Registration complete text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('registration_complete_alt_text', $this->congress->registration_complete_alt_text, '550', '200', '60', '20', false);
		?></td>
		<td><i>Ex:Registration Completed !!</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Mail subject' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="mail_alt_subject"
			id="mail_alt_subject" size="50" maxlength="100"
			value="<?php echo $this->congress->mail_alt_subject;?>" /></td>
		<td><i>Ex:CCA 2009 Registration</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Mail body' ); ?>:
		</td>
		<td><textarea class="text_area" cols="80" rows="9"
			name="mail_alt_body" id="mail_alt_body"><?php echo $this->congress->mail_alt_body; ?></textarea>
		</td>
		<td><i>Ex:To complete your registration, it is necessary to fulfill
		the bank transfer to the congress bank account number and send a copy
		to the congress secretariat by e-mail (merce.moreno@uab.cat) or fax
		(+34 93 581 10 56), otherwise the registration will fail.<br>
		FUNDACIO EMPRESA I CIENCIA<br>
		Bank account : "La Caixa" 2100 0424 39 0200145951<br>
		IBAN : *ES02 2100 0424 3902 00145951*<br>
		SWIFT : *CAIXESBBXXX<br>
		<br>
		Merce Moreno Humet<br>
		E-mail : merce.moreno@uab.cat<br>
		Tel: +34 93 581 25 21<br>
		Fax: +34 93 581 10 56<br>
		<br>
		Otherwise, the registration and hotel booking will not be valid.
		correctly sent.<br>
		Summary<br>
		NAME : {lastname}, {firstname} (Op. Id {id})<br>
		TOTAL : {total}<br>
		INVOICE NAME : {invoice_name}<br>
		INVOICE ADDRESS : {invoice_address}<br>
		INVOICE CITY : {invoice_city}<br>
		INVOICE ZIP CODE : {invoice_zip}<br>
		INVOICE COUNTRY : {invoice_country}<br>
		Method of Payment:Credit Card</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Mail additional email' ); ?>:
		</td>
		<td><input class="text_area" type="text"
			name="mail_alt_additional_email" id="mail_alt_additional_email"
			size="50" maxlength="255"
			value="<?php echo $this->congress->mail_alt_additional_email;?>" /></td>
		<td><i>Additional mails can be used by doing:<br>
		amoreno@icmab.es;amoreno@matgas.com</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Papers', 'panel7'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Papers' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Papers Directory' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="papers_directory"
			id="papers_directory" size="50" maxlength="100"
			value="<?php echo $this->congress->papers_directory;?>" /></td>
		<td><i>Ex: papers/woe-2009</i></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'End reception date' ); ?>:
		</td>
		<td><?php echo JHTML::_( 'calendar', $this->congress->end_reception_date, 'end_reception_date', 'end_reception_date', '%Y-%m-%d', array('class'=>'inputbox', 'type'=>'text', 'size'=>'10', 'maxlength'=>'10') ); ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'End reception message' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('end_reception_message', $this->congress->end_reception_message, '550', '200', '60', '20', false);
		?> <!--textarea class="text_area" cols="80" rows="9" name="end_reception_message" id="end_reception_message"><?php //echo $this->congress->end_reception_message; ?></textarea-->
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Paper instructions' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('paper_instructions', $this->congress->paper_instructions, '550', '200', '60', '20', false);
		?> <!--textarea class="text_area" cols="80" rows="9" name="paper_instructions" id="paper_instructions"><?php //echo $this->congress->paper_instructions; ?></textarea-->
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Paper completion text' ); ?>:
		</td>
		<td><?php $editor =& JFactory::getEditor();
		echo $editor->display('paper_completion_text', $this->congress->paper_completion_text, '550', '200', '60', '20', false);
		?> <!--textarea class="text_area" cols="80" rows="9" name="paper_completion_text" id="paper_completion_text"><?php //echo $this->congress->paper_completion_text; ?></textarea-->
		</td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Mail paper subject' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="paper_mail_subject"
			id="paper_mail_subject" size="50" maxlength="100"
			value="<?php echo $this->congress->paper_mail_subject;?>" /></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Mail paper body' ); ?>:
		</td>
		<td><textarea class="text_area" cols="80" rows="9"
			name="paper_mail_body" id="paper_mail_body"><?php echo $this->congress->paper_mail_body; ?></textarea>
		</td>
		<td><i>This mail is to confirm the reception of your paper for the ACC
		2009 congress. Title: {title} Presenting author: {presenting_author}
		Type of presentation: {paper_type} Institution: {institution} Session:
		{session}</i></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Papers additional email' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="paper_additional_email"
			id="paper_additional_email" size="50" maxlength="255"
			value="<?php echo $this->congress->paper_additional_email;?>" /></td>
		<td><i>Additional mails can be used by doing:<br>
		amoreno@icmab.es;amoreno@matgas.com</i></td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();
		echo $pane->startPanel('Latex File', 'panel8'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Latex File' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Latex Directory' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="latex_directory"
			id="latex_directory" size="50" maxlength="100"
			value="<?php echo $this->congress->latex_directory;?>" /></td>
	</tr>
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Latex E-Mail' ); ?>:
		</td>
		<td><input class="text_area" type="text" name="latex_email"
			id="latex_email" size="50" maxlength="100"
			value="<?php echo $this->congress->latex_email;?>" /></td>
	</tr>
	<tr>
		<td valign="top" align="right" class="key"><?php echo JText::_( 'Latex Template' ); ?>:
		</td>
		<td><textarea class="text_area" cols="80" rows="9"
			name="latex_template" id="latex_template"><?php echo $this->congress->latex_template; ?></textarea>
		</td>
	</tr>
</table>
</fieldset>
</div>

		<?php echo $pane->endPanel();

		if ($this->user->gid == '25') {

			echo $pane->startPanel('Debug', 'panel9'); ?>

<div class="col width-90">
<fieldset class="adminform"><legend><?php echo JText::_( 'Debug Options' ); ?></legend>

<table class="admintable">
	<tr>
		<td width="100" align="right" class="key"><?php echo JText::_( 'Debug' ); ?>:
		</td>
		<td><?php echo $this->lists['debug']; ?></td>
	</tr>
</table>
</fieldset>
</div>

			<?php echo $pane->endPanel();
		}
	}
	echo $pane->endPane(); ?> <!-- Block for parameters
<div class="col width-50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Parameters' ); ?></legend>

		<table class="admintable">
		<tr>
			<td colspan="2">
				<?php echo $this->params->render();?>
			</td>
		</tr>
		</table>
	</fieldset>
</div>
-->
<div class="clr"></div>

<input type="hidden" name="option" value="com_register" /> <input
	type="hidden" name="cid[]" value="<?php echo $this->congress->id; ?>" />
<input type="hidden" name="task" value="" /> <?php echo JHTML::_( 'form.token' ); ?>
</form>
