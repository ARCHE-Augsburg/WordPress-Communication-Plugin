<?php

class aacp_CronJobManger {
    
    public function schedule_cron_job_podcast_file_validation(){
    	$this->schedule_cron_job( 'weekly', 'podcast_file_validation_job' );
    }
    
    public function schedule_cron_job_service_presentation_export() {
    	$this->schedule_cron_job( 'daily', 'presentation_export_job' );
    }
    
	private function schedule_cron_job($intervall, $jobName){
	    if( !wp_next_scheduled( $jobName ) ) {  
    	   wp_schedule_event( time(), $intervall, $jobName );  
    	}
	}
	
	public function unschedule_cron_job_podcast_file_validation(){
		$this->unschedule_cron_job('podcast_file_validation_job');
	}
	
	public function unschedule_cron_job_service_presentation_export() {
		$this->unschedule_cron_job('presentation_export_job');
	}
	
    private function unschedule_cron_job($jobName) {
		wp_clear_scheduled_hook($jobName);
	}
	
}

?>