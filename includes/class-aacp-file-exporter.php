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
	public function exportNewsletter ( $month ) {
		 
		 // Parse template file
		 // Get export data
		 // Generate export file in export-data directory
		 // return the path
		 
		 return "test";
	}
     
 }