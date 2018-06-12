<?php

class aacp_FileValidator {

    public function validateAndSendEmail() {
        $incorrectFiles = getIncorrectFiles();
        
        if(!empty($incorrectFiles)) {
            
        }
    }
 
    private function getIncorrectFiles() {
        $sermonDirectory = get_home_path().'/../live_podcast/*/*.mp3';
        $sermons = [];
        
        foreach(glob($sermonDirectory) as $file) {
        	
        	$regularExpression = "/\d{4}-\d{2}-\d{2}_.+_.+\.mp3/";
        	if(!preg_match($regularExpression, $file))
        	{
                array_push($sermons, $sermon);
        	}
        }
        
        return(rsort($sermons));
    }
}

?>