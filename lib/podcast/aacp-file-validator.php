<?php

class aacp_FileValidator {

    public function validateAndSendEmail() {
        $response;
        $incorrectFiles = array();
        $incorrectFiles = $this->getIncorrectFiles();
        
        if(count($incorrectFiles) > 0) {
            foreach($incorrectFiles as $file) {
                $response .= $file;
                $response .=  "<br />";
            }
        }
        
        return $response;
    }
 
    private function getIncorrectFiles() {
        $sermonDirectory = get_home_path().'../live_podcast/*/*.mp3';
        $sermons = array ();
        
        foreach(glob($sermonDirectory) as $file) {
        	
        	$regularExpression = "/\d{4}-\d{2}-\d{2}_.+_.+\.mp3/";
        	if(!preg_match($regularExpression, $file))
        	{
                array_push($sermons, $file);
        	}
        }
        
        return $sermons;
    }
}

?>