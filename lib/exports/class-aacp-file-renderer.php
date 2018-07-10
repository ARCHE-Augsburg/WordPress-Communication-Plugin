<?php

class aacp_FileRenderer {

	public function render_newsletter( $events_to_print, $file_name ) {
		
		require_once __DIR__ . '/../../vendor/autoload.php';

		$phpWord = new \PhpOffice\PhpWord\PhpWord();
		$text = "Januar 2018";

		$boldFontStyleName = 'BoldText';
		$phpWord->addFontStyle($boldFontStyleName, array('bold' => true, 'name' => 'Helvetica Neue', 'color' => 'darkGray', 'size' => 15));

		$terminDateFontStyleName = 'terminDate';
		$phpWord->addFontStyle($terminDateFontStyleName, array('name' => 'Helvetica Neue', 'bgColor' => 'darkGray', 'color' => 'white', 'size' => 11));

		$terminHeaderFontStyleName = 'terminHeader';
		$phpWord->addFontStyle($terminHeaderFontStyleName, array('bold' => true, 'name' => 'Helvetica Neue', 'color' => 'darkGray', 'size' => 11));

		$terminTextFontStyleName = 'terminText';
		$phpWord->addFontStyle($terminTextFontStyleName, array('name' => 'Helvetica Neue', 'color' => 'darkGray', 'size' => 10));

		$rightParagraph = 'RightParagraph';
		$phpWord->addParagraphStyle($rightParagraph, array('align' => 'right', 'spaceAfter' => 1000));

		$terminTextParagraph = 'terminTextParagraph';
		$phpWord->addParagraphStyle($terminTextParagraph, array('align'=>'both', 'spaceAfter'=>50));
		// New portrait section
		$section = $phpWord->addSection(
			array('marginLeft' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1),
				'marginRight' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
				'marginTop' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5),
				'marginBottom' => \PhpOffice\PhpWord\Shared\Converter::cmToTwip(1.5))
			);
		$section->addText($text, $boldFontStyleName, $rightParagraph);

		$table = $section->addTable(array('alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
			'cellMarginBottom' => 200));

		foreach($events_to_print as $event) {
			$table->addRow();
			$table->addCell(\PhpOffice\PhpWord\Shared\Converter::cmToTwip(5))->addImage($event['image']['path'], array(
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
		$objWriter->save($file_name); //__DIR__ . '/../../../../uploads/aacp-exports/CI-ARCHE.docx');		
	}
	
}

?>