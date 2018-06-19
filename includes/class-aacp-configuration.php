<?php

class aacp_Configuration {

	public function cron_add_every_minute_interval( $schedules ) {
		$schedules['everyminute'] = array(
		    'interval' => 60,
		    'display' => __( 'Once Every Minute' )
		);
		return $schedules;
	}
	
	function http_basic_cron_request($cron_request) {
		if ( defined( 'WP_CRON_CUSTOM_HTTP_BASIC_USERNAME' ) && defined( 'WP_CRON_CUSTOM_HTTP_BASIC_PASSWORD' ) ) {
			$headers = array('Authorization' => sprintf('Basic %s', base64_encode(WP_CRON_CUSTOM_HTTP_BASIC_USERNAME . ':' . WP_CRON_CUSTOM_HTTP_BASIC_PASSWORD)));
			$cron_request['args']['headers'] = isset($cron_request['args']['headers']) ? array_merge($cron_request['args']['headers'], $headers) : $headers;
			return $cron_request;
		}
	}
	
}

?>