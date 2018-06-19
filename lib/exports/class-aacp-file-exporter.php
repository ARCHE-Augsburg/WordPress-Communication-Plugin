<?php

/**
 * The class responsible for managing file exports.
 *
 * @since      1.0.0
 * @package    ARCHE-Augsburg-Communication-Plugin
 * @subpackage ARCHE-Augsburg-Communication-Plugin/includes
 * @author     
 */
 class aacp_FileExporter {
    
    /**
	 * The Template file.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string            $actions       The template file defining the styles to apply to newsletter export
	 */
	protected $templateFile;
    
    /**
	 * Construct the class
	 * 
	 * Get the template file from the database
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		$this->templateFile = "";

	}
    
    /**
	 * Export the newsletter
	 *
	 * @since    1.0.0
	 * @param    string             $month             The name month of the newsletter to export
	 * @param    string             $templateFile      The template file defining the styles to apply
	 * @returns  string                                  The path to exported file
	 */
	public function export_newsletter ( $month ) {
		 
		 // Parse template file
		 // Get export data
		 //$events = GetEvents();
		 
		 // Generate export file in export-data directory
		 // return the path
		 
		 
		 return get_events ();
		 //return "test";
	}
	
	private function get_events () {
		$events = array();

		$argu = array(
            'post_type' => 'events',
        );

		$my_query = new WP_Query($argu);

    	if($my_query->have_posts()) {
    		while ($my_query->have_posts()) 
    		{
            $the_query->the_post();
            
			$event = array();
            $event['permalink'] = the_permalink();
            $event['post_title'] = get_the_title();
            
            array_push($events, $event);
    		}
    	}
		wp_reset_postdata();
		return $events;
	}
}