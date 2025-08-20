<?php

// src/Model/ProfilePhotoUpdate.php
namespace App\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class ProfilePhotoUpdate
{
    /**
     * @Assert\Image(
     *     mimeTypes={"image/jpeg", "image/png", "image/gif"},
     *     mimeTypesMessage="Veuillez uploader une image valide (JPEG, PNG ou GIF)",
     *     maxSize="2M",
     *     maxSizeMessage="L'image ne doit pas dépasser 2Mo"
     * )
     */
    private $newPhoto;

    public function getNewPhoto(): ?UploadedFile
    {
        return $this->newPhoto;
    }

    public function setNewPhoto(?UploadedFile $newPhoto): void
    {
        $this->newPhoto = $newPhoto;
    }
}