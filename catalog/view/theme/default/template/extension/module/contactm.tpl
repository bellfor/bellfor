<div id="module-contactm" class="wrap-form">
   <div class="form-container">
      <div id="wrap-contactm" class="panel panel-default contactm">
         <div class="panel-heading"><i class="fa fa-envelope-o"></i>  <?php echo $heading_title; ?></div>
         <div class="panel-body">
            <form class="form-horizontal" id="form-contactm">
               <fieldset>
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
                     <div class="col-sm-10">
                        <input type="text" name="name" value="" id="input-name" class="form-control" />
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
                     <div class="col-sm-10">
                        <input type="text" name="email" value="" id="input-email" class="form-control" />
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                     <div class="col-sm-10">
                        <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"></textarea>
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class="col-sm-2 control-label" for="input-captcha"></label>
                     <div class="col-sm-10">
                        <input name="captcha" placeholder="<?php echo $entry_captcha; ?>" id="input-captcha" class="form-control" type="text"/>
                        <img src="index.php?route=extension/captcha/basic_captcha/captcha" alt="captcha"/>
                     </div>
                  </div>
               </fieldset>
               <div class="buttons">
                  <div class="pull-right">
                     <button class="btn btn-lg btn-primary submit" id="SignupWbprgbtn" data-loading-text="<?php echo $button_wait; ?>" type="submit"><?php echo $button_submit; ?>
                     </button>
                     <div class="clearfix"></div>
                  </div>
               </div>
               <div class="clearfix"></div>
            </form>
         </div>
      </div>
   </div>
</div>

<style type="text/css"><!--
#module-contactm {
    background-color: #333333;
    padding-top: 50px;
    padding-bottom: 30px;
	margin-top: 0px;
}

#module-contactm .form-container {
    max-width: 1100px;
    margin-left: auto;
    margin-right: auto;
}

#module-contactm textarea {
    max-height: 111px;
}

--></style>

<script type="text/javascript"><!--

$('#SignupWbprgbtn').on('click', function(evt) {

	evt.preventDefault();

	var $btn = $(this).button('loading');
	$.ajax({
		url: 'index.php?route=extension/module/contactm/send',
		type: 'post',
		dataType: 'json',
		data: $("#form-contactm").serialize(),
		beforeSend: function() {},
		complete: function() {$btn.button('reset');},
		success: function(json) {
			$btn.button('reset');
            console.log('form sent: ' + JSON.stringify(json));
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#wrap-contactm .buttons').before('<div class="alert alert-danger col-sm-offset-2 col-sm-10  text-center"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#wrap-contactm .buttons').before('<div class="alert alert-success col-sm-offset-2 col-sm-10  text-center"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#input-enquiry,#input-captcha').val('');

			}
		},
		error: function (request, error) {
		$btn.button('reset');
		$('.alert-success, .alert-danger').remove();
        //alert("AJAX Call Error: " + error);
		$('#wrap-contactm .buttons').before('<div class="alert alert-danger col-sm-offset-2 col-sm-10  text-center"><i class="fa fa-exclamation-circle"></i> AJAX Call Error</div>');
        }
	});
});

//--></script>