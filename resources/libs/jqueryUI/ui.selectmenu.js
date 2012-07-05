$(function(){
	
	jQuery.fn.gselect = function(options){
		
		var options = jQuery.extend({
			delay: 200
		}, options);
		
		$(this).each(function(){
			
			var select  = $(this),
				width   = select.width(),
				options = $('option', select);
			
			// Frame
			var frame = 
				$('<div class="selectmenu">' +
					'<div class="selectmenu-header"></div>' +
					'<div class="selectmenu-arrow"></div>' +
					'<ul class="selectmenu-content"></ul>' +
				'</div>');
			
			var option = '';
			var def    = select.val();
			
			options.each(function(){
				var opt = $(this);
				var h = opt.html();
				var s = (h == def ? ' class="selected"' : '');
				
				if(opt.attr('selected'))
				{
					$('.selectmenu-header', frame).html(h);
				}
				
				option += '<li' + s + '><a>' + h + '</a></li>';
			});
			
			$('ul.selectmenu-content', frame).prepend(option);
			
			// Add width
			frame.css('width',width + 'px');
			
			// Click header event
			$('.selectmenu-header, .selectmenu-arrow', frame).on('click', change_select);
			
			// Click li event
			$('.selectmenu-content li', frame).on('click', click_select);
			
			// Hide this select
			select.hide();
			
			// After frame
			select.after(frame);
		});
		
		function click_select()
		{
			var self     = $(this),
				v        = self.text(),
				parent   = self.parent(),
				o_select = self.parent().parent().prev(),
				options  = $('option', o_select);
				
			options.removeAttr('selected');
			$('li', parent).removeClass('selected');
			
			self.addClass('selected');
			
			options.each(function(){
				if($(this).html() == v)
				{
					$(this).attr('selected', true);
				}
			});
			
			$('.selectmenu-header', parent.parent()).html(v);
			
			close(parent.parent());
		}
		
		function change_select()
		{
			var self   = $(this),
				parent = self.parent();
			
			if($('ul.selectmenu-content', parent).is(':hidden'))
			{
				open(parent);
			}
			else
			{
				close(parent);
			}
		}
		
		function open(select)
		{
			// Close all selects
			$('.selectmenu-content', 'body').slideUp(options.delay,function(){
				$(this).parent().removeClass('drops');
			});
			
			select.addClass('drops');
			$('ul.selectmenu-content', select).slideDown(options.delay);
		}
		
		function close(select)
		{
			$('ul.selectmenu-content', select).slideUp(options.delay,function(){
				select.removeClass('drops');
			});
		}
	}
})