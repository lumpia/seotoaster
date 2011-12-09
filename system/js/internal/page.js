$(function() {
	_MAIN_MENU_ID   = 'inMenu-1';
	_STATIC_MENU_ID = 'inMenu-2';
	_NO_MENU_ID     = 'inMenu-0';

	_elements = [$('#header-title'), $('#url'), $('#nav-name')]

	$('#pageCategory').hide();

	//hide label for the hidden field 'templateId'
	$('#templateId').prev().hide();

	$('#templatelist').delegate('div.template_preview', 'click', function() {
		var templateId = $(this).find('input[name="template-id"]').val();
		$('#templateId').val(templateId);
		$('#curr-template').text(templateId);
		$('#templatelist').slideUp();
	}).delegate('div.template_delete', 'click', function(){
		deleteTemplate($(this).closest('div.template_item'));
		return false;
	});

	$('.menu-selector').click(function() {
		checkMenu($(this).attr('id'));
	})

	if(!$('#pageId').val()) {
		$('#h1').keyup(function() {
			var currentValue = $(this).val();
			$(_elements).each(function() {
				$(this).val(currentValue);
			})
		})
		$('.menu-selector').each(function() {
			$(this).attr('checked', false);
		});
	}
	else {
		checkMenu();
	}

	$('#published').live('click', function() {
		if($('#draft').length) {
			$('#draft').val(($(this).prop('checked') ? 0 : 1));
		}
	})
	$('#datepicker').blur(function() {
		$('#publish-at').val($(this).val());
	})
})

function datepickerCallback() {
	$('#publish-at').val($(this).val());
}

function checkMenu(currentMenuItem) {
	var pageId = $('#pageId').val();
	if(!currentMenuItem) {
		currentMenuItem = $('.menu-selector:checked').attr('id');
	}
	switch(currentMenuItem) {
		case _STATIC_MENU_ID:
			$.getJSON($('#website_url').val() + 'backend/backend_page/rendermenu/mtype/2/pId/' + pageId, function(response) {
				$('#pageCategory').replaceWith(response.select);
				$('#pageCategory').hide();
			})
		break;
		case _MAIN_MENU_ID:
			$.getJSON($('#website_url').val() + 'backend/backend_page/rendermenu/mtype/1/pId/' + pageId, function(response) {
				$('#pageCategory').replaceWith(response.select).show();
			})
		break;
		case _NO_MENU_ID:
			$.getJSON($('#website_url').val() + 'backend/backend_page/rendermenu/mtype/0/pId/' + pageId, function(response) {
				$('#pageCategory').replaceWith(response.select)
				$('#pageCategory').hide();
			})
		break;
	}
}

function deleteTemplate(templateContainer) {
    var messageScreen = $('<div class="info-message"></div>').css({color:'lavender'}).html('Do you really want to remove this template?');
	$(messageScreen).dialog({
		modal    : true,
		title    : 'Remove template?',
		resizable: false,
		buttons: {
			Yes: function() {
				$.ajax({
					url: $('#website_url').val()+'backend/backend_theme/deletetemplate/',
					type: 'post',
					data: {"id": templateContainer.find('input[name="template-id"]').val()},
					success: function(response) {
						if (response.error == false){
							templateContainer.remove();
						}
						$('#ajax_msg').text(response.responseText).fadeIn().fadeOut(_FADE_FAST);
					},
					dataType: 'json'
				});
				$(this).dialog('close');
			},
			No : function() {
				$(this).dialog('close');
			}
		}
	}).parent().css({background: 'indianred'});
}