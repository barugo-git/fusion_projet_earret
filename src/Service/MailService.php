<?php


namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail(string $to, string $subject, string $emailTemplate, array $context): void
    {
        $email = (new TemplatedEmail())
//            ->from(new Address('infos@wahici.com', 'Wah'))
            ->from(new Address('moussabaka@openkanz.com', 'Cour Suprême'))
            ->to(new Address($to))
//            ->replyTo(new Address('infos@wahici.com'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject($subject)
            ->htmlTemplate('mailer/' . $emailTemplate)
            ->context($context);

        try {
            $this->mailer->send($email);

        } catch (TransportExceptionInterface $e) {

        }
    }

}
