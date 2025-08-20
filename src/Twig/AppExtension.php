<?php
// src/Twig/AppExtension.php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\TwigTest;
use Twig\TwigFunction;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getTests(): array
    {
        return [
            new TwigTest('date', function ($value) {
                return $value instanceof \DateTimeInterface;
            }),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('file_exists', [$this, 'fileExists']),
            new TwigFunction('current_user', [$this, 'getCurrentUser']),
        ];
    }

    public function fileExists(string $path): bool
    {
        return file_exists($path);
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('values', 'array_values'),
        ];
    }

    public function getGlobals(): array
    {
        return [
            'user' => $this->getCurrentUser()
        ];
    }

    public function getCurrentUser()
    {
        return $this->security->getUser();
    }
}