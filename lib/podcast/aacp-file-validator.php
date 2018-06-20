<?php

class aacp_FileValidator {

    public function validate_and_get_bad_files() {
        $response;
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
        if ( !defined( 'AA_EMAILADRESSE_PODCAST_VALIDIERUNG' ) ) {
            return;
        }
        
        $incorrectFiles = $this->get_incorrect_files();
        
        if(count($incorrectFiles) > 0) {
            $recepients = AA_EMAILADRESSE_PODCAST_VALIDIERUNG;
    	    $subject = 'Podcast Datei Validierung - ARCHE WP Plugin';
    	    $message = "Einige Dateien sind möglicherweise falsch benannt und werden auf der Homepage nicht angezeigt\r\n";
    	    $message .= "\r\n";
    	    
            foreach($incorrectFiles as $file) {
                $message .= $file . "\r\n";
            }
            
            $message .= "\r\n";
            $message .= "Dies ist eine vom ARCHE Wordpress Plugin automatisch gernerierte Email.";
            mail($recepients, $subject, $message);
        }
    }
}

?>