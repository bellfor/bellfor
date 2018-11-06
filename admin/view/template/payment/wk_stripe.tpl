<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-layout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
          <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
      </div>
      <ul class="breadcrumb">
       <?php foreach ($breadcrumbs as $breadcrumb) { ?>
         <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
       <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
     <div class="warning"><?php echo $error_warning; ?>
     </div>
     <?php } ?>
     <div class="panel panel-default">
       <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i><?php echo $heading_title; ?></h3>
        </div>
        <div class="panel-body">
         <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-layout"   class="form-horizontal">
          <ul class="nav nav-tabs">
           <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
           <li> <a href="#tab-stripe" data-toggle="tab"><?php echo $tab_stripe; ?></a></li>
           <li><a href="#tab-checkout" data-toggle="tab"><?php echo $tab_checkout; ?></a></li>
           <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_status; ?></a></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
             <div class="form-group required">
               <label class="col-sm-2 control-label" for="input-title"><span class="required" data-toggle="tooltip" title="<?php echo $entry_title_info ; ?>"><?php echo $entry_title; ?></span></label>
                  <div class="col-sm-10">   
               <?php foreach ($languages as $language) { ?> 
                 <div class="input-group">
                  <span class="input-group-addon">
                   <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
                  </span>
                  <input type="text" class="form-control" name="wk_stripe_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($wk_stripe_title[$language['language_id']]) ? $wk_stripe_title[$language['language_id']]: ''; ?>" />
                 </div>
                 <br>
               <?php } ?>
               </div>
             </div>

          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-btn-text"><span class="required" data-toggle="tooltip" title="<?php echo $entry_btn_info ; ?>"><?php echo $entry_btn_text; ?></span></label>
              <div class="col-sm-10"> 
                <?php foreach ($languages as $language) { ?>  
                  <div class="input-group">
                   <span class="input-group-addon">
                   <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
                   </span>          
                   <input type="text" class="form-control" name="wk_stripe_button_text[<?php echo $language['language_id']; ?>]" value="<?php echo isset($wk_stripe_button_text[$language['language_id']]) ? $wk_stripe_button_text[$language['language_id']]: ''; ?>" />
                  </div>
                  <br>
                <?php } ?>
               </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
                  <select name="wk_stripe_status" class="form-control">
                  <?php if ($wk_stripe_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
            <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_sort_order" value="<?php echo $wk_stripe_sort_order; ?>" size="1" /></div>
            </div>

          <div class="form-group">
           <label class="col-sm-2 control-label" for="input-total"><?php echo $entry_total; ?></label>
            <div class="col-sm-10"> 
             <div class="input-group">
              <span class="input-group-addon">
              <?php echo $entry_min; ?>
              </span>
              <input type="text" class="form-control" name="wk_stripe_min" value="<?php echo $wk_stripe_min; ?>" placeholder="<?php echo $entry_min; ?>" />
                </div><br>
             <div class="input-group">
              <span class="input-group-addon">
               <?php echo $entry_max; ?>
              </span>
              <input type="text" class="form-control" name="wk_stripe_max" value="<?php echo $wk_stripe_max; ?>" placeholder="<?php echo $entry_max; ?>" />  
             </div>
             </div>
            </div>
            <div class="form-group">  
             <label class="col-sm-2 control-label" for="input-geo-zone"><?php echo $entry_geo_zone; ?><?php echo $entry_geo_zoneinfo ; ?></label>
             <div class="scrollbox col-sm-10">
              <div class="well well-sm">
               <div class="even"> 
                <lable> 
                 <?php if (in_array(0, $wk_stripe_zone)) { ?>
                  <input type="checkbox" name="wk_stripe_zone[0]" value="0" checked="checked" />
                 <?php } else { ?>
                 <input type="checkbox" name="wk_stripe_zone[0]" value="0" />
                 <?php } ?>
                 <?php echo $text_all_zones; ?>
                </lable>
               </div>
               <?php foreach ($geo_zones as $geo_zone) { if(!isset($i)) $i=0; ?>
              <div class="<?php if($i==0){ echo 'odd';}else{ echo 'even'; $i=-1;} ?> checkbox"><label>
               <?php if (in_array($geo_zone['geo_zone_id'], $wk_stripe_zone)) { ?>
                <input type="checkbox" name="wk_stripe_zone[<?php echo $geo_zone['geo_zone_id']; ?>]" value="?php echo $geo_zone['geo_zone_id']; ?>" checked="checked"/>
                 <?php } else { ?>
                <input type="checkbox" name="wk_stripe_zone[<?php echo $geo_zone['geo_zone_id']; ?>]" value="?php echo $geo_zone['geo_zone_id']; ?>"/>
                 <?php } ?>
                <?php echo $geo_zone['name']; ?></label>
              </div>
               <?php $i++;} ?> 
              </div>                 
             </div>
            </div>

            <div class="form-group">  
             <label class="col-sm-2 control-label" for="input-groups"><?php echo $entry_groups; ?><?php echo $entry_groupsinfo ; ?></label>
             <div class="scrollbox col-sm-10">
              <div class="well well-sm">
               <div class="checkbox">
                <label>
                 <div class="odd">                    
                   <?php if (in_array(0, $wk_stripe_customergroups)) { ?>
                    <input type="checkbox" name="wk_stripe_customergroups[0]" value="0" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="wk_stripe_customergroups[0]" value="0" />
                    <?php } ?>
                    <?php echo $text_all_customer; ?>
                  </div>
                </label>
                  <?php foreach ($customer_groups as $customer_group) { if(!isset($i)) $i=0; ?>
                  <div class="<?php if($i==0){ echo 'even';}else{ echo 'odd'; $i=-1;} ?> ">
                    <label>
                    <?php if (in_array($customer_group['customer_group_id'], $wk_stripe_customergroups)) { ?>
                    <input type="checkbox" name="wk_stripe_customergroups[<?php echo $customer_group['customer_group_id']; ?>]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked"/>
                    <?php } else { ?>
                    <input type="checkbox" name="wk_stripe_customergroups[<?php echo $customer_group['customer_group_id']; ?>]" value="<?php echo $customer_group['customer_group_id']; ?>"/>
                    <?php } ?>
                    <?php echo $customer_group['name']; ?></label>
                  </div>
               </div>
               <?php $i++;} ?>     
              </div>             
             </div>
            </div>
        </div>
         <div class="tab-pane" id="tab-stripe"> 
          <!--<?php echo $entry_keysinfo ; ?>-->
           <div class="form-group required">
             <label class="col-sm-2 control-label" for="input-stripe-mode"> <span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_modeinfo ; ?>"><?php echo $entry_stripe_mode; ?></span></label>
             <div class="col-sm-10">
                <select name="wk_stripe_mode" class="form-control">
                  <?php if (!$wk_stripe_mode) { ?>
                  <option value="0" selected="selected"> <?php echo $text_test; ?> </option>
                  <?php } else { ?>
                  <option value="0"> <?php echo $text_test; ?> </option>
                  <?php } ?>
                  <?php if ($wk_stripe_mode) { ?>
                  <option value="1" selected="selected">  <?php echo $text_live; ?> </option>
                  <?php } else { ?>
                  <option value="1"> <?php echo $text_live; ?> </option>
                  <?php } ?>
                </select>
             </div>
           </div>
           <div class="form-group required">
             <label class="col-sm-2 control-label" for="input-test-key"><?php echo $entry_test_key; ?></label>
             <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_test_key" value="<?php echo $wk_stripe_test_key; ?>" size="44"/>
                <?php if ($error_signature) { ?>
                <span class="error"><?php echo $error_signature; ?></span>
                <?php } ?>
             </div>
           </div>
           <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-test-publish"><?php echo $entry_test_publish_key; ?></label>
            <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_test_publish_key" value="<?php echo $wk_stripe_test_publish_key; ?>" size="44"/>
                <?php if ($error_signature) { ?>
                <span class="error"><?php echo $error_signature; ?></span>
                <?php } ?>
            </div>
           </div>
           <div class="form-group required">
             <label class="col-sm-2 control-label" for="input-live-key"><?php echo $entry_live_key; ?></label>
             <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_live_key" value="<?php echo $wk_stripe_live_key; ?>" size="44"/>
                <?php if ($error_signature) { ?>
                <span class="error"><?php echo $error_signature; ?></span>
                <?php } ?>
             </div>
           </div>
           <div class="form-group required">
             <label class="col-sm-2 control-label" for="input-live-publish"><?php echo $entry_live_publish_key; ?></label>
             <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_live_publish_key" value="<?php echo $wk_stripe_live_publish_key; ?>" size="44"/>
                <?php if ($error_signature) { ?>
                <span class="error"><?php echo $error_signature; ?></span>
                <?php } ?>
             </div>
           </div>
           <div class="form-group">
              <label class="col-sm-2 control-label" for="input-curr-mapping"><?php echo $entry_currecny_mapping; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_currecny_mappinginfo ; ?>">
              </span></label>
              <div class="col-sm-10">
                <?php if ($currencies) { ?>
                  <?php foreach($currencies as $currencie){ ?>  
                  <div class="input-group">
                   <span class="input-group-addon">                  
                    <?php echo $currencie['code']; ?></span>
                   <select class="form-control" name="wk_stripe_currency[<?php echo $currencie['code']; ?>]">
                    <option value="0" selected > <?php echo $text_disabled; ?> </option>
                    <?php foreach($currencies as $currencie2){ ?>                 
                       <?php if(isset($wk_stripe_currency[$currencie['code']]) AND $currencie2['code']==$wk_stripe_currency[$currencie['code']]){ ?>
                        <option value="<?php echo $currencie2['code']; ?>" selected > <?php echo $currencie2['code']; ?> </option>
                        <?php }else{ ?>
                        <option value="<?php echo $currencie2['code']; ?>" > <?php echo $currencie2['code']; ?> </option>
                      <?php } ?>                     
                    <?php } ?>
                   </select>
                  </div>
                  <br>
                  <?php } ?>
                <?php } ?>
              </div>
           </div>
           <div class="form-group">
              <label class="col-sm-2 control-label" for="input-send-cus"><?php echo $entry_send_customer; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_send_customerinfo ; ?>"></span></label>
              <div class="col-sm-10"><select name="wk_stripe_customer_data" class="form-control">
                  <?php if (!$wk_stripe_customer_data) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                  <?php if ($wk_stripe_customer_data) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                </select>
              </div>
           </div>
           <div class="form-group">
              <label class="col-sm-2 control-label" for="input-stripe-des"><?php echo $entry_stripe_description; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_descriptioninfo ; ?>"></span></label>
              <div class="col-sm-10"><input type="text" class="form-control" name="wk_stripe_transaction_description" value="<?php echo $wk_stripe_transaction_description; ?>"  size="44" placeholder="<?php echo $entry_tran_description_placeholder; ?>"/></div>
            </div>
          </div>

         <div class="tab-pane" id="tab-checkout">
          <!--<?php echo $entry_stripe_settingsinfo ; ?>-->
             <div class="form-group">
               <label class="col-sm-2 control-label" for="input-remember"><?php echo $entry_remember_me; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_remember_meinfo ; ?>"></span></label>
               <div class="col-sm-10"><select name="wk_stripe_rememberme" class="form-control">
                  <?php if (!$wk_stripe_rememberme) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                  <?php if ($wk_stripe_rememberme) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                </select></div>
             </div>
             <div class="form-group">
               <label class="col-sm-2 control-label" for="input-shipping"><?php echo $entry_shipping; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_shippinginfo ; ?>"></span></label>
               <div class="col-sm-10"><select name="wk_stripe_shipping" class="form-control">
                  <?php if (!$wk_stripe_shipping) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                  <?php if ($wk_stripe_shipping) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                </select>
               </div>
            </div>
           <div class="form-group">
              <label class="col-sm-2 control-label" for="input-stripe-logo"><?php echo $entry_stripe_logo; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_logoinfo ; ?>"></span></label>
              <div class="col-sm-10">
               <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $wk_stripe_img; ?>" id="thumb" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                <input type="hidden" name="wk_stripe_logo" value="<?php echo $wk_stripe_logo; ?>" id="input-image" />
              </div>
           </div>
           <div class="form-group">
              <label class="col-sm-2 control-label" for="input-pop-des"><?php echo $entry_stripe_pop_description; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_pop_desinfo ; ?>"></span></label>
              <div class="col-sm-10">  
                <?php foreach ($languages as $language) { ?>  
                 <div class="input-group">
                  <span class="input-group-addon">
                   <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                  </span>             
                  <input type="text" class="form-control" name="wk_stripe_popup_description[<?php echo $language['language_id']; ?>]" value="<?php echo isset($wk_stripe_popup_description[$language['language_id']]) ? $wk_stripe_popup_description[$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_popup_discription_placeholder; ?>"/>
                  </div>
                  <br>
                  <?php } ?>
                </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_stripe_pop_title; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_pop_titleinfo ; ?>"></span></label>
              <div class="col-sm-10"> 
              <?php foreach ($languages as $language) { ?>    
                 <div class="input-group">
                  <span class="input-group-addon">
                   <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                  </span>                
                  <input type="text" class="form-control" name="wk_stripe_popup_title[<?php echo $language['language_id']; ?>]" value="<?php echo isset($wk_stripe_popup_title[$language['language_id']]) ? $wk_stripe_popup_title[$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_popup_title_placeholder; ?>"/>
                  </div>
                  <br>
              <?php } ?>
               </div>
            </div>

             <div class="form-group">
              <label class="col-sm-2 control-label" for="input-pop-text"><?php echo $entry_stripe_pop_text; ?><span class="required" data-toggle="tooltip" title="<?php echo $entry_stripe_pop_textinfo ; ?>"></span></label>
              <div class="col-sm-10">  
              <?php foreach ($languages as $language) { ?>   
                 <div class="input-group">
                   <span class="input-group-addon">
                    <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> 
                   </span>               
                   <input type="text" class="form-control" name="wk_stripe_popup_button[<?php echo $language['language_id']; ?>]" value="<?php echo isset($wk_stripe_popup_button[$language['language_id']]) ? $wk_stripe_popup_button[$language['language_id']] : ''; ?>" placeholder="<?php echo $entry_popup_button_placeholder; ?>"/>
                   </div>
                  <br>
                  <?php } ?>
               </div>
             </div>
        </div>

        <div class="tab-pane" id="tab-status">
          <!--<?php echo $entry_orderinfo ; ?>       -->
             <div class="form-group">
              <label class="col-sm-2 control-label" for="input-success"><?php echo $entry_successpayment; ?></label>
              <div class="col-sm-10"><select name="wk_stripe_success_status" class="form-control">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $wk_stripe_success_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
             </div>
          </div>

             <div class="form-group">
              <label class="col-sm-2 control-label" for="input-street"><?php echo $entry_streetchk; ?></label>
             <div class="col-sm-10"><select name="wk_stripe_addess_status" class="form-control">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $wk_stripe_addess_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
             </div>
            </div>
             <div class="form-group">
              <label class="col-sm-2 control-label" for="input-zipchk"><?php echo $entry_zipchk; ?></label>
              <div class="col-sm-10"><select name="wk_stripe_zip_status" class="form-control">
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $wk_stripe_zip_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-cvcchk"><?php echo $entry_cvcchk; ?></label>
             <div class="col-sm-10"><select name="wk_stripe_cvc_status" class="form-control">
               <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $wk_stripe_cvc_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                 </select>
             </div>
            </div>

            <div class="form-group">
             <label class="col-sm-2 control-label" for="input-refund"><?php echo $entry_refund; ?></label>
             <div class="col-sm-10"><select name="wk_stripe_refund_status" class="form-control">
              <?php foreach ($order_statuses as $order_status) { ?>
               <?php if ($order_status['order_status_id'] == $wk_stripe_refund_status) { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
              </select>
             </div>
            </div>  
        </div>     
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$('#tabs a').tabs(); 
</script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
  $('#dialog').remove();
  
  $('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
  
  $('#dialog').dialog({
    title: '<?php echo $text_image_manager; ?>',
    close: function (event, ui) {
      if ($('#' + field).attr('value')) {
        $.ajax({
          url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
          dataType: 'text',
          success: function(text) {
            $('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
          }
        });
      }
    },  
    bgiframe: false,
    width: 800,
    height: 400,
    resizable: false,
    modal: false
  });
};
//--></script> 
<?php echo $footer; ?>