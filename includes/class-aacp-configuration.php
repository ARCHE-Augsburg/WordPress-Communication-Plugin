<?php

class aacp_Configuration {

    public function send_smtp_email( $phpmailer ) {
    	$phpmailer->isSMTP();
    	$phpmailer->Host       = SMTP_HOST;
    	$phpmailer->SMTPAuth   = SMTP_AUTH;
    	$phpmailer->Port       = SMTP_PORT;
    	$phpmailer->Username   = SMTP_USER;
    	$phpmailer->Password   = SMTP_PASS;
    	$phpmailer->SMTPSecure = SMTP_SECURE;
    	$phpmailer->From       = SMTP_FROM;
    	$phpmailer->FromName   = SMTP_NAME;
    }
    
	public function cron_add_every_minute_interval( $schedules ) {
		$schedules['everyminute'] = array(
		    'interval' => 60,
		    'display' => __( 'Once Every Minute' )
		);
		return $schedules;
	}
}

?>