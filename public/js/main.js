$(function() {
	$.urlParam = function(name) {
		var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
		return results ? results[1] : '';
	}

	$('body .pusher .close').not('#sidebar-form').click(function() {
		resetSidebar();
		toggleSideBarForm();
	});


	$('body').on('click', '.js-button', function() {
		let $button = $(this),
			route = $button.data('route'),
			method = $button.data('method'),
			callback = $button.data('callback');

		$button.addClass('loading');
	
		$.ajax({
			url: route,
			type: method ? method : 'get',
			success: function(json, textStatus, xhr) {
				$button.removeClass('loading');
				eval(callback)($button, json);
			}
		})
		.fail(function(xhr) {
			$button.removeClass('loading');
			ajaxErrors(xhr);
		});
	});


	$('body').on('click', '.menu-item-btn', function() {
		let route = $(this).data('route');
		location.href=route;
	});

	$('body').on('click', '.js-sidebar', function() {
		let $button = $(this),
			route = $button.data('route');

		$button.addClass('loading');

		$.ajax({
			url: route,
			success: function(html) {
				$('#sidebar-form').html(html);
				setTimeout(function() {
					toggleSideBarForm();
					$button.removeClass('loading');
				}, 300)
			}
		})
		.fail(function(e) {
			$button.removeClass('loading');
			ajaxErrors(e);
		});
	});

	$('body').on('click', '.js-sidebar-save', function() {
		let $button = $(this),
			route = $button.data('route'),
			$form = $button.closest('form'),
			method = $form.attr('method'),
			token = $form.find('[name="_token"]').val();

		$button.addClass('loading');

		$.ajax({
			url: route,
			type: method,
			headers: {
				'X-CSRF-TOKEN': token
			},
			data: $form.serializeArray(),
			success: function(json) {
				$button.removeClass('loading');
				ajaxSussMsg(json);
				resetSidebar();
				toggleSideBarForm();
				$('.js-table').DataTable().draw(false);
			}
		})
		.fail(function(e) {
			$button.removeClass('loading');
			ajaxErrors(e);
		});
		
	});


	$('body').on('click', '.js-sidebar-close', function() {
		resetSidebar();
		toggleSideBarForm();
	});
})

function activePath(path, parameters) {
	$.each(parameters, function (parameter, value) {
		path = path.replace(new RegExp(parameter, 'g'), value);
	})
    
	return path;
}

function ajaxErrors(xhr) {
	$.uiAlert({
		textHead: "Error " + xhr.status, // header
		text: xhr.responseJSON.message ? xhr.responseJSON.message : '', // Text
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

function errorAlert(json) {
	$.uiAlert({
		textHead: "Error " + json.status, // header
		text: json.message ? json.message : '', // Text
		bgcolor: '#DB2828', // background-color
		textcolor: '#fff', // color
		position: 'bottom-right',// position . top And bottom ||  left / center / right
		icon: 'remove circle', // icon in semantic-UI
		time: 5, // time	
	});
}

function toggleSideBarForm() {
	var sidebar = $('body .pusher');

	if (sidebar.data("opened") == true) {
		sidebar.data("opened", false);	
		sidebar.removeClass("dimmed");
		$("#sidebar-form").removeClass("push");
		$(".menu-icon").css("opacity", "1");

		$('#sidebar-form .modal').modal('hide');
	} else {
		sidebar.data("opened", true);
		sidebar.addClass("dimmed");		
		$("#sidebar-form").addClass("push");	
		$(".menu-icon").css("opacity", "0");
	}	
}

function resetSidebar() {
	$("#sidebar-form").html('');
}

function  setCheckBox($checkbox, response=false) {
    
    if(response){
        $checkbox.data('status', parseInt(response.btnStatus));
    }

    if($checkbox.data('status') === 1){
        $checkbox.checkbox('set checked');
    }else{
        $checkbox.checkbox('set unchecked');
    }
}

function statusToggle() {
    let id = $(this).data('id'),
        $btn = $(this),
        route = $btn.data('route');

    $.ajax({
        url: activePath(route, {'__index__' : id}),
        type: 'PUT', 	
        success: function(json, textStatus, xhr) {
            ajaxSussMsg(json);
            setCheckBox($btn, json);
        }
    })
    .fail(function(xhr) {
        ajaxErrors(xhr);
    });
}
