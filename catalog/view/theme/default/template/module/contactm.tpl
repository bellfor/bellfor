<div id="module-contactm" class="wrap-form">
   <div class="form-container">
      <div id="wrap-contactm" class="panel panel-default contactm">
         <div class="panel-heading"><i class="fa fa-envelope-o"></i>  <?php echo $heading_title; ?></div>
         <div class="panel-body">
            <form class="form-horizontal" id="form-contactm">
               <fieldset>
                  <div class="form-group required">
                     <label class="col-sm-3 control-label" for="input-name"><?php echo $entry_name; ?></label>
                     <div class="col-sm-9">
                        <input type="text" name="name" value="" id="input-name" class="form-control" />
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class="col-sm-3 control-label" for="input-email"><?php echo $entry_email; ?></label>
                     <div class="col-sm-9">
                        <input type="text" name="email" value="" id="input-email" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group">
                     <label class="col-sm-3 control-label" for="input-phone"><?php echo $entry_phone; ?></label>
                     <div class="col-sm-9">
                        <input type="text" name="phone" value="" id="input-phone" class="form-control" />
                     </div>
                  </div>

                  <div class="form-group required">
                     <label class="col-sm-3 control-label" for="input-enquiry"><?php echo $entry_enquiry; ?></label>
                     <div class="col-sm-9">
                        <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control"></textarea>
                     </div>
                  </div>
                  <div class="form-group required">
                     <label class="col-sm-3 control-label" for="input-captcha"></label>
                     <div class="col-sm-9">
					    <div class="col-sm-6">
                        <input name="captcha" placeholder="<?php echo $entry_captcha; ?>" id="input-captcha" class="form-control" type="text"/>
						</div>
						<div class="col-sm-6">
                        <img src="index.php?route=extension/captcha/basic_captcha/captcha" alt="captcha"/>
						</div>
                     </div>
                  </div>
               </fieldset>
               <div class="buttons">
                  <div class="pull-right"><!-- btn-lg -->
                     <button class="btn btn-primary submit" id="SignupWbprgbtn" data-loading-text="<?php echo $button_wait; ?>" type="submit"><?php echo $button_submit; ?>
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
<?php
/*
<h2>Rückrufservice </h2>
<strong>Sie haben eine Frage oder eine Anfrage um Rat? </strong>
Füllen Sie einfach das Rückrufformular aus. Wir rufen Sie so schnell wie möglich zurück.<br />
Wir freuen uns auf Ihre Nachricht.
*/
; ?>
<style type="text/css"><!--
#module-contactm {
    /*background-color: #333333;*/
    padding-top: 5px;
    padding-bottom: 10px;
    margin-top: 0px;
    margin-right: -15px;
    margin-left: -15px;
}

#module-contactm .form-container {
    max-width: 1280px;
    margin-left: auto;
    margin-right: auto;
}

#module-contactm textarea {
    max-height: 111px;
}
#form-contactm{
width: 100%;
}

#form-contactm div.required .control-label:not(span):before {
    content: '* ';
    color: #F00;
    font-weight: bold;
}

.callback_heading {
    width: 100%;
    vertical-align: top;
    color: #7e842e;
    font-family: Arial,Helvetica,sans-serif;
    font-size: 18px;
    font-weight: 700;
    font-style: normal;
    margin: 5px 0px;
}
.disp {
    display: inline-block;
    position: relative;
}

--></style>

<script type="text/javascript"><!--

$('#SignupWbprgbtn').on('click', function(evt) {

	evt.preventDefault();

	var $btn = $(this).button('loading');
	$.ajax({
		url: 'index.php?route=module/contactm/send',
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
				$('#wrap-contactm .buttons').before('<div class="alert alert-danger col-sm-offset-2 col-sm-9  text-center"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#wrap-contactm .buttons').before('<div class="alert alert-success col-sm-offset-2 col-sm-9  text-center"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('#input-enquiry,#input-captcha').val('');

			}
		},
		error: function (request, error) {
		$btn.button('reset');
		$('.alert-success, .alert-danger').remove();
        //alert("AJAX Call Error: " + error);
		$('#wrap-contactm .buttons').before('<div class="alert alert-danger col-sm-offset-2 col-sm-9  text-center"><i class="fa fa-exclamation-circle"></i> AJAX Call Error</div>');
        }
	});
});

//--></script>