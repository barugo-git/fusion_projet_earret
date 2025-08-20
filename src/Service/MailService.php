<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $to, string $subject, string $emailTemplate, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('juridiction@coursupreme.bj', 'Cour Suprême'))
            // Si tu veux utiliser l'autre adresse, tu peux la changer ici
            // ->from(new Address('moussabaka@openkanz.com', 'Cour Suprême'))
            ->to(new Address($to))
            // ->replyTo(new Address('infos@wahici.com'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->htmlTemplate('mailer/' . $emailTemplate)
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Ici tu peux logger l'erreur si nécessaire
        }
    }
}
