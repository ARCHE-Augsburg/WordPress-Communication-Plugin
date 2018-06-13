<?php

class aacp_CronJobManger {
    
    public function startCronJobPodcastFileValidation(){
        $this->scheduleCronJob( 'everyminute', 'podcastFileValidationJob' );
        
        $fileValidator = new aacp_FileValidator();
        add_action ( 'podcastFileValidationJob', array( $fileValidator , 'validateAndSendEmail' ) ); 
    }
	
	private function scheduleCronJob($intervall, $jobName){
	    if( !wp_next_scheduled( $jobName ) ) {  
    	   wp_schedule_event( time(), $intervall, $jobName );  
    	}
	}
	
	public function stopCronJobPodcastFileValidation(){
	    register_deactivation_hook ( __FILE__, array( $this, 'unscheduleCronJobPodcastFileValidation' ) );
	}
	
	public function unscheduleCronJobPodcastFileValidation(){
		unscheduleCronJob('podcastFileValidationJob');
	}
	
    private function unscheduleCronJob($jobName) {
		$timestamp = wp_next_scheduled ($jobName);
		wp_unschedule_event ($timestamp, $jobName);
	}
	
	function cronAddMinute( $schedules ) {
		// Adds once every minute to the existing schedules.
		$schedules['everyminute'] = array(
		    'interval' => 60,
		    'display' => __( 'Once Every Minute' )
		);
		return $schedules;
	}
}

?>