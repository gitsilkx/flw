$(document).ready(function() {

    $('.contractor_epitome').each(function() {
        var element = $(this);
        var portrait = element.attr('data-portrait');
        var key = decodeURIComponent(element.attr('data-key')).split('~~')[1];
        var uid = element.attr('user-id'); 
        if (uid && $('div#contractor-epitome-content-' + uid).length) {
        	var content = $('div#contractor-epitome-content-' + uid).html();
        	var options = {
	            hoverIntentOpts: {
	                interval: 100,
	                timeout: 0
	            },
	            width: 350,
	            strokeStyle: '#406298',
	            fill: '#fff',
	            spikeLength: 10,
	            shadow: true,
	            shadowOffsetX: 4,
	            shadowOffsetY: 4,
	            shadowBlur: 4,
	            shadowColor: 'rgba(0,0,0,.7)',
	            vertical: 30
	         };
        	if(element.is('img')) {
	            options.overlap = 0;
	        } else {
	            options.atMouse = true;
	        }
	        element.obt(content, options);
        } else {
	        var options = {
	            ajaxPath: '/users/epitome/key/' + key + '/portrait/' + portrait,
	            hoverIntentOpts: {
	                interval: 100,
	                timeout: 0
	            },
	            ajaxPrefetchOffset: 650,
	            width: 350,
	            strokeStyle: '#406298',
	            fill: '#fff',
	            spikeLength: 10,
	            shadow: true,
	            shadowOffsetX: 4,
	            shadowOffsetY: 4,
	            shadowBlur: 4,
	            shadowColor: 'rgba(0,0,0,.7)',
	            vertical: 30,
	            ajaxLoading: '',
	            ajaxError: ''
	        };
        
	        if(element.is('img')) {
	            options.overlap = 0;
	        } else {
	            options.atMouse = true;
	        }
	        element.obt(options);
	        if(element.is('a')) {
	            element.mouseover(function() {
	                element.css('border-bottom', 'dashed ' + (element.css('font-weight') == 'bold' ? '2px' : '1px') + ' ' + element.css('color'));
	            }).mouseout(function() {
	                element.css('border-bottom', 'none');
	                //element.css('border-bottom', 'dotted ' + (element.css('font-weight') == 'bold' ? '2px' : '1px') + ' ' + element.css('color'));
	            }).mouseout();
	        }
        }
    });
    
});