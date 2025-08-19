<?php

namespace App\Service;

class CodeGenerator
{
    public function Generator($longueur = 7)
    {
//        $longueur = 10; // Définir la longueur de la chaîne aléatoire
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Définir les caractères possibles
        $code_aleatoire = '';
        for ($i = 0; $i < $longueur; $i++) {
            $code_aleatoire .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return  $code_aleatoire;
    }
}
