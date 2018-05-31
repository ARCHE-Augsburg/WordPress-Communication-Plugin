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
		$('.tab-ical-sync').removeClass('hidden');
		$('.tab-file-exports').addClass('hidden');
		$('.nav-tab-ical-sync').addClass('nav-tab-active');
		$('.nav-tab-file-exports').removeClass('nav-tab-active');
		return false;
	});
	
	$('.nav-tab-wrapper').on('click', '.nav-tab-file-exports', function(){
		$('.tab-ical-sync').addClass('hidden');
		$('.tab-file-exports').removeClass('hidden');
		$('.nav-tab-ical-sync').removeClass('nav-tab-active');
		$('.nav-tab-file-exports').addClass('nav-tab-active');
		return false;
	});

	$('#export-print-newsletter').click(function(){
		ajaxCall();
	});
	
	function ajaxCall() {
		$.ajax({
			url: ajaxurl,
			data: {
				'action' : 'newsletterexport',
				'month' : 3
			},
    		beforeSend:function(xhr){
    		    $('.sync-status').html('<img src="/wp-admin/images/loading.gif" />'); 
    		},
    		success:function(data){
    			$('.export-print-newsletter-response').html(data);
    		},
    		error: function (data) {
    		    alert("Ein Fehler ist aufgetreten.");
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
			data: {
				'action': 'icalsync',
				'synchronize': 'true'
			},
    		beforeSend:function(xhr){
    		    $('.sync-status').html('<img src="/wp-admin/images/loading.gif" />');  
    		},
    		success:function(data){
    			$('.sync-status').html(data);
    			console.log(data);
    		},
    		error: function (data) {
    		    alert("Ein Fehler ist aufgetreten.");
            },
            complete: function(data) {
            }
		});
		
		//location.reload(true);
	}

})( jQuery );
