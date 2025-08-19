<?php
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;

class FileUploader
{
    private array $uploadPaths;
    private LoggerInterface $logger;

    public function __construct(
        string $uploadDirectory,
        string $uploadModels,
        string $uploadRapports,
        string $uploadPieceJointes,
        string $uploadConsignation,
        string $uploadCalendrier,
        LoggerInterface $logger
    ) {
        $this->uploadPaths = [
            'models' => $uploadModels,
            'rapports' => $uploadRapports,
            'piecesJointes' => $uploadPieceJointes, 
            'consignations' => $uploadConsignation,
            'calendrier' => $uploadCalendrier,      
            'default' => $uploadDirectory
        ];
        $this->logger = $logger;
    }

    public function upload(UploadedFile $file, $param1 = null, $param2 = null): string
    {
        // Gestion des deux signatures d'appel :
        // 1. upload($file, 'subfolder')
        // 2. upload($file, $filename, 'subfolder')
        
        if ($param2 === null) {
            $subFolder = $param1;
            $customFilename = null;
        } else {
            $subFolder = $param2;
            $customFilename = $param1;
        }

        if (!array_key_exists($subFolder, $this->uploadPaths)) {
            throw new \InvalidArgumentException("Dossier de destination invalide: $subFolder");
        }

        $targetDir = $this->uploadPaths[$subFolder];

        try {
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }

            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeName = $customFilename ?? preg_replace('/[^a-zA-Z0-9-_]/', '', $originalName);
            $fileName = $safeName.'-'.uniqid().'.'.$file->guessExtension();

            $file->move($targetDir, $fileName);

            return $subFolder.'/'.$fileName;

        } catch (FileException $e) {
            $this->logger->error('Erreur upload fichier', [
                'error' => $e->getMessage(),
                'folder' => $subFolder,
                'file' => $file->getClientOriginalName()
            ]);
            throw new \RuntimeException("Échec de l'upload du fichier");
        }
    }

    public function removeFile(string $filePath): bool
    {
        foreach ($this->uploadPaths as $path) {
            $absolutePath = $path.'/'.$filePath;
            if (file_exists($absolutePath)) {
                return unlink($absolutePath);
            }
        }
        return false;
    }

    public function getUploadDirectory(string $type = 'default'): string
    {
        if (!array_key_exists($type, $this->uploadPaths)) {
            throw new \InvalidArgumentException("Type de dossier inconnu: $type");
        }
        return $this->uploadPaths[$type];
    }
}