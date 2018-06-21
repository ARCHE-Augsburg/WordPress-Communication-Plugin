<?php

 class aacp_FileExporter {
    
	protected $templateFile;
    
	public function __construct() {
		
		$this->templateFile = "";

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