function SendUmailChimpForm(mod_id, obj){
var datas=obj.serialize();
if(datas!='')
datas+='&mod_id=' + mod_id;
else
datas='mod_id=' + mod_id;
		$.ajax({
			url: 'index.php?route=module/umailchimp/send',
			type: 'post',
			data: datas,
			dataType: 'json',
			beforeSend: function() {
			obj.children('button').button('loading');
			},
			complete: function() {
			obj.children('button').button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();
				if (json['error']) {
				$('.breadcrumb').after('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				obj.find('.form-group input[type=text]').val('');

				}
			}
		});
}


function SendUmailChimpFormPopup(mod_id, obj){
var datas=obj.serialize();
if(datas!='')
datas+='&mod_id=' + mod_id;
else
datas='mod_id=' + mod_id;
		$.ajax({
			url: 'index.php?route=module/umailchimp/send',
			type: 'post',
			data: datas,
			dataType: 'json',
			beforeSend: function() {
			obj.children('button').button('loading');
			},
			complete: function() {
			obj.children('button').button('reset');
			},
			success: function(json) {
				$('.alert, .text-danger').remove();
				if (json['error']) {
				obj.parent().before('<div class="alert alert-danger">' + json['error'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}
				if (json['success']) {
				obj.parent().before('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				obj.find('.form-group input[type=text]').val('');
				}
			}
		});
}