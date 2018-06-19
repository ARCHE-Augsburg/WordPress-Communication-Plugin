<?php

class aacp_FileValidator {

    public function validate_and_get_bad_files() {
        $response;
        $incorrectFiles = array();
        $incorrectFiles = $this->get_incorrect_files();
        
        if(count($incorrectFiles) > 0) {
            foreach($incorrectFiles as $file) {
                $response .= AACP_FAILURE_ICON . $file;
                $response .=  "<br />";
            }
        }
        else {
            $response = AACP_SUCCESS_ICON . "Alle Dateien sind korrekt benannt";
        }
        
        return $response;
    }
 
    private function get_incorrect_files() {
        $sermonDirectory = get_home_path().'../live_podcast/*/*.mp3';
        $sermons = array();
        
        foreach(glob($sermonDirectory) as $file) {
        	
        	$regularExpression = "/\d{4}-\d{2}-\d{2}_.+_.+\.mp3/";
        	if(!preg_match($regularExpression, $file))
        	{
                array_push($sermons, $file);
        	}
        }
        
        return $sermons;
    }
    
    public function validate_and_send_email() {
        $incorrectFiles = array();
        $incorrectFiles = $this->get_incorrect_files();
        
    	$recepients = 'mariusmueller1988@web.de';
    	$subject = 'Hello from your Cron Job';
    	$message = 'This is a test mail sent by WordPress automatically as per your schedule.';
    	 
    	mail($recepients, $subject, $message);
    }
}

?>