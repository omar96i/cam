<?php  
	
	defined('BASEPATH') OR exit('No direct script access allowed');

	require_once 'dompdf/autoload.inc.php';

	use Dompdf\Dompdf;

	class Pdfgenerator {

		public function generate($html, $stream = TRUE , $filename='', $paper = 'A4', $orientation = "portrait")
		{
			$dompdf = new DOMPDF();
			$dompdf->loadHtml($html);
			$dompdf->setPaper($paper, $orientation);

			$dompdf->render();
			if($stream) {
				$dompdf->stream($filename.".pdf", array("Attachment" =>	FALSE));
			} 
			else {
				return file_put_contents('./assets/uploads/' . $filename . '.pdf', $dompdf->output());
			}
			
		}

	}
	?>