<?php

class aacp_OwncloudAdapter {
    
    private $username;
    private $password;
    private $server;
    
    private function are_owncloud_constants_defined(){
        $is_active = defined( 'AA_OWNCLOUD_USERNAME') && defined( 'AA_OWNCLOUD_PASSWORD') && defined( 'AA_OWNCLOUD_SERVER');
        return $is_active;
    }
    
    public function get_configuration_status() {
        if ( $this->are_owncloud_constants_defined() ) {
            return AACP_SUCCESS_ICON . "aktiv";
        }
        else {
            return AACP_FAILURE_ICON . " nicht aktiv";
        }
    }
    
    private function initialize() {
        $this->server = AA_OWNCLOUD_SERVER;
        $this->username = AA_OWNCLOUD_USERNAME;
        $this->password = AA_OWNCLOUD_PASSWORD;
    }
    
    public function upload_file( $file, $owncloud_directory ) {
        if ($this->are_owncloud_constants_defined()) {
            $this->initialize();
            
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, 'https://' . $this->server . '/remote.php/webdav/' . $owncloud_directory . '/' . basename($file));
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->password);
            curl_setopt($ch, CURLOPT_PUT, 1);
        
            $fh_res = fopen($file, 'r');
        
            curl_setopt($ch, CURLOPT_INFILE, $fh_res);
            curl_setopt($ch, CURLOPT_INFILESIZE, filesize($file));
        
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE); // --data-binary
        
            $curl_response_res = curl_exec ($ch);
            fclose($fh_res);
        }
    }
}

?>