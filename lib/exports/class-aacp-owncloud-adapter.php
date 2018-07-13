<?php

class aacp_OwncloudAdapter {
    
    private $username;
    private $password;
    private $upload_directory;
    private $server;
    
    public function __construct() {
        $this->server = AA_OWNCLOUD_SERVER;
        $this->username = AA_OWNCLOUD_USERNAME;
        $this->password = AA_OWNCLOUD_PASSWORD;
    }
    
    public function are_owncloud_constants_defined(){
        $is_active = defined( 'AA_OWNCLOUD_USERNAME') && defined( 'AA_OWNCLOUD_PASSWORD') && defined( 'AA_OWNCLOUD_SERVER');
        return $is_active;
    }
    
    public function upload_file( $file, $owncloud_directory ) {
        if ($this->are_owncloud_constants_defined()) {
        
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, 'https://' . $server . '/remote.php/webdav/' . $owncloud_directory . '/' . basename($file));
            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
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