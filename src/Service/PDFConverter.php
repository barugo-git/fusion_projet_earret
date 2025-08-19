<?php
// src/Service/PDFConverter.php
namespace App\Service;

use Dompdf\Dompdf;
use PhpOffice\PhpWord\IOFactory;

class PDFConverter
{
    public function convertToPdf(string $docxPath): string
    {
        // Conversion DOCX -> HTML
        $phpWord = IOFactory::load($docxPath);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        
        ob_start();
        $htmlWriter->save('php://output');
        $html = ob_get_clean();

        // Conversion HTML -> PDF
        $dompdf = new Dompdf([
            'defaultFont' => 'DejaVu Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}