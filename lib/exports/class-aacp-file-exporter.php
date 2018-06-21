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
	protected $template_file;
    
    /**
	 * Construct the class
	 * 
	 * Get the template file from the database
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		$this->template_file = "";

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
		 $events_to_print = $this->get_events( $month );
		 
		 // Generate export file in export-data directory
		 // return the path
		 
		 return "Hier ist der Link zum Export";
	}
	
	private function get_events ( $month ) {
		$events = array();
		
		$argu = array(
            'post_type' => 'events',
        );

		$query = new WP_Query($argu);

    	if($query->have_posts()) {
    		while ($query->have_posts()) 
    		{
	            $query->the_post();
	            
	            $uploads = wp_upload_dir();
	            
				$event = array();
	            $event['permalink'] = get_the_permalink();
	            $event['post_title'] = get_the_title();
	            $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' )[0];
	            $event['image_url'] = $image_url;
	            $event['image_path'] = str_replace( $uploads['baseurl'], $uploads['basedir'], $image_url );
	            $event['content'] = get_the_content();
	            array_push($events, $event);
    		}
    	}
		wp_reset_postdata();
		
		return $events;
	}
}