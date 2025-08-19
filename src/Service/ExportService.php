<?php

// src/Service/ExportService.php
namespace App\Service;

use Symfony\Component\HttpFoundation\Response;

class ExportService
{
    public function exportToCsv(array $data, string $filename): Response
    {
        $csv = "";
        
        // Entêtes
        if (!empty($data)) {
            $csv .= implode(";", array_keys($data[0]))."\n";
        }
        
        // Données
        foreach ($data as $row) {
            $csv .= implode(";", array_map(function ($value) {
                return '"'.str_replace('"', '""', $value).'"';
            }, $row))."\n";
        }
        
        $response = new Response($csv);
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', sprintf('attachment; filename="%s"', $filename));
        
        return $response;
    }
}