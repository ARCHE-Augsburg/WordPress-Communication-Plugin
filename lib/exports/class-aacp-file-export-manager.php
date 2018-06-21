<?php

class aacp_FileExportManager {
    
	protected $templateFile;
    
	public function __construct() {
		$this->template_file = "";
	}
    
    public function export_print_newsletter() {
        // Month of the newsletter to be exported
        $month;
        
        if( !empty( $_POST['month'] ) && $_POST['month'] != '') {
            $month = $_POST['month'];
        }
        
        $response = $this->export_newsletter( $month );
        echo json_encode( $response );
        wp_die();
    }
    
	private function export_newsletter ( $month ) {
		 $events_to_print = $this->get_events( $month );
		 $file_renderer = new aacp_FileRenderer();
		 return $file_renderer->render_newsletter_and_get_url( $events_to_print );
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
	
	public function get_month_of_export_newsletter() {
		$month = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 
			5=>"Mai", 6=>"Juni", 7=>"Juli", 8=>"August",  9=>"September", 
			10=>"Oktober", 11=>"November", 12=>"Dezember");
                
		$actual_month = date( 'm' );
		$actual_day = date( 'd' );
		
		$export_month = array();
		
		if ( $actual_day > 15 ) {
		    $export_month_number = $actual_month + 1;
		}
		else {
		    $export_month_number = $actual_month;
		}
		
		$export_month['number'] = $export_month_number;
		$export_month['word'] = $month[$export_month_number];
		
		return $export_month;
	}
}