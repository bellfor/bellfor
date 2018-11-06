<h2><?php echo $text_header; ?></h2>
<form id="payment" class="form-horizontal">
<img src="https://cdn.klarna.com/public/images/NL/badges/v1/invoice/NL_invoice_badge_std_blue.png?height=50&eid=<?php echo $text_klarnaid; ?>" alt="Klarna Factuur" title="Klarna Factuur" style="vertical-align: middle;" />
  <fieldset>
    <legend><?php echo $text_description; ?></legend>
	<div class="form-group required">
	  <label class="col-sm-3 control-label" for="gender"><?php echo $text_gender; ?></label>
		<div class="col-sm-9">
		<select name="sisowgender" id="gender" class="form-control">
		  <option value=""><?php echo $text_select_gender; ?></option>
		  <option value="M"><?php echo $text_sir; ?></option>
		  <option value="F"><?php echo $text_madam; ?></option>
	    </select>
		</div>
	</div>
	<div class="form-group required">
	  <label class="col-sm-3 control-label" for="sisowphone"><?php echo $text_tphone; ?></label>
		<div class="col-sm-9">
		  <input type="text" id="sisowphone" name="sisowphone" class="form-control" maxlength="12" value="<?php echo $text_phone; ?>" />
		</div>
	</div>
    <div class="form-group required">
	  <label class="col-sm-3 control-label" for="sisowday"><?php echo $text_birthday; ?></label>
		<div class="col-sm-9" style="padding: 0px;">
			<div class="col-sm-4">
				<select id="sisowday" name="sisowday" class="form-control">
          			<option value=""><?php echo $text_select_day; ?></option>
          			<?php foreach ($days as $day) { ?>
          			<option value="<?php echo $day['value']; ?>"><?php echo $day['text']; ?></option>
          			<?php } ?>
				</select>
			</div>
			<div class="col-sm-4">
				<select id="sisowmonth" name="sisowmonth" class="form-control">
          			<option value=""><?php echo $text_select_month; ?></option>
          			<?php foreach ($months as $month) { ?>
          			<option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          			<?php } ?>
				</select>
			</div>
			<div class="col-sm-4">
				<select id="sisowyear" name="sisowyear" class="form-control">
          			<option value=""><?php echo $text_select_year; ?></option>
          			<?php foreach ($year_expire as $year) { ?>
          			<option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          			<?php } ?>
				</select>
			</div>
		</div>
	</div>
  <fieldset>
</form>
<div><?php if ($text_fee) { ?><?php echo $text_paymentfee; ?><?php } ?></div>
<div><a href="<?php echo $text_terms_url; ?><?php echo $text_klarnaid; ?>&charge=<?php echo $text_fee; ?>" onclick="window.open(this.href,'sisowklarna','resizable=no,status=no,location=no,toolbar=no,menubar=no,fullscreen=no,scrollbars=yes,dependent=no,width=660,height=500'); return false;"><?php echo $text_klarna_terms; ?></a></div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'post',
		url: 'index.php?route=payment/sisowklarna/redirectbank',
		data: $('#payment :input'),
		dataType: 'json',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			$('#button-confirm').button('reset');
		},
		success: function(json) {
			if (json['error']) {
				alert(json['error']);
			}

			if (json['redirect']) {
				location = json['redirect'];
			}
		}
	});
});
//--></script>