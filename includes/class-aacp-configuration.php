<?php

class aacp_Configuration {

	public function cron_add_every_minute_interval( $schedules ) {
		$schedules['everyminute'] = array(
		    'interval' => 60,
		    'display' => __( 'Once Every Minute' )
		);
		return $schedules;
	}
}

?>