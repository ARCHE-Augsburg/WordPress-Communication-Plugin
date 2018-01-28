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

    /**
	 * Run the actual synchrinization 
	 *
	 * Calls the script to download ical data from Churchtools
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function get_aacp_backend() {
        add_menu_page('AACP Settings', 'AACP Settings', 'administrator', 'aacp-settings', array($this, 'aacp_settings_page'), 'dashicons-update');
	}
    
    public function aacp_settings_page() { 
        
        $tabs = array ('ical' => 'Ical Sync', 'export' => 'File Exports');
        $current = 'ical';
        
        include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/aacp-admin-display.php';
        
        
    }
    
    public function exportPrintNewsletter() {
        $response = "Rückgabe";
        echo json_encode( $response );
        
        die();
    }
    
}
