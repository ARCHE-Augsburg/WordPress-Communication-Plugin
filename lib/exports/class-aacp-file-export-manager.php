<?php

class aacp_FileExportManager {
    
	protected $templateFile;
	protected $exports_url;
    
	public function __construct() {
		$this->template_file = '';
		$this->exports_url = wp_upload_dir()['baseurl'] . '/aacp-exports';
	}
    
    public function export_print_newsletter() {
        // Month of the newsletter to be exported
        $month = $_POST['month'];
        $response = array();
        $export_file_url = $this->export_newsletter( $month );
        $html_response = 'Wenn der Download nicht automatisch startet, <a target="_blank" href="' . $export_file_url . '">hier klicken</a>.';
        $response[] = $export_file_url;
        $response[] = $html_response;
        echo json_encode( $response );
        wp_die();
    }
    
	private function export_newsletter ( $month ) {
		 $events_to_print = $this->query_events( $month );
		 $file_name = 'CI-ARCHE.docx';
		 $file_full_url = $this->exports_url . '/' . $file_name;
		 $file_renderer = new aacp_FileRenderer();
		 $file_renderer->render_newsletter( $events_to_print, $file_full_url );
		 return $file_full_url;
	}
	
	private function query_events ( $month ) {
		$events = array();
		$start_date = $this->get_start_date( $month );
		
		$argu = array(
            'post_type' => 'events',
            'orderby' => 'meta_value_num', 
            'meta_key'=> 'aa_event_start_datetime',
            'order' => 'ASC',
            'meta_value' => strtotime( $start_date ),
            'meta_compare' => '>',
			'tax_query' => array(
				array(
			        'taxonomy' => 'Anzeigeeinstellungen',
			        'field' => 'slug',
			        'terms' => 'arche-termine-print',
			    ),
			)
        );

		$query = new WP_Query($argu);

    	if($query->have_posts()) {
    		while ($query->have_posts()) 
    		{
	            $query->the_post();
	        	$event = $this->get_event();
	            array_push($events, $event);
    		}
    	}
		wp_reset_postdata();
		
		return $events;
	}
	
	private function get_start_date() {
		// Currently we work with the first day of the month
		return date( 'Y' ) . '-' . $month . '-1';
	}
	
	private function get_event() {
		$event = array();
		
        $event['permalink'] = get_the_permalink();
        $event['post_title'] = get_the_title();
        $event['image'] = $this->get_event_image();
        $event['content'] = get_the_content();
        $event['date'] = $this->get_datetime_string();
        
        return $event;
	}
	
	private function get_event_image() {
		$image = array();
		
		if ( rwmb_meta( 'aa_event_gx' , null, $post->ID  ) != "") {
			$args = array('size' => "large", 'type' => 'image');
			$images = rwmb_meta( 'aa_event_gx', $args, $post->ID  );
			
			if ( count( $images ) > 0 ) {
				$image['path'] = reset($images)['path'];
				$image['url'] = reset($images)['url'];
			}
		}
		
		return $image;
	}
	
	private function get_datetime_string() {
		$start = rwmb_meta('aa_event_start_datetime');
		$end = rwmb_meta('aa_event_end_datetime');
        
        // Start and end date are the same
		if (empty( $end ) || date( 'Ymd', $start ) == date( 'Ymd', $end ) ) 
		{
            $datetime = strftime( '%a, %d. %b', $start );
            $end = $start;
        }
        // Start and end date are different
        else 
        {
            // Same month
            if ( date( 'Ym', $start ) == date( 'Ym', $end ) )
            {
                $datetime = strftime( '%a, %d.', $start ).' - '.strftime( '%a, %d. %b', $end );
            }
            // Different month
            else
            {
                $datetime = strftime( '%a, %d. %b', $start ).' - '.strftime( '%a, %d. %b', $end );
            }
        }
        
        return $datetime;
	}
	
	public function get_month_of_export_newsletter() {
		$month = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 
			5=>"Mai", 6=>"Juni", 7=>"Juli", 8=>"August",  9=>"September", 
			10=>"Oktober", 11=>"November", 12=>"Dezember");
                
		$actual_month = date( 'm' );
		$actual_day = date( 'd' );
		
		$export_month = array();
		
		// If we are after the mid of a month, export the newsletter
		// for the next month
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