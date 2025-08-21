<?php
// src/Service/FileUploader.php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;
use Psr\Log\LoggerInterface;

class FileUploader
{
    private array $uploadPaths;
    private LoggerInterface $logger;
    private SluggerInterface $slugger;

    public function __construct(
        string $uploadDirectory,
        string $uploadModels,
        string $uploadRapports,
        string $uploadPieceJointes,
        string $uploadConsignation,
        string $uploadCalendrier,
        LoggerInterface $logger,
        SluggerInterface $slugger
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
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file, ?string $name = null, ?string $folder = 'default'): string
{
    if (!array_key_exists($folder, $this->uploadPaths)) {
        throw new \InvalidArgumentException("Dossier de destination invalide: $folder");
    }

    $targetDir = $this->uploadPaths[$folder];

    try {
        if (!is_dir($targetDir)) {
            if (!mkdir($targetDir, 0775, true) && !is_dir($targetDir)) {
                throw new \RuntimeException("Impossible de créer le dossier: $targetDir");
            }
        }

        // Création du nom de fichier sécurisé
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = $name ? $this->slugger->slug($name) : $this->slugger->slug($originalName);
        $fileName = $safeName . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($targetDir, $fileName);

        // Retourne le chemin relatif accessible depuis public/
        return $fileName;

    } catch (\Throwable $e) { // capture tout
        $this->logger->error('Erreur upload fichier', [
            'error' => $e->getMessage(),
            'folder' => $folder,
            'file' => $file->getClientOriginalName(),
            'targetDir' => $targetDir
        ]);
        throw new \RuntimeException("Échec de l'upload du fichier : " . $e->getMessage());
    }
}
public function removeFile(string $filePath): bool
    {
        foreach ($this->uploadPaths as $path) {
            $absolutePath = $path . '/' . $filePath;
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

    public function slugify(string $text, string $divider = '-'): string
    {
        // Remplace les caractères non alphanumériques par le séparateur
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // Translitération
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // Supprime les caractères indésirables
        $text = preg_replace('~[^-\w]+~', '', $text);

        // Trim
        $text = trim($text, $divider);

        // Supprime les doublons de séparateur
        $text = preg_replace('~-+~', $divider, $text);

        // Minuscule
        $text = strtolower($text);

        return empty($text) ? 'n-a' : $text;
    }
}
