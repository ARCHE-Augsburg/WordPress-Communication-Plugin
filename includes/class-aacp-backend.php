<?php

/**
 * The file that defines the backend
 *
 * A class definition that provides the backend ui of the plugin
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * The backend class.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class aacp_Backend {

	public function get_aacp_backend() {
	    // The menu shall be shown to users in role 'editor' and 'administrator'.
	    // I don't know how to manage this other than using this capability, which
	    // is used for both roles.
	    $capability = 'moderate_comments'; 
        add_menu_page('AACP Settings', 'AACP Settings', $capability, 'aacp-settings', array($this, 'aacp_settings_page'), 'dashicons-update');
	}
    
    public function aacp_settings_page() { 
        include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/aacp-admin-display.php';
    }
    
    public function exportPrintNewsletter() {
        // Month of the newsletter
        $month;
        if( ! empty( $_POST['month'] ) &&  $_POST['month'] != '') {
            $month= $_POST['month'];
        }
        $fileExporter = new aacp_FileExporter();
        $exportPath = $fileExporter->exportNewsletter( $month );
        $response = $exportPath;
        echo json_encode( $response );
        wp_die();
    }
    
    public function synchronizeCalendar(){
        $synchronizer = new aacp_IcalSynchronizer();
        $synchronizer->synchronize();
        $response = array();
        $response[] = $synchronizer->evaluateLogFile();
        $response[] = $synchronizer->evaluateCacheFiles();
        echo json_encode($response);
        wp_die();
    }
}
