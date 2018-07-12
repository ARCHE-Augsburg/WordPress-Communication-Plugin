<?php

class aacp_FileRenderer {
	
	private $defaultTextColor;
	private $dateTimeSpanColor;
	private $defaultFont;

	public function __construct (){
		$this->defaultTextColor = "7d7d7d";
		$this->dateTimeSpanColor = "555555";
		$this->defaultFont = "'Helvetica Neue";
	}

	public function render_newsletter( $events_to_print, $file_name, $export_date_info ) {
		
		require_once __DIR__ . '/../../vendor/autoload.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$text = $export_date_info['month_word'] . " " . $export_date_info['year'];

		$boldFontStyleName = 'BoldText';
		$phpWord->addFontStyle($boldFontStyleName, 
			array(
				'bold' => true, 
				'name' => $this->defaultFont, 
				'color' => 'darkGray', 
				'size' => 15
			)
		);

		$terminDateFontStyleName = 'terminDate';
		$phpWord->addFontStyle($terminDateFontStyleName, 
			array(
				'name' => $this->defaultFont, 
				'bgColor' => $this->dateTimeSpanColor, 
				'color' => 'white', 
				'size' => 11,
			)
		);

		$terminHeaderFontStyleName = 'terminHeader';
		$phpWord->addFontStyle($terminHeaderFontStyleName, 
			array(
				'bold' => true, 
				'name' => $this->defaultFont, 
				'color' => $this->defaultTextColor, 
				'size' => 13
			)
		);

		$terminTextFontStyleName = 'terminText';
		$phpWord->addFontStyle($terminTextFontStyleName, 
			array(
				'name' => $this->defaultFont, 
				'color' => $this->defaultTextColor, 
				'size' => 10
			)
		);

		$rightParagraph = 'RightParagraph';
		$phpWord->addParagraphStyle($rightParagraph, 
			array(
				'align' => 'right', 
				'spaceAfter' => 1000
			)
		);

		$terminTextParagraph = 'terminTextParagraph';
		$phpWord->addParagraphStyle($terminTextParagraph, array('align'=>'both', 'spaceAfter'=>50));
		// New portrait section
		$section = $phpWord->addSection(
			array('marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
				'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
				'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
				'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5))
			);
		$section->addText($text, $boldFontStyleName, $rightParagraph);

		$table = $section->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
			'cellMarginBottom' => 200));

		foreach($events_to_print as $event) {
			$table->addRow();
			$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(7))->addImage($event['image']['path'], array(
				'width'            => \PhpOffice\PhpWord\Shared\Converter::cmToPixel(5.5),
				'posHorizontal'    => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER,
				'alignment'        => \PhpOffice\PhpWord\SimpleType\Jc::CENTER
				));
			$cell = $table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(13));
			$cell->addText($event['date'], $terminDateFontStyleName);
			$cell->addText($event['post_title'], $terminHeaderFontStyleName);
			$cell->addText($event['content'], $terminTextFontStyleName, $terminTextParagraph);
		}

		// Saving the document as OOXML file...
		$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
		$objWriter->save($file_name);		
	}
}

?>