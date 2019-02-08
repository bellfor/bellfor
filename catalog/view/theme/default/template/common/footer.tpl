</div>
</div>
</div>
</div>
</div>
</div>
<footer>
   <div class="container">
      <div class="row">
          <div class="col-xs-12 footer-container custom-footer">
              <?php if ($informations) { ?>
                  <div class="col-sm-3">
                      <h5 class="custom-footer-h5"><?php echo $text_information; ?></h5>
                      <ul class="list-unstyled">
                          <?php foreach ($informations as $information) { ?>
                              <li class="custom-footer-li">
                                  <a class="custom-footer-a" href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a>
                              </li>
                          <?php } ?>
                      </ul>
                  </div>
              <?php } ?>
              <?php if($articles) { ?>
                  <div class="col-md-9">
                      <h5 class="custom-footer-h5"><?php echo $text_article; ?></h5>
                      <div class="col-md-12" style="padding: 0;">
                          <?php foreach ($articles as $article) { ?>
                              <div class="col-md-4" style="padding: 0 30px 0 0;">
                                  <ul class="list-unstyled">
                                      <?php foreach ($article as $value) { ?>
                                          <li class="custom-footer-li">
                                              <a class="custom-footer-a" href="<?php echo $value['href']; ?>" target="_blank"><?php echo $value['name']; ?></a>
                                          </li>
                                      <?php } ?>
                                  </ul>
                              </div>
                          <?php } ?>
                      </div>
                  </div>
              <?php } ?>
          </div>
      </div>
   </div>
   <!-- Modal Mailchimp -->
   <div class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="MailchimpModalLabel">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-body mailchimp-popup" id="subscribeModalBody">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 class="modal-title" id="subscribeModalLabel">Danke fürs anmeldung!</h2>
            </div>
         </div>
      </div>
   </div>
   <!-- end Modal Mailchimp -->
    <div id="related_popup" style="display:none;">
        <div id="related_popup_content" style="position: fixed; z-index: 100; width: 100%; height: 100%; top: 0; background-color: black; opacity: 0.4;"></div>
    </div>
    <?php if (isset($consultant)) { ?>
    <div id="consultant-shadow" class="displaynone display-shadow"></div>
    <div id="consultant" class="displaynone consultant-div">
        <div class="futterconsultant">
            <img class="" src="/image/catalog/futterconsultant/476x714_Futter_consultant.jpg" style="max-width: 360px;" alt="">
            <img class="close-consultant" src="/image/catalog/futterconsultant/close.png" title="Close" onclick="closeConsultant();" alt="">
            <a href="/futterconsultant" style="text-decoration: none;">
                <img class="redirect-consultant" src="/image/catalog/futterconsultant/cta.png" alt="">
            </a>
        </div>
    </div>
    <?php } ?>
</footer>
<?php if (isset($consultant)) { ?>
<script>
    $('body').mouseleave(function () {
        $.ajax({
            url: 'index.php?route=common/footer/promoCodePopUp',
            dataType: 'json',
            type: 'post',
            success: function(json){
                if (json == true) {
                    $('#consultant-shadow').removeClass('displaynone');
                    $('#consultant').removeClass('displaynone');
                }
            }
        })
    });
    function closeConsultant() {
        $('#consultant-shadow').addClass('displaynone');
        $('#consultant').addClass('displaynone');
    }
</script>
<?php } ?>
<script>
    $('#related_popup').on('click', function () {
        $('.noty_close_button').trigger("click");
    });
</script>

<?php
//fixed by oppo webiprog.com  12.02.2018 MAR-147
// 1 MailChimp old == slows down site load
if(false) { ?>
<script type="text/javascript" src="//downloads.mailchimp.com/js/signup-forms/popup/embed.js" data-dojo-config="usePlainJson: true, isDebug: false"></script><script type="text/javascript">require(["mojo/signup-forms/Loader"], function(L) { L.start(
  {"baseUrl":"mc.us15.list-manage.com","uuid":"44e485c6078b962ba614c3b99","lid":"a4ad26a3f6"})})</script>
<?php }

// 2 MailChimp new == also slows down site load (best)
if(false) { ?>

<script type="text/javascript"><!--
    // Fill in your MailChimp popup settings below.
    // These can be found in the original popup script from MailChimp.
    var mailchimpConfig = {
        baseUrl: 'mc.us15.list-manage.com',
        uuid: '44e485c6078b962ba614c3b99',
        lid: 'a4ad26a3f6'
    };

    // No edits below thmc_embed_signupis line are required
    var chimpPopupLoader = document.createElement("script");
    chimpPopupLoader.src = '//s3.amazonaws.com/downloads.mailchimp.com/js/signup-forms/popup/embed.js';
    chimpPopupLoader.setAttribute('data-dojo-config', 'usePlainJson: true, isDebug: false');

    var chimpPopup = document.createElement("script");
    chimpPopup.appendChild(document.createTextNode('require(["mojo/signup-forms/Loader"], function (L) { L.start({"baseUrl": "' +  mailchimpConfig.baseUrl + '", "uuid": "' + mailchimpConfig.uuid + '", "lid": "' + mailchimpConfig.lid + '"})});'));

    jQuery(function ($) {
        document.body.appendChild(chimpPopupLoader);

        $(window).load(function () {
            document.body.appendChild(chimpPopup);
        });

    });
//--></script>

<?php } ?>
<!--END fixed by oppo webiprog.com  12.02.2018 MAR-147-->
    <script type="text/javascript">
        function visiblePopup() {
            setTimeout(function () {
                if ($('#mce-success-response').css('display') === 'block'){
                    $('#mce-responses').css('display', 'block');
                } else if ($('#mce-error-response').css('display') === 'block') {
                    $('#mce-responses').css('display', 'block');
                }
            }, 2000);
        }
        <?php echo file_get_contents("catalog/view/javascript/bootstrap/js/bootstrap.min.js");?>
    </script>
    <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="catalog/view/theme/default/stylesheet/fonts.min.css" rel="stylesheet">
    <script src="catalog/view/javascript/script.js"></script>
    <script src="catalog/view/javascript/libs/zoomsl-3.0.js"></script>
</body>
</html>