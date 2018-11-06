<div id="umailchimp_form_<?php echo $module_id; ?>" class="white-popup-block mfp-hide" style="width: 400px; margin: 0 auto;">
<div class="panel panel-default">
<div class="panel-heading"><?php echo $form_title[$language_id]; ?><a class="popup-modal-dismiss" href="javascript:;" style="float: right; font-weight: bold; font-size: 150%;">X</a></div>
<div class="panel-body" style="text-align: left;">
<?php if($form_top[$language_id]!=''){ ?>
<p style="font-weight: bold;"><?php echo $form_top[$language_id]; ?></p>
<?php } ?>
<form class="subscribe_form">
<?php foreach($fields as $field){ ?>
<?php if($field['type_field']==2){ ?>
<input type="hidden" name="<?php echo $field['merge_field']; ?>" value="<?php if($field['field']=='store'){ ?><?php echo $store; ?><?php } ?>">
<?php }else{ ?>
<div class="form-group<?php if($field['type_field']==1){ ?> required<?php } ?>">
<label class="control-label" for="input-<?php echo $field['merge_field']; ?>"><?php echo $field[$language_id]['name']; ?></label>
<input type="text" name="<?php echo $field['merge_field']; ?>" value="" id="input-<?php echo $field['merge_field']; ?>" class="form-control<?php if($field['type_field']==1){ ?> required<?php } ?>">
</div>
<?php } ?>
<?php } ?>
<button type="button" class="btn btn-primary btn-lg btn-block" data-loading-text="<?php echo $form_button_loading[$language_id]; ?>" onclick="SendUmailChimpFormPopup('<?php echo $module_id; ?>', $(this).parent('form'));"><?php echo $form_button[$language_id]; ?></button>
</form>
</div>
</div>
</div>
<script>
$(function () {
	$('.popup-modal').magnificPopup({
		type: 'inline',
		preloader: false,
		focus: '#username',
		modal: true
	});
	$(document).on('click', '.popup-modal-dismiss', function (e) {
		e.preventDefault();
		$.magnificPopup.close();
	});
});
</script>