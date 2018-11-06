
        <div class="row">
         <div class="col-sm-6 col-md-12">
              <label style="margin:4px 0;">Vorname <span style="color:#e85c41;"> *</span></label>
              <input type="text" name="name"  class="form-control" placeholder="<?php echo $entry_name; ?>" autocomplete="off" value="" style="border: 1px solid #ABB0B2;border-radius: 0;" required>
              <label style="margin:4px 0;">Nachname <span style="color:#e85c41;"> *</span></label>
              <input type="text" class="form-control" placeholder="<?php echo $entry_name; ?>" autocomplete="off" value="" style="border: 1px solid #ABB0B2;border-radius: 0;" required>
              <label style="margin:4px 0;">Telefon <span style="color:#e85c41;"> *</span></label>
              <input type="tel" name="phone" class="form-control" placeholder="<?php echo $entry_phone; ?>" style="border: 1px solid #ABB0B2;border-radius: 0;" required>
              <button type="submit" class="fcallback" style="float:right; margin: 9px 0; background:#7e842e; border:none;padding: 3px 9px; font-size: 15px; color:#fff;"><?php echo $entry_submit; ?></button>

          <div class="ok-message" style="color:#e85c41; margin:10px 0;"></div>
              <script type="text/javascript">
                jQuery(document).ready(function($){
                  $(".fcallback").on('click', function() {
                    var name = $('.input-name').val();
                    var phone = $('.input-phone').val();
                    if(name!=''&&phone!=''){
                          $.ajax({
                            type: "GET",
                            url: "../catalog/controller/module/callback-sender.php",
                            data: 'name='+name+'&phone='+phone,
                            success: function() {
                                  $('.ok-message').html('<?php echo $entry_ok; ?>');
                                  setTimeout(function() { $('.ok-message').html(''); }, 2000)
                              }
                          });
                      } else {
                        $('.ok-message').html('<?php echo $entry_error; ?>');
                        setTimeout(function() { $('.ok-message').html(''); }, 2000)
                      }
                    });
                })
              </script>
          </div>
        </div>