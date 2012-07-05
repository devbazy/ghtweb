$(function(){

	// Host
	var host = window.location.protocol + '//' + window.location.hostname + '/';   // http://www.mysite.ru/

	// Tooltip
	$('[rel=tooltip]').tooltip();
	
	// Popup
	$('[rel=popover]').popover({
		placement: 'top'
	})
	
	// Окошки с сообщениями, закрытие
	$('.alert').alert();
	
	// Смена пароля от игрового аккаунта
	$('a.account-change-passowrd').click(function(){
		var self        = $(this),
			server_id   = parseInt(self.attr('server-id')),
			login       = self.attr('login'),
			modal_block = $('#modal-box-change-password');
		
		$('.modal-header h3 span', modal_block).html(': ' + login);
		
		$(':hidden[name=server_id]', modal_block).val(server_id);
		$(':hidden[name=login]', modal_block).val(login);
		
		// Очистка полей
		$('input[type=password]', modal_block).val('');

		// Удаляю инфу об ошибках
		$('div.alert', modal_block).remove();
		
		modal_block.modal('show');
	});
	
	$('.modal a.close-button').click(function(){
		$('.modal').modal('hide');
	});
	
	$('form.modal-box-change-password').submit(function(){
		
		var self        = $(this),
			params      = self.serialize(),
			button      = $('.btn-primary', self),
			button_text = button.html(),
			modal_block = self.parent();
		
		button.html(button.attr('data-text')).addClass('disabled');

		// Удаляю инфу об ошибках
		$('div.alert', modal_block).remove();
		
		$.post('/cabinet/game_accounts/change_password_ajax', params, function(data){
			button.html(button_text).removeClass('disabled');
			
			var msg_block = 
				'<div class="alert ' + (data.status ? 'alert-success' : 'alert-error') + '">' +
					'<button class="close" data-dismiss="alert">×</button>' +
					data.message +
				'</div>';
			
			$('.modal-body', modal_block).prepend(msg_block);
			
			if(data.status === true)
			{
				// Очистка полей
				$('input[type=password]', modal_block).val('');
			}
			
		}, 'json').error(function(){
			button.html(button_text).removeClass('disabled');
			console.log('error');
		});
		
		return false;
	});
	
	
	// Телепорт в город
	$('ul.city-for-tp li a').click(function(){
		var self = $(this),
			block = self.parent().parent().parent().parent().parent();
		
		$(':hidden[name=city_id]', block).val(parseInt(self.attr('city-id')));
	});
	
	
	// Подарок другу
	$('a.gift_friend').bind('click', function(){
		
		var self        = $(this),
			item_id     = parseInt(self.attr('item-id')),
			modal_block = $('#modal-box-gift-friend'),
			item_name   = self.attr('item-name');
		
		$(':hidden[name=item_id]', modal_block).val(item_id);
		
		// Очистка полей
		$('#login', modal_block).val('');
		
		// Удаляю инфу об ошибках
		$('div.alert', modal_block).remove();
		
		$('h3.item-name-block', modal_block).html(item_name);
		
		modal_block.modal('show');
	});
	
	$('form.modal-box-gift-friend').submit(function(){
		
		var self        = $(this),
			params      = self.serialize(),
			button      = $('.btn-primary', self),
			button_text = button.html(),
			modal_block = self.parent();
		
		button.html(button.attr('data-text')).addClass('disabled');

		// Удаляю инфу об ошибках
		$('div.alert', modal_block).remove();
		
		$.post('/cabinet/warehouse/gift_friend', params, function(data){
			button.html(button_text).removeClass('disabled');
			
			$('.modal-body', modal_block).prepend(data.message);
			
			if(data.status === true)
			{
				// Очистка полей
				$('#login', modal_block).val('');
				
				var a = $('a.gift_friend[item-id=' + parseInt($(':hidden[name=item_id]', modal_block).val()) + ']');
				
				// Удаляю ячейку в таблице
				a.parents('tr').remove();
				
				// В счётчике -1
				var badge = $('.badge-info');
				var count_item = parseInt(badge.text());
				badge.text(count_item-1);
			}
			
		}, 'json').error(function(){
			button.html(button_text).removeClass('disabled');
			console.log('error');
		});
		
		return false;
	});
	
	
	
	
	
	// Модальное окно
	//$('#myModal').modal();
	
	/*for(var i in window.location)
	{
		console.log(i + ' -> ' + window.location[i]);
	}*/
	
    // Captcha reload
    $('div.captcha').click(function(){
        var self = $(this);
		
        self.html('<img class="img-loader-captcha" src="/resources/images/ajax-loader.gif" alt="" />');
		
        $.get(host + 'ajax/captcha_reload/',{},function(data){
			$(data.image).load(function(){
				self.html(data.image);
			});
        },'json').error(function(){
			console.log('ajax_error');
		});
    });
	
}) 