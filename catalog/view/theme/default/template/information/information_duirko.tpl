<?php echo $header; ?>
<div class="col-md-4 col-md-pull-3 col-sm-4 col-sm-pull-4 col-xs-12 headernavigation" >
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
   <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
 </div>
            </div>
          </div>
        </div>
    </div>
<!-- Closing header tags -->

<!-- Content begins -->
 <div class="row">
        <div class="col-xs-12" >
          <div class="main-container">
            <div class="row">
            

<div class="col-md-9 col-md-push-3 col-xs-12 right-container">
<div class="row">
<div id="carousel-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <?php echo $content_top; ?>

</div>
<main class="main-text-container" id="content">
<h1><?php echo $heading_title; ?></h1>
        <?php if ($description) { ?>
        <?php echo $description; ?>
        <?php } ?>
</main>
</div>

<!-- callback form begin -->

	<?php if($information_id==88){ ?>
	
	
	
		<div class="callback_form">

			<span class="disp callback_heading callback_heading"><?php echo $callback_heading_1; ?></span>
			<span class="disp callback_heading callback_heading_2"><?php echo $callback_heading_2; ?></span>
			<span class="disp callback_heading callback_heading_3"><?php echo $callback_heading_3; ?></span>
			<span class="disp callback_heading callback_heading_3 callback_heading_4"><?php echo $callback_heading_4; ?></span>
			
			
			<div class="disp callback_row_inputs">
			
				<div class="disp callback_row">
					<label for="callback_input_name"><?php echo $callback_text_label_name; ?> :</label>
					<input id="callback_input_name" type="text" class="disp callback_input" value="" placeholder="<?php echo $callback_text_label_name; ?>" />
				</div>
				
				<div class="disp callback_row">
					<label for="callback_input_phone"><?php echo $callback_text_label_phone; ?> :</label>
					<input id="callback_input_phone" type="text" class="disp callback_input callback_input_phone" value="" placeholder="<?php echo $callback_text_label_phone; ?>" />
				</div>
				
				<div class="disp callback_row">
					<label for="callback_input_mail"><?php echo $callback_text_label_mail; ?> :</label>
					<input id="callback_input_mail" type="text" class="disp callback_input callback_input_mail" value="" placeholder="<?php echo $callback_text_label_mail; ?>" />
				</div>
				
				<div class="disp callback_row">
					<label for="callback_input_date"><?php echo $callback_text_label_date; ?> :</label>
					
					<textarea class="disp callback_textarea callback_input_date" id="callback_input_date" placeholder="<?php echo $callback_text_label_date; ?>"></textarea>
				</div>
				
				
				
			</div>
	
	<!-- reCAPTCHA begin -->
	
			<script src='https://www.google.com/recaptcha/api.js'></script>
			
			<div class="disp callback_recaptcha_cont">
			
			<div class="g-recaptcha" data-sitekey="6Ld5dmMUAAAAAOh3UVtaAss2dGMLClhy29ByxjWV"></div>
		
			</div>	
			
	<!-- reCAPTCHA end -->
				
			<div class="submit-container disp callback_submit_cont">
				<button type="submit" class="button_blue button_set">
					<span class="button-outer"><span id="recall_start" class="button-inner"><?php echo $callback_text_submit; ?></span></span>
				</button>
			</div>	
				
				
				
				
				
				
			<script type="text/javascript">
				
				// A $( document ).ready() block.
$( document ).ready(function() {
    
	console.log('ready for js ');
	
	$( "#recall_start" ).click(function() {
		alert( "Handler for .click() called." );
	});
	
});
				
			</script>	
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
		
		</div><!-- .callback_form end -->

			<style>
				
				.disp{
					display:inline-block;
					position:relative;
				}	
				
				.callback_heading{					
					width:100%;
					vertical-align:top;
					color: #7e842e;
					font-family: Arial,Helvetica,sans-serif;
					font-size: 18px;
					font-weight: 700;
					font-style: normal;
					margin:5px 0px;
				}
				
				.callback_heading_2{
					color: #333;	
					font-size: 16px;
				}
				
				.callback_heading_3{
					color: #333;	
					font-size: 14px;
					font-weight:normal;
				}
				
				.callback_row_inputs{
					margin-top:15px;
				}	
				
				.callback_row{
					width:100%;
					text-align:left;
				}

				.callback_row label{
					display:none;
				}

				.callback_input{
					width:250px;
					height:auto;
					line-height:24px;
					margin:5px 0px;
					padding:0px 10px;
					overflow:hidden;
				}	

				.callback_textarea{
					width:250px;
					min-height:125px;
					line-height:24px;
					margin:5px 0px;
					padding:0px 10px;
					overflow:hidden;
				}

				.callback_submit_cont{
					width:100%;
					vertical-align:top;
				}
				
				.callback_submit_cont .button-inner{
					text-transform: capitalize;
				}	
				
				
			</style>	
	
			
	
	<?php }; ?>

<!-- callback form end -->


</div><!-- end right container -->

 
<?php echo $column_right; ?>


          </div>
          </div>
        </div>
    </div>


	
	
<?php echo $footer; ?>

