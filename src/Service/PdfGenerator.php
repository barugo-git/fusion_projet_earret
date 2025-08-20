<?php
// src/Service/PdfGenerator.php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Filesystem\Filesystem;
use setasign\Fpdi\Tcpdf\Fpdi;


class PdfGenerator
{
    private string $uploadDirectory;
    private Filesystem $filesystem;

    public function __construct(string $uploadDirectory, Filesystem $filesystem)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->filesystem = $filesystem;
    }


    public function generateFromTemplate(string $templatePath, array $data): string
    {
        $this->validateTemplate($templatePath);

        try {
            $processedDocxPath = $this->processTemplate($templatePath, $data);
            $htmlContent = $this->convertToHtml($processedDocxPath);
            return $this->generatePdf($htmlContent);
        } catch (\Exception $e) {
            if (isset($processedDocxPath)) {
                $this->filesystem->remove($processedDocxPath);
            }
            throw new \RuntimeException('PDF generation failed: '.$e->getMessage());
        }
    }
    public function createFullyEditablePdf(string $templatePath, array $data): string
    {
        $pdf = new Fpdi();
        
        // Importer chaque page du template
        $pageCount = $pdf->setSourceFile($templatePath);
        
        for ($i = 1; $i <= $pageCount; $i++) {
            $templateId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($templateId);
            
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($templateId);
            
            // Rendre tous les textes éditable
            $this->makeAllTextEditable($pdf, $data, $i);
        }
        
        return $pdf->Output('', 'S');
    }

    private function makeAllTextEditable(Fpdi $pdf, array $data, int $pageNum): void
    {
        $pdf->SetFont('helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 255); // Texte en bleu pour indiquer l'édition
        
        // Coordonnées approximatives - à adapter selon votre template
        $editableAreas = [
            ['x' => 30, 'y' => 50, 'w' => 150, 'h' => 10, 'field' => 'titre'],
            ['x' => 30, 'y' => 70, 'w' => 150, 'h' => 8, 'field' => 'contenu'],
            // Ajoutez toutes les zones éditables...
        ];
        
        foreach ($editableAreas as $area) {
            $fieldName = $area['field'];
            $value = $data[$fieldName] ?? '';
            
            $pdf->SetXY($area['x'], $area['y']);
            $pdf->TextField(
                $fieldName,
                $area['w'],
                $area['h'],
                [
                    'value' => $value,
                    'border' => 1,
                    'borderColor' => [0, 0, 255],
                    'backgroundColor' => [255, 255, 255],
                    'textColor' => [0, 0, 0]
                ]
            );
        }
    }















    // Ajoutez cette nouvelle méthode
    public function generateEditablePdf(string $templatePath, array $data): string
    {
        // 1. Générer le PDF de base
        $basePdf = $this->generateFromTemplate($templatePath, $data);
        
        // 2. Créer un fichier temporaire
        $tempFile = tempnam(sys_get_temp_dir(), 'editable_').'.pdf';
        file_put_contents($tempFile, $basePdf);
        
        // 3. Initialiser FPDI
        $pdf = new Fpdi();
        
        try {
            // Importer le PDF généré
            $pageCount = $pdf->setSourceFile($tempFile);
            
            for ($i = 1; $i <= $pageCount; $i++) {
                $templateId = $pdf->importPage($i);
                $size = $pdf->getTemplateSize($templateId);
                
                $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $pdf->useTemplate($templateId);
                
                $this->addEditableFields($pdf, $data, $i);
            }
            
            return $pdf->Output('', 'S');
        } finally {
            // Nettoyer le fichier temporaire
            if (file_exists($tempFile)) {
                unlink($tempFile);
            }
        }
    }

    private function addEditableFields(Fpdi $pdf, array $data, int $pageNum): void
    {
        $pdf->SetFont('helvetica', '', 10);
        $y = 30; // Position verticale initiale
        
        foreach ($data as $key => $value) {
            // Style des champs modifiables
            $pdf->SetXY(20, $y);
            $pdf->SetTextColor(0, 0, 255); // Texte bleu
            $pdf->Cell(40, 8, ucfirst(str_replace('_', ' ', $key)).':');
            
            $pdf->TextField($key, 100, 8, [
                'value' => $this->sanitizeValue($value),
                'border' => 1,
                'borderColor' => [0, 0, 255], // Bordure bleue
                'backgroundColor' => [230, 240, 255] // Fond bleu clair
            ]);
            
            $y += 20; // Espacement vertical
        }
    }

    public function generateEditablePreview(string $templatePath, array $data): string
    {
        // 1. Générer le PDF de base
        $basePdf = $this->generateFromTemplate($templatePath, $data);
        
        // 2. Créer un PDF éditable
        $pdf = new Fpdi();
        
        // Importer le PDF généré via un flux mémoire
        $pageCount = $pdf->setSourceFile('data://application/pdf;base64,' . base64_encode($basePdf));
        
        for ($i = 1; $i <= $pageCount; $i++) {
            $tplId = $pdf->importPage($i);
            $size = $pdf->getTemplateSize($tplId);
            
            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
            
            $this->addPreviewFields($pdf, $data, $i);
        }
        
        return $pdf->Output('', 'S');
    }

    private function addPreviewFields(Fpdi $pdf, array $data, int $pageNum): void
    {
        $pdf->SetFont('helvetica', '', 10);
        $y = 30;
        
        foreach ($data as $key => $value) {
            if ($pageNum === 1 && $y > 250) break;
            
            // Style des champs de prévisualisation
            $pdf->SetXY(20, $y);
            $pdf->SetFillColor(230, 240, 255); // Fond bleu clair
            $pdf->Cell(100, 8, $this->sanitizeValue($value), 1, 0, 'L', true);
            
            // Indicateur [MODIFIABLE]
            $pdf->SetXY(125, $y);
            $pdf->SetTextColor(0, 0, 255);
            $pdf->Cell(30, 8, '[MODIFIABLE]');
            
            $y += 15;
        }
    }

    private function validateTemplate(string $templatePath): void
    {
        if (!$this->filesystem->exists($templatePath)) {
            throw new \RuntimeException("Template file not found: ".$templatePath);
        }

        if (strtolower(pathinfo($templatePath, PATHINFO_EXTENSION)) !== 'docx') {
            throw new \RuntimeException("Only .docx files are supported");
        }
    }

    private function processTemplate(string $templatePath, array $data): string
    {
        $tempFilename = tempnam(sys_get_temp_dir(), 'docx_').'.docx';
        
        try {
            $templateProcessor = new TemplateProcessor($templatePath);
            
            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $this->sanitizeValue($value));
            }
            
            $templateProcessor->saveAs($tempFilename);
            
            return $tempFilename;
            
        } catch (\Exception $e) {
            if (file_exists($tempFilename)) {
                $this->filesystem->remove($tempFilename);
            }
            throw $e;
        }
    }

    private function convertToHtml(string $docxPath): string
    {
        try {
            $phpWord = IOFactory::load($docxPath);
            $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
            
            ob_start();
            $htmlWriter->save('php://output');
            $htmlContent = ob_get_clean();
            
            return $this->cleanHtml($htmlContent);
            
        } finally {
            $this->filesystem->remove($docxPath);
        }
    }

    private function cleanHtml(string $html): string
    {
        // Basic cleaning
        $html = preg_replace('/<(!DOCTYPE|meta|link|title)[^>]*>/i', '', $html);
        $html = preg_replace('/<head[^>]*>.*<\/head>/is', '', $html);
        $html = preg_replace('/<style[^>]*>.*<\/style>/is', '', $html);
        
        // XML entity handling
        $html = htmlspecialchars_decode($html);
        $html = preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $html);
        
        // Ensure proper structure
        return '<!DOCTYPE html>
                <html>
                <head>
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                    <style>body { font-family: DejaVu Sans, sans-serif; }</style>
                </head>
                <body>'.trim($html).'</body>
                </html>';
    }

    private function generatePdf(string $htmlContent): string
    {
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('isPhpEnabled', true);
        $options->set('defaultPaperSize', 'A4');
        $options->set('defaultPaperOrientation', 'portrait');
        
        $dompdf = new Dompdf($options);
        
        // Error suppression for malformed HTML warnings
        @$dompdf->loadHtml($htmlContent, 'UTF-8');
        $dompdf->render();
        
        return $dompdf->output();
    }

    private function sanitizeValue($value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('d/m/Y');
        }
        if (is_bool($value)) {
            return $value ? 'Oui' : 'Non';
        }
        if (is_array($value)) {
            return implode(', ', array_map([$this, 'sanitizeValue'], $value));
        }
        
        // Special character handling
        $value = str_replace(
            ['&', '<', '>', '"', "'"],
            ['&amp;', '&lt;', '&gt;', '&quot;', '&apos;'],
            (string)$value
        );
        
        return $value;
    }
}