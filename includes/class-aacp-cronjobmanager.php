<?php

class aacp_CronJobManger {
    
    public function start_cron_job_podcast_file_validation(){
        $this->schedule_cron_job( 'everyminute', 'podcast_file_validation_job' );
        
        $fileValidator = new aacp_FileValidator();
        add_action ( 'podcast_file_validation_job', array( $fileValidator , 'validate_and_send_email' ) ); 
    }
	
	private function schedule_cron_job($intervall, $jobName){
	    if( !wp_next_scheduled( $jobName ) ) {  
    	   wp_schedule_event( time(), $intervall, $jobName );  
    	}
	}
	
	public function stop_cron_job_podcast_file_validation(){
	    register_deactivation_hook ( __FILE__, array( $this, 'unschedule_cron_job_podcast_file_validation' ) );
	}
	
	public function unschedule_cron_job_podcast_file_validation(){
		$this->unschedule_cron_job('podcast_file_validation_job');
	}
	
    private function unschedule_cron_job($jobName) {
		wp_clear_scheduled_hook($jobName);
	}
	
}

?>