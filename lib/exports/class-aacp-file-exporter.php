<?php

 class aacp_FileExporter {
    
	protected $templateFile;
    
	public function __construct() {
		
		$this->template_file = "";

	}
    
    public function export_print_newsletter() {
        // Month of the newsletter
        $month;
        if( !empty( $_POST['month'] ) && $_POST['month'] != '') {
            $month = $_POST['month'];
        }
        $fileExporter = new aacp_FileExporter();
        $exportPath = $this->export_newsletter( $month );
        $response = $exportPath;
        echo json_encode( $response );
        wp_die();
    }
    
	private function export_newsletter ( $month ) {
		 
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