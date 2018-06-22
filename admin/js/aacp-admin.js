(function( $ ) {
	//'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$('.nav-tab-wrapper').on('click', '.nav-tab-ical-sync', function(){
		$('.nav-tab-ical-sync').addClass('nav-tab-active');
		$('.tab-ical-sync').removeClass('hidden');
		
		$('.nav-tab-file-exports').removeClass('nav-tab-active');
		$('.tab-file-exports').addClass('hidden');
		
		$('.nav-tab-podcast-file-validation').removeClass('nav-tab-active');
		$('.tab-podcast-file-validation').addClass('hidden');
		
		$('.nav-tab-online-newsletter').removeClass('nav-tab-active');
		$('.tab-online-newsletter').addClass('hidden');
		
		return false;
	});
	
	$('.nav-tab-wrapper').on('click', '.nav-tab-file-exports', function(){
		$('.nav-tab-file-exports').addClass('nav-tab-active');
		$('.tab-file-exports').removeClass('hidden');
		
		$('.nav-tab-ical-sync').removeClass('nav-tab-active');
		$('.tab-ical-sync').addClass('hidden');
		
		$('.nav-tab-podcast-file-validation').removeClass('nav-tab-active');
		$('.tab-podcast-file-validation').addClass('hidden');
		
		$('.nav-tab-online-newsletter').removeClass('nav-tab-active');
		$('.tab-online-newsletter').addClass('hidden');
	
		return false;
	});
	
	$('.nav-tab-wrapper').on('click', '.nav-tab-podcast-file-validation', function(){
		$('.nav-tab-podcast-file-validation').addClass('nav-tab-active');
		$('.tab-podcast-file-validation').removeClass('hidden');
		
		$('.nav-tab-file-exports').removeClass('nav-tab-active');
		$('.tab-file-exports').addClass('hidden');
		
		$('.nav-tab-ical-sync').removeClass('nav-tab-active');
		$('.tab-ical-sync').addClass('hidden');
		
		$('.nav-tab-online-newsletter').removeClass('nav-tab-active');
		$('.tab-online-newsletter').addClass('hidden');
		
		return false;
	});
	
	$('.nav-tab-wrapper').on('click', '.nav-tab-online-newsletter', function(){
		$('.nav-tab-online-newsletter').addClass('nav-tab-active');
		$('.tab-online-newsletter').removeClass('hidden');
		
		$('.nav-tab-file-exports').removeClass('nav-tab-active');
		$('.tab-file-exports').addClass('hidden');
		
		$('.nav-tab-ical-sync').removeClass('nav-tab-active');
		$('.tab-ical-sync').addClass('hidden');
		
		$('.nav-tab-podcast-file-validation').removeClass('nav-tab-active');
		$('.tab-podcast-file-validation').addClass('hidden');
		
		return false;
	});

	$('#export-print-newsletter').click(function(){
		var month = $('#export-print-newsletter').data('month');
		ajaxCall(month);
	});
	
	function ajaxCall(month) {
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {
				'action' : 'newsletterexport',
				'month' : month
			},
            dataType:"json",
    		beforeSend:function(xhr){
    		    $('.export-print-newsletter-response').html('<img src="/wp-admin/images/loading.gif" />'); 
    		},
    		success:function(data){
    			$('.export-print-newsletter-response').html(data[1]);
    			var form  = $('<form method=get action="' + data[0] + '"></form>');
    			$('body').append(form);
            	form.submit(); 
    		},
    		error: function (data) {
    		    alert("Ein Fehler ist aufgetreten.");
    		    $('.export-print-newsletter-response').html("");
            },
            complete: function(data) {
            }
		});
	}

	$('.tab-ical-sync').on('click', '#synchronize-calendar', function(){
		synchronizeCalendar();
	});
	
	function synchronizeCalendar(){
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {
				'action': 'icalsync',
				'synchronize': 'true'
			},
            dataType:"json",
    		beforeSend:function(xhr){
    		    $('.export-status').html('<img src="/wp-admin/images/loading.gif" />');
    		    $('.cache-status').html('<img src="/wp-admin/images/loading.gif" />'); 
    		},
    		success:function(data){
    			$('.export-status').html(data[0]);
    			$('.cache-status').html(data[1]);
    		},
    		error: function (data) {
    		    alert("Ein Fehler ist aufgetreten.");
            },
            complete: function(data) {
            }
		});
	}

})( jQuery );
