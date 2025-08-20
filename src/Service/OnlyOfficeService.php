<?php
// src/Service/OnlyOfficeService.php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class OnlyOfficeService
{

    private string $documentServerUrl;
    private string $secretKey;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(
        string $documentServerUrl,
        string $secretKey,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->documentServerUrl = rtrim($documentServerUrl, '/');
        $this->secretKey = $secretKey;
        $this->urlGenerator = $urlGenerator;
    }

    public function openDocumentInEditor(
        string $filePath,
        string $fileName,
        int $rapportId,
        string $callbackUrl
    ): RedirectResponse {
        // Vérification que le fichier existe
        if (!file_exists($filePath)) {
            throw new \RuntimeException('File not found: '.$filePath);
        }
    
        // Génération de l'URL de téléchargement
        $fileUrl = $this->urlGenerator->generate(
            'app_file_download',
            ['filePath' => basename($filePath)],
            UrlGeneratorInterface::ABSOLUTE_URL
        );
    
        // Configuration pour OnlyOffice
        $config = [
            'document' => [
                'fileType' => 'docx',
                'key' => md5($rapportId.time()), // Clé unique
                'title' => $fileName,
                'url' => $fileUrl,
            ],
            'editorConfig' => [
                'callbackUrl' => $callbackUrl,
                'mode' => 'edit',
            ],
            'token' => $this->generateToken($rapportId, $filePath),
        ];
    
        // Construction de l'URL OnlyOffice
        $onlyOfficeUrl = $this->documentServerUrl.'/editors?config='.urlencode(json_encode($config));
    
        return new RedirectResponse($onlyOfficeUrl);
    }

    private function generateToken(int $rapportId, string $filePath): string
    {
        if (empty($this->secretKey)) {
            throw new \RuntimeException('Secret key is not configured for OnlyOfficeService');
        }

        $payload = [
            'rapportId' => $rapportId,
            'filePath' => $filePath,
            'iat' => time(),
            'exp' => time() + 3600 // Expire dans 1 heure
        ];

        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        $payload = json_encode($payload);

        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secretKey, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

}