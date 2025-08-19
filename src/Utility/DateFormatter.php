<?php
namespace App\Utility;

class DateFormatter
{
    /**
     * 
     * @param \DateTimeInterface|null $date
     * @return string|null
     */
    public static function formatDateToText(?\DateTimeInterface $date): ?string
    {
        if ($date === null) {
            return null;
        }

        // Tableau des mois en français
        $mois = [
            1 => 'janvier', 2 => 'février', 3 => 'mars', 4 => 'avril',
            5 => 'mai', 6 => 'juin', 7 => 'juillet', 8 => 'août',
            9 => 'septembre', 10 => 'octobre', 11 => 'novembre', 12 => 'décembre'
        ];

        // Formatage de la date avec espace au début
        $jour = $date->format('d');
        $moisTexte = $mois[(int)$date->format('m')];
        $annee = $date->format('Y');

        return sprintf(' ', '%s %s %s', $jour, $moisTexte, $annee);
    }
}