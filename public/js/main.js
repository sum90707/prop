$(function() {
	$.urlParam = function(name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		return results ? results[1] : '';
	}


	$('body').on('click', '.js-button', function() {
		let $button = $(this),
			route = $button.data('route'),
			method = $button.data('method'),
			callback = $button.data('callback');

		$button.addClass('loading');
	
		$.ajax({
			url: route,
			type: method ? method : 'get',
			success: function(json) {
				if(json.status == 200){
					$button.removeClass('loading');
					eval(callback)($button, json);
				}else{
					ajaxErrors(json);
				}
				
			}
		})
		.fail(function(e) {
			$button.removeClass('loading');
			ajaxErrors(e);
		});
	});


	
})

function activePath(path, parameters) {
	$.each(parameters, function (parameter, value) {
		path = path.replace(new RegExp(parameter, 'g'), value);
	})
    
	return path;
}

function ajaxErrors(e) {
	$.uiAlert({
		textHead: "Error " + e.status, // header
		text: e.message ? e.message : '', // Text
		bgcolor: '#DB2828', // background-color
		textcolor: '#fff', // color
		position: 'bottom-right',// position . top And bottom ||  left / center / right
		icon: 'remove circle', // icon in semantic-UI
		time: 5, // time	
	});
}

function ajaxSussMsg(json){
	$.uiAlert({
		textHead: '', // header
		text: json.message ? json.message : '', // Text
		bgcolor: '#19c3aa', // background-color
		textcolor: '#fff', // color
		position: 'bottom-right',// position . top And bottom ||  left / center / right
		icon: 'checkmark box', // icon in semantic-UI
		time: 5, // time	
	});	
}
