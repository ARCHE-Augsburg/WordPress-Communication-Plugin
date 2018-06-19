<?php

class aacp_Ajax {
    
     public function export_print_newsletter() {
        // Month of the newsletter
        $month;
        if( !empty( $_POST['month'] ) && $_POST['month'] != '') {
            $month = $_POST['month'];
        }
        $fileExporter = new aacp_FileExporter();
        $exportPath = $fileExporter->export_newsletter( $month );
        $response = $exportPath;
        echo json_encode( $response );
        wp_die();
    }
    
    public function synchronize_calendar(){
        $synchronizer = new aacp_IcalSynchronizer();
        $synchronizer->synchronize();
        $response = array();
        $response[] = $synchronizer->evaluate_log_file();
        $response[] = $synchronizer->evaluate_cache_files();
        echo json_encode($response);
        wp_die();
    }
}

?>