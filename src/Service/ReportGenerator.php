<?php
// src/Service/ReportGenerator.php

namespace App\Service;

use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Filesystem\Filesystem;

class ReportGenerator
{
    private string $uploadDirectory;
    private Filesystem $filesystem;

    public function __construct(string $uploadDirectory, Filesystem $filesystem)
    {
        $this->uploadDirectory = $uploadDirectory;
        $this->filesystem = $filesystem;
    }

    public function genererRapport(string $templatePath, array $data, string $outputPrefix): string
    {
        // Vérification du template
        if (!$this->filesystem->exists($templatePath)) {
            throw new \RuntimeException("Le fichier modèle n'existe pas: ".$templatePath);
        }

        try {
            // Création du répertoire de sortie s'il n'existe pas
            $outputDir = $this->uploadDirectory.'/rapports';
            $this->filesystem->mkdir($outputDir);

            // Génération du nom de fichier
            $filename = sprintf('%s_%s.docx', 
                $outputPrefix, 
                date('Ymd_His')
            );
            $outputPath = $outputDir.'/'.$filename;

            // Traitement du template
            $templateProcessor = new TemplateProcessor($templatePath);

            foreach ($data as $key => $value) {
                $templateProcessor->setValue($key, $this->sanitizeValue($value));
            }

            $templateProcessor->saveAs($outputPath);

            if (!$this->filesystem->exists($outputPath)) {
                throw new \RuntimeException('Échec de la génération du fichier');
            }

            return 'rapports/'.$filename; // Retourne le chemin relatif
        } catch (\Exception $e) {
            throw new \RuntimeException('Erreur lors de la génération: '.$e->getMessage());
        }
    }

    private function sanitizeValue($value): string
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format('d/m/Y');
        }
        return (string)$value;
    }

    public function generateTemporaryDocument(string $templatePath, array $data, string $outputFilename): string
    {
        $templateProcessor = new TemplateProcessor($templatePath);
        
        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value ?? '');
        }
        
        $tempDir = sys_get_temp_dir().'/onlyoffice';
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }
        
        $tempPath = $tempDir.'/'.$outputFilename.'.docx';
        $templateProcessor->saveAs($tempPath);
        
        return $tempPath;
    }
}