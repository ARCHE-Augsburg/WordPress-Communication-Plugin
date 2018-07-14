<?php

class aacp_FileExportManager {
    
	protected $templateFile;
	protected $exports_url;
    protected $exports_path;
    
	public function __construct() {
		$this->template_file = '';
		$this->exports_url = wp_upload_dir()['baseurl'] . '/aacp-exports';
		$this->exports_path = wp_upload_dir()['basedir'] . '/aacp-exports';
	}
    
    public function export_print_newsletter() {
        // Month of the newsletter to be exported
        $month = $_POST['month'];
        $event_ids = $_POST['post_ids'];
        $response = array();
        $export_file_url = $this->export_newsletter( $event_ids );
        $html_response = 'Wenn der Download nicht automatisch startet, <a target="_blank" href="' . $export_file_url . '">hier klicken</a>.';
        $response[] = $export_file_url;
        $response[] = $html_response;
        echo json_encode( $response );
        wp_die();
    }
    
	private function export_newsletter ( $event_ids ) {
		$this->clear_export_folder();
		 $events = $this->query_events_for_export( $event_ids );
		 $export_date_info = $this->get_month_of_export_newsletter();
		 $file_name = date('Y-m-d-His') . "_ARCHE-Termine-print_" . $export_date_info['month_word'] . "-" . $export_date_info['year'] . ".docx";
		 $file_full_url = $this->exports_url . '/' . $file_name;
		 $file_full_path = $this->exports_path . '/' . $file_name;
		 $file_renderer = new aacp_NewsletterRenderer();
		 $file_renderer->render_newsletter( $events, $file_full_path, $export_date_info );
		 $owncloud_dapter = new aacp_OwncloudAdapter();
		 $owncloud_dapter->upload_file( $file_full_path, 'ARCHE%20Öffentlichkeitsarbeit/Newsletter/' . $export_date_info['year'] . '/');
		 return $file_full_url;
	}
	
	private function clear_export_folder() {
		array_map('unlink', glob($this->exports_path ."/*"));
	}
	
	private function query_events_for_export( $event_ids ) {
		$events = array();
		
		$argu = array(
            'post_type' => 'events',
            'orderby' => 'meta_value_num', 
            'meta_key'=> 'aa_event_start_datetime',
            'order' => 'ASC',
            'post__in' => $event_ids
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
	
	public function query_events_for_selection ( $month ) {
		$events = array();
		$start_date = $this->get_start_date( $month );
		
		$meta_query = array(
				'relation' => 'AND',
				array(
					'key'     => 'aa_event_publishing_start_datetime',
					'value'   => strtotime( $start_date ),
					'compare' => '<'
				),
				array(
					'key'     => 'aa_event_end_datetime',
					'value'   => strtotime( $start_date ),
					'compare' => '>'
				),
			);
		
		$argu = array(
            'post_type' => 'events',
            'meta_query' => $meta_query,
            'orderby' => 'meta_value_num', 
            'meta_key'=> 'aa_event_start_datetime',
            'order' => 'ASC',
			'tax_query' => array(
				array(
			        'taxonomy' => 'Werbekanäle',
			        'field' => 'slug',
			        'terms' => 'arche-termine-print',
			    ),
			)
        );

		$query = new WP_Query($argu);

    	if( $query->have_posts() ) {
    		while ( $query->have_posts() ) 
    		{
	            $query->the_post();
	        	$event = $this->get_event();
	        	
	        	if( !empty( $event['image'] ) && $event['content'] != "" ) {
	            	array_push( $events, $event );
	        	}
    		}
    	}
		wp_reset_postdata();
		
		return $events;
	}
	
	private function get_start_date( $month ) {
		return date('Y') . '-' . $month['number'] . '-1';
	}
	
	private function get_event() {
		$event = array();
		
        $event['permalink'] = get_the_permalink();
        $event['post_title'] = get_the_title();
        $event['image'] = $this->get_event_image();
        $event['content'] = $this->get_event_content();
        $event['date'] = $this->get_datetime_string();
        $event['post_id'] = get_the_id();
        
        return $event;
	}
	
	private function get_event_content() {
		$text = "";
		if ( rwmb_meta( 'aa_event_text_alternative' , null, $post->ID  ) != "") {
			$text = rwmb_meta( 'aa_event_text_alternative' , null, $post->ID );
		}
		return $text;
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
		$month_to_word = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 
			5=>"Mai", 6=>"Juni", 7=>"Juli", 8=>"August",  9=>"September", 
			10=>"Oktober", 11=>"November", 12=>"Dezember");
                
		$actual_month = date( 'n' );
		$actual_day = date( 'j' );
		$actual_year = date( 'Y' );
		
		$export_date_info = array();
		
		// If we are after the mid of a month, export the newsletter
		// for the next month
		if ( $actual_day > 15 ) {
			if ( $actual_month == 12 ) {
				$export_month_number = 1;
				$export_year_number = $actual_year + 1;
			} else {
		    	$export_month_number = $actual_month + 1;
		    	$export_year_number = $actual_year;
			}
		}
		else {
		    $export_month_number = $actual_month;
		    $export_year_number = $actual_year;
		}
		
		$export_date_info['month_number'] = $export_month_number;
		$export_date_info['month_word'] = $month_to_word[$export_month_number];
		$export_date_info['year'] = $export_year_number;
		
		return $export_date_info;
	}
	
	public function export_service_presentation() {
		$owncloud_adapter = new aacp_OwncloudAdapter();
		$owncloud_adapter->upload_service_presentation_export();
	}
}