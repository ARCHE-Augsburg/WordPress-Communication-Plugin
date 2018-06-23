<?php

class aacp_MailchimpIntegration {
    
    public function upload_image_to_mailchimp( $ID, $post ) {
        if ( !$this->are_mailchimp_constants_defined() ) {
            return;
        }
        
        $image = $this->get_image( $ID );
        
        if ( !count($image) > 0 ) {
            return;
        }
        
        $image_encoded = $this->encode_file_base64( $image['path'] );
        $this->upload( $image['file_name'], $image_encoded );
    }
    
    private function get_image( $post_id ) {
        $image_to_upload = array();
        
        if ( rwmb_meta( 'aa_event_gx' , null, $post_id ) != "") {
			
			$args = array('size' => "large", 'type' => 'image');
			$images = rwmb_meta( 'aa_event_gx', $args, $post_id );
			
			if ( count($images) > 0 ) {
				$image_to_upload['path'] = reset($images)['path'];
				$image_to_upload['file_name'] = reset($images)['file'];
			}
		}
		
		return $image_to_upload;
    }
    
    private function encode_file_base64 ( $file_path ){
        $encoded_data = chunk_split( base64_encode( file_get_contents( $file_path ) ) );
        return $encoded_data;
    }
    
    private function upload( $file_name, $image_data ) {
        $data = array (
            'name'      => $file_name, 
            'file_data' => $image_data,
        );
            
        $json_encoded_data = json_encode($data);
        
        $options = array(
        		CURLOPT_URL => AA_MAILCHIMP_FILEMANAGER_URL,
        		CURLOPT_USERPWD => sprintf("%s:%s", AA_MAILCHIMP_USERNAME, AA_MAILCHIMP_APIKEY),
        		CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        		CURLOPT_POST => true,
        		CURLOPT_HTTPHEADER => array( 'content-type: application/json', 'Content-Length: ' . strlen($json_encoded_data) ),
        		CURLOPT_POSTFIELDS => $json_encoded_data,
        		CURLOPT_RETURNTRANSFER => true,
        );
        
        $curlHandle = curl_init();
        curl_setopt_array($curlHandle, $options);
        $pagecontent = curl_exec($curlHandle);
        $response = curl_getinfo ($curlHandle);
        curl_close($curlHandle);
    }
    
    private function are_mailchimp_constants_defined(){
        $is_active = defined( 'AA_MAILCHIMP_FILEMANAGER_URL') && defined( 'AA_MAILCHIMP_USERNAME') && defined( 'AA_MAILCHIMP_APIKEY');
        return $is_active;
    }
    
    public function get_mailchimp_integration_status() {
        if ( $this->are_mailchimp_constants_defined() ) {
            return AACP_SUCCESS_ICON . "aktiv";
        }
        else {
            return AACP_FAILURE_ICON . " nicht aktiv";
        }
    }
}

?>