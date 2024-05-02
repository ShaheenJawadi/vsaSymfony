<?php

namespace App\Services;
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    private $domPdf;

    public function __construct()
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Garamond');
        $pdfOptions->set('isRemoteEnabled', TRUE);  

        $this->domPdf = new Dompdf($pdfOptions); 
    }

    public function showPdfFile($html) {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        $this->domPdf->stream("details.pdf", [
            'Attachement' => true
        ]);
    }

    public function generateBinaryPDF($html): string {
        $this->domPdf->loadHtml($html);
        $this->domPdf->render();
        return $this->domPdf->output(); 
    }
}